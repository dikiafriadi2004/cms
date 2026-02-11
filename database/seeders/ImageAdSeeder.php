<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ad;

class ImageAdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Contoh ads dengan gambar dan link
     */
    public function run(): void
    {
        $imageAds = [
            // Banner Image - Header
            [
                'name' => 'Banner Promo Ramadan - Header',
                'type' => 'image',
                'position' => 'header',
                'code' => null, // Tidak perlu code karena menggunakan image
                'image' => 'ads/banner-header.jpg', // Path relatif dari storage/app/public
                'link' => 'https://example.com/promo-ramadan',
                'open_new_tab' => true,
                'is_active' => true,
                'display_rules' => null, // Tampil di semua halaman
                'sort_order' => 1,
            ],

            // Sidebar Image Ad
            [
                'name' => 'Download App - Sidebar',
                'type' => 'image',
                'position' => 'sidebar',
                'code' => null,
                'image' => 'ads/sidebar-app.jpg',
                'link' => 'https://play.google.com/store/apps/details?id=com.example.app',
                'open_new_tab' => true,
                'is_active' => true,
                'display_rules' => [
                    'pages' => ['blog_detail', 'blog_index'],
                ],
                'sort_order' => 1,
            ],

            // Content Top Image Ad
            [
                'name' => 'Promo Pulsa - Content Top',
                'type' => 'image',
                'position' => 'content_top',
                'code' => null,
                'image' => 'ads/promo-pulsa.jpg',
                'link' => '/promo/pulsa-murah',
                'open_new_tab' => false, // Buka di tab yang sama
                'is_active' => true,
                'display_rules' => [
                    'pages' => ['blog_detail'],
                ],
                'sort_order' => 1,
            ],

            // Between Posts Image Ad
            [
                'name' => 'Banner Kerjasama - Between Posts',
                'type' => 'image',
                'position' => 'between_posts',
                'code' => null,
                'image' => 'ads/kerjasama-banner.jpg',
                'link' => '/partnership',
                'open_new_tab' => false,
                'is_active' => true,
                'display_rules' => [
                    'pages' => ['blog_index'],
                ],
                'sort_order' => 1,
            ],

            // Footer Image Ad
            [
                'name' => 'Footer Banner - Promo Akhir Tahun',
                'type' => 'image',
                'position' => 'footer',
                'code' => null,
                'image' => 'ads/footer-promo.jpg',
                'link' => 'https://example.com/promo-akhir-tahun',
                'open_new_tab' => true,
                'is_active' => true,
                'display_rules' => null,
                'sort_order' => 1,
            ],
        ];

        foreach ($imageAds as $ad) {
            Ad::create($ad);
        }

        $this->command->info('✅ Image Ads seeded successfully!');
        $this->command->info('📊 Total image ads created: ' . count($imageAds));
        $this->command->newLine();
        $this->command->warn('⚠️  PENTING: Upload gambar ads ke folder storage/app/public/ads/');
        $this->command->info('   Contoh path:');
        $this->command->info('   - storage/app/public/ads/banner-header.jpg');
        $this->command->info('   - storage/app/public/ads/sidebar-app.jpg');
        $this->command->info('   - storage/app/public/ads/promo-pulsa.jpg');
        $this->command->newLine();
        $this->command->info('💡 Atau edit ads di admin panel dan upload gambar dari sana.');
    }
}
