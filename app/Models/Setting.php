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

    public static function get(string $key, $default = null)
    {
        return Cache::remember("setting.{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            
            if (!$setting) {
                return $default;
            }

            return match ($setting->type) {
                'boolean' => (bool) $setting->value,
                'json' => json_decode($setting->value, true),
                'file' => $setting->value ? url('storage/' . $setting->value) : $default,
                default => $setting->value ?: $default,
            };
        });
    }

    public static function set(string $key, $value): void
    {
        $setting = static::firstOrCreate(['key' => $key]);
        
        $setting->value = match ($setting->type) {
            'boolean' => $value ? '1' : '0',
            'json' => json_encode($value),
            default => $value,
        };
        
        $setting->save();
        
        Cache::forget("setting.{$key}");
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
                        'json' => json_decode($setting->value, true),
                        'file' => $setting->value ? asset('storage/' . $setting->value) : null,
                        default => $setting->value,
                    };
                    
                    return [$setting->key => $value];
                })
                ->toArray();
        });
    }

    public static function clearCache(): void
    {
        Cache::flush();
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($setting) {
            Cache::forget("setting.{$setting->key}");
            Cache::forget("settings.group.{$setting->group}");
        });

        static::deleted(function ($setting) {
            Cache::forget("setting.{$setting->key}");
            Cache::forget("settings.group.{$setting->group}");
        });
    }
}