<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Config;

class MailConfigService
{
    public static function configure(): void
    {
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
            return;
        }

        // Configure mail settings
        Config::set('mail.default', $settings->get('mail_driver', 'smtp'));
        
        Config::set('mail.mailers.smtp', [
            'transport' => 'smtp',
            'host' => $settings->get('mail_host', 'smtp.gmail.com'),
            'port' => $settings->get('mail_port', 587),
            'encryption' => $settings->get('mail_encryption', 'tls'),
            'username' => $settings->get('mail_username'),
            'password' => $settings->get('mail_password'),
            'timeout' => null,
        ]);

        Config::set('mail.from', [
            'address' => $settings->get('mail_from_address', 'noreply@example.com'),
            'name' => $settings->get('mail_from_name', 'Konter Digital'),
        ]);
    }
}
