<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ad;

class AdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ads = [
            // Header Ads (untuk homepage)
            [
                'name' => 'Header Banner - Homepage',
                'type' => 'manual',
                'position' => 'header',
                'code' => '<div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white text-center py-3 px-4">
    <p class="text-sm font-semibold">🎉 Promo Spesial! Daftar sekarang dan dapatkan bonus saldo Rp 50.000 - <a href="#" class="underline font-bold">Klaim Sekarang</a></p>
</div>',
                'is_active' => true,
                'display_rules' => [
                    'pages' => ['home'],
                ],
                'sort_order' => 1,
            ],

            // Content Top - Blog Detail
            [
                'name' => 'Content Top - Blog Detail',
                'type' => 'adsense',
                'position' => 'content_top',
                'code' => '<!-- Google AdSense - Horizontal Banner -->
<div class="text-center my-6">
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-XXXXXXXXXXXXXXXX"
         data-ad-slot="1234567890"
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
    <script>
         (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>',
                'is_active' => true,
                'display_rules' => [
                    'pages' => ['blog_detail'],
                ],
                'sort_order' => 1,
            ],

            // Content Bottom - Blog Detail
            [
                'name' => 'Content Bottom - Blog Detail',
                'type' => 'manual',
                'position' => 'content_bottom',
                'code' => '<div class="bg-gradient-to-br from-brand-50 to-indigo-50 rounded-2xl p-8 text-center border border-brand-100">
    <h3 class="text-2xl font-bold text-brand-900 mb-3">Tertarik Menjadi Mitra Kami?</h3>
    <p class="text-slate-600 mb-6">Bergabunglah dengan ribuan mitra sukses lainnya dan raih penghasilan tambahan</p>
    <a href="#" class="inline-block px-8 py-3 bg-brand-600 text-white font-bold rounded-xl hover:bg-brand-700 transition">
        Daftar Sekarang
    </a>
</div>',
                'is_active' => true,
                'display_rules' => [
                    'pages' => ['blog_detail'],
                ],
                'sort_order' => 1,
            ],

            // Sidebar - Blog Detail
            [
                'name' => 'Sidebar - Blog Detail',
                'type' => 'manual',
                'position' => 'sidebar',
                'code' => '<div class="bg-white border border-slate-100 rounded-2xl p-6 text-center shadow-sm sticky top-28">
    <div class="w-16 h-16 bg-brand-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
    </div>
    <h4 class="font-bold text-slate-900 mb-2">Download Aplikasi</h4>
    <p class="text-sm text-slate-500 mb-4">Kelola bisnis lebih mudah dengan aplikasi mobile</p>
    <a href="#" class="block w-full py-2 bg-brand-600 text-white text-sm font-bold rounded-lg hover:bg-brand-700 transition">
        Download Sekarang
    </a>
</div>',
                'is_active' => true,
                'display_rules' => [
                    'pages' => ['blog_detail', 'blog_index'],
                ],
                'sort_order' => 1,
            ],

            // Between Posts - Blog Index
            [
                'name' => 'Between Posts - Blog Index',
                'type' => 'manual',
                'position' => 'between_posts',
                'code' => '<div class="col-span-full bg-gradient-to-r from-green-50 to-emerald-50 rounded-3xl p-8 border border-green-100">
    <div class="flex flex-col md:flex-row items-center gap-6">
        <div class="flex-shrink-0">
            <div class="w-20 h-20 bg-green-500 rounded-2xl flex items-center justify-center">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
        </div>
        <div class="flex-1 text-center md:text-left">
            <h3 class="text-xl font-bold text-slate-900 mb-2">Transaksi Lebih Cepat dengan Aplikasi</h3>
            <p class="text-slate-600">Proses transaksi hanya dalam hitungan detik. Download sekarang dan rasakan kemudahannya!</p>
        </div>
        <div class="flex-shrink-0">
            <a href="#" class="px-6 py-3 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 transition">
                Download Gratis
            </a>
        </div>
    </div>
</div>',
                'is_active' => true,
                'display_rules' => [
                    'pages' => ['blog_index'],
                ],
                'sort_order' => 1,
            ],

            // Content Top - Static Page
            [
                'name' => 'Content Top - Static Pages',
                'type' => 'manual',
                'position' => 'content_top',
                'code' => '<div class="bg-blue-50 border-l-4 border-blue-500 rounded-r-2xl p-6 mb-8">
    <div class="flex items-start gap-4">
        <div class="flex-shrink-0">
            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <h4 class="font-bold text-blue-900 mb-1">Informasi Penting</h4>
            <p class="text-sm text-blue-700">Pastikan Anda membaca seluruh kebijakan dengan seksama untuk memahami hak dan kewajiban Anda.</p>
        </div>
    </div>
</div>',
                'is_active' => true,
                'display_rules' => [
                    'pages' => ['static_page'],
                ],
                'sort_order' => 1,
            ],

            // Footer - Global
            [
                'name' => 'Footer Banner - Global',
                'type' => 'manual',
                'position' => 'footer',
                'code' => '<div class="bg-gradient-to-r from-purple-600 to-pink-600 text-white text-center py-4 px-4">
    <div class="max-w-4xl mx-auto">
        <p class="text-sm font-semibold mb-2">💰 Dapatkan Komisi Hingga 10% dari Setiap Transaksi Downline!</p>
        <a href="#" class="inline-block px-6 py-2 bg-white text-purple-600 font-bold rounded-lg hover:bg-purple-50 transition text-sm">
            Pelajari Lebih Lanjut
        </a>
    </div>
</div>',
                'is_active' => true,
                'display_rules' => null, // Tampil di semua halaman
                'sort_order' => 1,
            ],

            // Sidebar - Blog Index
            [
                'name' => 'Sidebar Widget - Blog Index',
                'type' => 'manual',
                'position' => 'sidebar',
                'code' => '<div class="bg-gradient-to-br from-orange-50 to-red-50 rounded-2xl p-6 border border-orange-100">
    <div class="text-center">
        <div class="text-4xl mb-3">🎁</div>
        <h4 class="font-bold text-slate-900 mb-2">Promo Hari Ini</h4>
        <p class="text-sm text-slate-600 mb-4">Cashback 5% untuk semua transaksi pulsa</p>
        <div class="bg-white rounded-lg p-3 mb-4">
            <p class="text-xs text-slate-500 mb-1">Kode Promo:</p>
            <p class="text-xl font-bold text-orange-600">PULSA5</p>
        </div>
        <a href="#" class="block w-full py-2 bg-orange-600 text-white text-sm font-bold rounded-lg hover:bg-orange-700 transition">
            Gunakan Sekarang
        </a>
    </div>
</div>',
                'is_active' => true,
                'display_rules' => [
                    'pages' => ['blog_index'],
                ],
                'sort_order' => 2,
            ],

            // Content Bottom - Static Page
            [
                'name' => 'Content Bottom - Static Pages',
                'type' => 'manual',
                'position' => 'content_bottom',
                'code' => '<div class="bg-slate-50 rounded-2xl p-8 text-center border border-slate-200">
    <h4 class="text-xl font-bold text-slate-900 mb-3">Masih Ada Pertanyaan?</h4>
    <p class="text-slate-600 mb-6">Tim customer service kami siap membantu Anda 24/7</p>
    <div class="flex flex-col sm:flex-row gap-3 justify-center">
        <a href="#" class="px-6 py-3 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 transition inline-flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            Chat WhatsApp
        </a>
        <a href="#" class="px-6 py-3 bg-brand-600 text-white font-bold rounded-xl hover:bg-brand-700 transition">
            Hubungi Kami
        </a>
    </div>
</div>',
                'is_active' => true,
                'display_rules' => [
                    'pages' => ['static_page'],
                ],
                'sort_order' => 1,
            ],
        ];

        foreach ($ads as $ad) {
            Ad::create($ad);
        }

        $this->command->info('✅ Ads seeded successfully!');
        $this->command->info('📊 Total ads created: ' . count($ads));
        $this->command->newLine();
        $this->command->info('Ads by position:');
        $this->command->info('  - header: 1 ad');
        $this->command->info('  - content_top: 2 ads');
        $this->command->info('  - content_bottom: 3 ads');
        $this->command->info('  - sidebar: 3 ads');
        $this->command->info('  - between_posts: 1 ad');
        $this->command->info('  - footer: 1 ad');
    }
}
