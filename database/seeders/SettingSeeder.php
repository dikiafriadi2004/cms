<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'key' => 'site_name',
                'value' => 'Konter Digital CMS',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Site Name',
                'description' => 'Nama situs yang akan ditampilkan di header dan title',
                'sort_order' => 1,
            ],
            [
                'key' => 'site_description',
                'value' => 'Platform CMS modern untuk membuat landing page dan blog yang SEO-friendly',
                'type' => 'textarea',
                'group' => 'general',
                'label' => 'Site Description',
                'description' => 'Deskripsi singkat tentang situs',
                'sort_order' => 2,
            ],
            [
                'key' => 'site_url',
                'value' => 'http://127.0.0.1:8000',
                'type' => 'url',
                'group' => 'general',
                'label' => 'Site URL',
                'description' => 'URL lengkap situs',
                'sort_order' => 3,
            ],
            [
                'key' => 'admin_email',
                'value' => 'admin@konterdigital.com',
                'type' => 'email',
                'group' => 'general',
                'label' => 'Admin Email',
                'description' => 'Email administrator',
                'sort_order' => 4,
            ],
            [
                'key' => 'contact_email',
                'value' => 'contact@konterdigital.com',
                'type' => 'email',
                'group' => 'general',
                'label' => 'Contact Email',
                'description' => 'Email untuk kontak publik dan penerima contact form',
                'sort_order' => 5,
            ],
            [
                'key' => 'contact_phone',
                'value' => '+62 812-3456-7890',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Contact Phone',
                'description' => 'Nomor telepon untuk kontak publik',
                'sort_order' => 6,
            ],
            [
                'key' => 'contact_address',
                'value' => 'Jl. Contoh No. 123, Jakarta Selatan, DKI Jakarta 12345',
                'type' => 'textarea',
                'group' => 'general',
                'label' => 'Contact Address',
                'description' => 'Alamat lengkap untuk kontak publik',
                'sort_order' => 7,
            ],

            // Branding
            [
                'key' => 'logo',
                'value' => null,
                'type' => 'file',
                'group' => 'branding',
                'label' => 'Logo',
                'description' => 'Logo situs (PNG/SVG)',
                'sort_order' => 1,
            ],
            [
                'key' => 'favicon',
                'value' => null,
                'type' => 'file',
                'group' => 'branding',
                'label' => 'Favicon',
                'description' => 'Icon kecil yang ditampilkan di tab browser',
                'sort_order' => 2,
            ],

            // SEO Settings
            [
                'key' => 'meta_title',
                'value' => 'Konter Digital CMS - CMS Canggih untuk Landing Page dan Blog',
                'type' => 'text',
                'group' => 'seo',
                'label' => 'Default Meta Title',
                'description' => 'Title default untuk halaman yang tidak memiliki meta title',
                'sort_order' => 1,
            ],
            [
                'key' => 'meta_description',
                'value' => 'Platform CMS modern untuk membuat landing page dan blog yang SEO-friendly dengan fitur lengkap dan mudah digunakan.',
                'type' => 'textarea',
                'group' => 'seo',
                'label' => 'Default Meta Description',
                'description' => 'Description default untuk halaman yang tidak memiliki meta description',
                'sort_order' => 2,
            ],
            [
                'key' => 'meta_keywords',
                'value' => 'cms, landing page, blog, seo, content management',
                'type' => 'text',
                'group' => 'seo',
                'label' => 'Default Meta Keywords',
                'description' => 'Keywords default untuk SEO',
                'sort_order' => 3,
            ],

            // Analytics Settings
            [
                'key' => 'google_analytics_id',
                'value' => null,
                'type' => 'text',
                'group' => 'analytics',
                'label' => 'Google Analytics ID',
                'description' => 'Google Analytics Tracking ID (GA4)',
                'sort_order' => 1,
            ],
            [
                'key' => 'google_tag_manager_id',
                'value' => null,
                'type' => 'text',
                'group' => 'analytics',
                'label' => 'Google Tag Manager ID',
                'description' => 'Google Tag Manager Container ID',
                'sort_order' => 2,
            ],
            [
                'key' => 'facebook_pixel_id',
                'value' => null,
                'type' => 'text',
                'group' => 'analytics',
                'label' => 'Facebook Pixel ID',
                'description' => 'Facebook Pixel ID untuk tracking',
                'sort_order' => 3,
            ],

            // Social Media Settings
            [
                'key' => 'facebook_url',
                'value' => null,
                'type' => 'url',
                'group' => 'social',
                'label' => 'Facebook URL',
                'description' => 'Link ke halaman Facebook',
                'sort_order' => 1,
            ],
            [
                'key' => 'instagram_url',
                'value' => null,
                'type' => 'url',
                'group' => 'social',
                'label' => 'Instagram URL',
                'description' => 'Link ke halaman Instagram',
                'sort_order' => 2,
            ],
            [
                'key' => 'twitter_url',
                'value' => null,
                'type' => 'url',
                'group' => 'social',
                'label' => 'Twitter URL',
                'description' => 'Link ke halaman Twitter',
                'sort_order' => 3,
            ],
            [
                'key' => 'telegram_url',
                'value' => null,
                'type' => 'url',
                'group' => 'social',
                'label' => 'Telegram URL',
                'description' => 'Link ke channel Telegram',
                'sort_order' => 4,
            ],
            [
                'key' => 'whatsapp_number',
                'value' => null,
                'type' => 'text',
                'group' => 'social',
                'label' => 'WhatsApp Number',
                'description' => 'Nomor WhatsApp (format: +628123456789)',
                'sort_order' => 5,
            ],
            [
                'key' => 'youtube_url',
                'value' => null,
                'type' => 'url',
                'group' => 'social',
                'label' => 'YouTube URL',
                'description' => 'Link ke channel YouTube',
                'sort_order' => 6,
            ],

            // Footer Settings
            [
                'key' => 'footer_text',
                'value' => '© 2026 Konter Digital. All rights reserved.',
                'type' => 'text',
                'group' => 'footer',
                'label' => 'Footer Copyright Text',
                'description' => 'Teks copyright di footer',
                'sort_order' => 1,
            ],
            [
                'key' => 'footer_about',
                'value' => 'Konter Digital adalah platform CMS modern yang memudahkan Anda membuat landing page dan blog profesional dengan fitur SEO yang powerful.',
                'type' => 'textarea',
                'group' => 'footer',
                'label' => 'Footer About Text',
                'description' => 'Teks deskripsi tentang perusahaan di footer',
                'sort_order' => 2,
            ],
            
            // Email Configuration
            [
                'key' => 'mail_driver',
                'value' => 'smtp',
                'type' => 'select',
                'options' => 'smtp,sendmail,mailgun,ses,postmark,log',
                'group' => 'email',
                'label' => 'Mail Driver',
                'description' => 'Email service provider',
                'sort_order' => 1,
            ],
            [
                'key' => 'mail_host',
                'value' => 'smtp.gmail.com',
                'type' => 'text',
                'group' => 'email',
                'label' => 'Mail Host',
                'description' => 'SMTP server host (e.g., smtp.gmail.com)',
                'sort_order' => 2,
            ],
            [
                'key' => 'mail_port',
                'value' => '587',
                'type' => 'number',
                'group' => 'email',
                'label' => 'Mail Port',
                'description' => 'SMTP port (587 for TLS, 465 for SSL)',
                'sort_order' => 3,
            ],
            [
                'key' => 'mail_username',
                'value' => '',
                'type' => 'text',
                'group' => 'email',
                'label' => 'Mail Username',
                'description' => 'SMTP username / email address',
                'sort_order' => 4,
            ],
            [
                'key' => 'mail_password',
                'value' => '',
                'type' => 'password',
                'group' => 'email',
                'label' => 'Mail Password',
                'description' => 'SMTP password / app password',
                'sort_order' => 5,
            ],
            [
                'key' => 'mail_encryption',
                'value' => 'tls',
                'type' => 'select',
                'options' => 'tls,ssl,none',
                'group' => 'email',
                'label' => 'Mail Encryption',
                'description' => 'Encryption method',
                'sort_order' => 6,
            ],
            [
                'key' => 'mail_from_address',
                'value' => 'noreply@konterdigital.com',
                'type' => 'email',
                'group' => 'email',
                'label' => 'Mail From Address',
                'description' => 'Default sender email address',
                'sort_order' => 7,
            ],
            [
                'key' => 'mail_from_name',
                'value' => 'Konter Digital',
                'type' => 'text',
                'group' => 'email',
                'label' => 'Mail From Name',
                'description' => 'Default sender name',
                'sort_order' => 8,
            ],
            [
                'key' => 'contact_form_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'email',
                'label' => 'Enable Contact Form',
                'description' => 'Enable or disable contact form submissions',
                'sort_order' => 9,
            ],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}