<?php

namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

/**
 * Lightweight aggregate-cache helper for settings.
 *
 * Returns RAW values (path/string) — same contract as direct DB column access.
 * For typed values (URL for files, bool, decoded JSON), use Setting::get($key).
 *
 * NOTE: Both APIs return different shapes by design:
 * - SettingsCache::get('logo') → 'settings/abc.png' (raw path)
 * - Setting::get('logo')       → 'https://...'      (typed URL)
 *
 * Use SettingsCache when you need the bag of all settings (e.g. inject into views),
 * use Setting::get when you need a single typed value.
 */
class SettingsCache
{
    /**
     * Cache duration in seconds (1 hour)
     */
    const CACHE_DURATION = 3600;

    /**
     * Get a raw setting value from cache.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        $settings = self::all();
        return $settings->get($key, $default);
    }

    /**
     * Get all settings as a Collection of raw values (key => value).
     *
     * @return \Illuminate\Support\Collection
     */
    public static function all()
    {
        return Cache::remember('settings', self::CACHE_DURATION, function () {
            return Setting::all()->pluck('value', 'key');
        });
    }

    /**
     * Resolve a 'file' type setting to a public URL. Falls back to default
     * if the setting is empty or the file does not physically exist.
     */
    public static function fileUrl(string $key, ?string $default = null): ?string
    {
        $path = self::get($key);
        if (!$path) {
            return $default;
        }

        // Validate physical file exists to avoid broken <img> tags
        $absolute = public_path('storage/' . ltrim($path, '/'));
        if (!file_exists($absolute)) {
            return $default;
        }

        return asset('storage/' . ltrim($path, '/'));
    }

    /**
     * Flush the settings cache
     */
    public static function flush(): void
    {
        Cache::forget('settings');
    }

    /**
     * Refresh the settings cache
     */
    public static function refresh()
    {
        self::flush();
        return self::all();
    }
}
