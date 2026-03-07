<?php

namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsCache
{
    /**
     * Cache duration in seconds (1 hour)
     */
    const CACHE_DURATION = 3600;

    /**
     * Get a setting value from cache
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
     * Get all settings from cache
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
     * Flush the settings cache
     *
     * @return void
     */
    public static function flush()
    {
        Cache::forget('settings');
    }

    /**
     * Refresh the settings cache
     *
     * @return \Illuminate\Support\Collection
     */
    public static function refresh()
    {
        self::flush();
        return self::all();
    }
}
