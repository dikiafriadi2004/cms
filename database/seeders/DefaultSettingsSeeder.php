<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Site Information
            ['key' => 'site_name', 'value' => 'My CMS', 'type' => 'text', 'group' => 'general', 'label' => 'Site Name'],
            ['key' => 'site_description', 'value' => 'A modern content management system', 'type' => 'textarea', 'group' => 'general', 'label' => 'Site Description'],
            ['key' => 'site_keywords', 'value' => 'cms, laravel, blog', 'type' => 'text', 'group' => 'general', 'label' => 'Site Keywords'],
            
            // Contact
            ['key' => 'contact_email', 'value' => 'contact@example.com', 'type' => 'email', 'group' => 'contact', 'label' => 'Contact Email'],
            ['key' => 'contact_phone', 'value' => '+62 123 4567 890', 'type' => 'text', 'group' => 'contact', 'label' => 'Contact Phone'],
            ['key' => 'contact_address', 'value' => 'Jakarta, Indonesia', 'type' => 'textarea', 'group' => 'contact', 'label' => 'Contact Address'],
            ['key' => 'contact_form_enabled', 'value' => '1', 'type' => 'boolean', 'group' => 'contact', 'label' => 'Enable Contact Form'],
            
            // Social Media
            ['key' => 'social_facebook', 'value' => '', 'type' => 'url', 'group' => 'social', 'label' => 'Facebook URL'],
            ['key' => 'social_twitter', 'value' => '', 'type' => 'url', 'group' => 'social', 'label' => 'Twitter URL'],
            ['key' => 'social_instagram', 'value' => '', 'type' => 'url', 'group' => 'social', 'label' => 'Instagram URL'],
            ['key' => 'social_linkedin', 'value' => '', 'type' => 'url', 'group' => 'social', 'label' => 'LinkedIn URL'],
            
            // SEO
            ['key' => 'seo_meta_title', 'value' => 'My CMS - Content Management System', 'type' => 'text', 'group' => 'seo', 'label' => 'Default Meta Title'],
            ['key' => 'seo_meta_description', 'value' => 'A modern and powerful content management system built with Laravel', 'type' => 'textarea', 'group' => 'seo', 'label' => 'Default Meta Description'],
            
            // Template
            ['key' => 'active_template', 'value' => 'default', 'type' => 'select', 'group' => 'template', 'label' => 'Active Template'],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('✅ Default settings created successfully!');
    }
}
