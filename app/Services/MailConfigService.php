<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class MailConfigService
{
    /**
     * Cache key untuk mail settings
     */
    private const CACHE_KEY = 'mail.runtime.config';

    /**
     * TTL cache (1 jam)
     */
    private const CACHE_TTL = 3600;

    /**
     * Apply mail config dari database settings.
     *
     * Hasil di-cache supaya tidak query setiap request. Cache di-invalidate
     * otomatis saat Setting model di-save (lihat Setting model boot()).
     */
    public static function configure(): void
    {
        $config = Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            $settings = Setting::whereIn('key', [
                'mail_driver',
                'mail_host',
                'mail_port',
                'mail_username',
                'mail_password',
                'mail_encryption',
                'mail_from_address',
                'mail_from_name',
            ])->pluck('value', 'key');

            if ($settings->isEmpty()) {
                return null;
            }

            return [
                'driver' => $settings->get('mail_driver', 'smtp'),
                'host' => $settings->get('mail_host', 'smtp.gmail.com'),
                'port' => (int) $settings->get('mail_port', 587),
                'encryption' => $settings->get('mail_encryption', 'tls'),
                'username' => $settings->get('mail_username'),
                'password' => $settings->get('mail_password'),
                'from_address' => $settings->get('mail_from_address', 'noreply@example.com'),
                'from_name' => $settings->get('mail_from_name', config('app.name')),
            ];
        });

        if ($config === null) {
            return;
        }

        Config::set('mail.default', $config['driver']);
        Config::set('mail.mailers.smtp', [
            'transport' => 'smtp',
            'host' => $config['host'],
            'port' => $config['port'],
            'encryption' => $config['encryption'],
            'username' => $config['username'],
            'password' => $config['password'],
            'timeout' => null,
        ]);
        Config::set('mail.from', [
            'address' => $config['from_address'],
            'name' => $config['from_name'],
        ]);
    }

    /**
     * Invalidate mail config cache. The cache will be rebuilt on the next
     * MailConfigService::configure() call (e.g. on next request boot).
     *
     * Previously this method also re-configured immediately to make the
     * change take effect within the same request. That caused multiple DB
     * queries when several mail_* settings are saved in one update batch.
     * Trade-off: re-configure is deferred to next request, which is fine for
     * mail settings (admin testing email goes through the admin UI which
     * triggers a separate request that picks up fresh config).
     */
    public static function flushCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * Force immediate re-configuration. Call this when you NEED the change
     * to take effect on the current request (e.g. test email button).
     */
    public static function flushAndReconfigure(): void
    {
        Cache::forget(self::CACHE_KEY);
        self::configure();
    }
}
