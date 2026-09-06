<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
        'options',
        'sort_order',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    /**
     * List of setting keys that hold sensitive data (passwords, API tokens).
     * Values for these keys are transparently encrypted at rest.
     */
    private const SENSITIVE_KEYS = [
        'mail_password',
        'ga_credentials_json',
    ];

    /**
     * Mutate value: encrypt sensitive fields before storing.
     */
    public function setValueAttribute($value): void
    {
        $key = $this->attributes['key'] ?? null;
        if ($value !== null && $key && in_array($key, self::SENSITIVE_KEYS, true)) {
            try {
                $value = \Illuminate\Support\Facades\Crypt::encryptString($value);
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning(
                    'Failed to encrypt sensitive setting: ' . $e->getMessage()
                );
            }
        }
        $this->attributes['value'] = $value;
    }

    /**
     * Accessor: decrypt sensitive fields when reading.
     * Wrapped in try/catch so legacy plaintext values still work.
     */
    public function getValueAttribute($value)
    {
        $key = $this->attributes['key'] ?? null;
        if ($value !== null && $key && in_array($key, self::SENSITIVE_KEYS, true)) {
            try {
                return \Illuminate\Support\Facades\Crypt::decryptString($value);
            } catch (\Throwable $e) {
                return $value;
            }
        }
        return $value;
    }

    public static function get(string $key, $default = null)
    {
        return Cache::remember("setting.{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();

            if (!$setting) {
                return $default;
            }

            return match ($setting->type) {
                'boolean' => (bool) $setting->value,
                'json' => static::decodeJsonValue($setting->value, $key, $default),
                'file' => static::resolveFileValue($setting->value, $default),
                default => $setting->value ?: $default,
            };
        });
    }

    /**
     * Decode JSON value with logging on parse failure (avoid silent null).
     */
    protected static function decodeJsonValue($value, string $key, $default)
    {
        if (!$value) {
            return $default;
        }
        $decoded = json_decode($value, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            \Illuminate\Support\Facades\Log::warning(
                "Setting '{$key}' has invalid JSON: " . json_last_error_msg()
            );
            return $default;
        }
        return $decoded;
    }

    /**
     * Resolve a 'file' type to URL only if the file physically exists.
     */
    protected static function resolveFileValue($value, $default)
    {
        if (!$value) {
            return $default;
        }
        $absolute = public_path('storage/' . ltrim($value, '/'));
        if (!file_exists($absolute)) {
            return $default;
        }
        return url('storage/' . ltrim($value, '/'));
    }

    /**
     * Update a setting value. Refuses to create a new key blindly because
     * a key without explicit type/group makes downstream consumers
     * read incorrect values. Use the admin Settings UI to create keys.
     */
    public static function set(string $key, $value): void
    {
        $setting = static::where('key', $key)->first();

        if (!$setting) {
            throw new \InvalidArgumentException(
                "Setting key '{$key}' does not exist. Define it via the admin "
                . "Settings UI (which provides type and group) before calling Setting::set()."
            );
        }

        $setting->value = match ($setting->type) {
            'boolean' => $value ? '1' : '0',
            'json' => json_encode($value),
            default => $value,
        };

        $setting->save();
        // Cache invalidation handled by boot::saved
    }

    public static function getByGroup(string $group): array
    {
        return Cache::remember("settings.group.{$group}", 3600, function () use ($group) {
            return static::where('group', $group)
                ->orderBy('sort_order')
                ->get()
                ->mapWithKeys(function ($setting) {
                    $value = match ($setting->type) {
                        'boolean' => (bool) $setting->value,
                        'json' => static::decodeJsonValue($setting->value, $setting->key, null),
                        'file' => $setting->value ? asset('storage/' . $setting->value) : null,
                        default => $setting->value,
                    };

                    return [$setting->key => $value];
                })
                ->toArray();
        });
    }

    /**
     * Clear all settings cache. Boot::saved already forgets per-key entries,
     * so this is mainly used after bulk migration / refresh actions.
     */
    public static function clearCache(): void
    {
        // Forget per-key entries
        static::query()->pluck('key')->each(function ($key) {
            Cache::forget("setting.{$key}");
        });

        // Forget per-group entries
        static::query()->select('group')->distinct()->pluck('group')->each(function ($group) {
            Cache::forget("settings.group.{$group}");
        });

        // Forget aggregate cache used by SettingsCache helper
        Cache::forget('settings');
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($setting) {
            Cache::forget("setting.{$setting->key}");
            Cache::forget("settings.group.{$setting->group}");
            Cache::forget('settings');

            // Invalidate mail config cache when any mail_* setting changes
            if (str_starts_with($setting->key, 'mail_')) {
                \App\Services\MailConfigService::flushCache();
            }

            // Invalidate sitemap if robots_txt or any URL-affecting setting changes
            if (in_array($setting->key, ['robots_txt', 'site_name', 'site_description'], true)) {
                \App\Http\Controllers\SitemapController::flushCache();
            }
        });

        static::deleted(function ($setting) {
            Cache::forget("setting.{$setting->key}");
            Cache::forget("settings.group.{$setting->group}");
            Cache::forget('settings');

            if (str_starts_with($setting->key, 'mail_')) {
                \App\Services\MailConfigService::flushCache();
            }
        });
    }
}
