<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;

return new class extends Migration
{
    public function up(): void
    {
        // Add about page statistics settings
        $newSettings = [
            [
                'key' => 'about_stat_1_number',
                'value' => '50K+',
                'type' => 'text',
                'group' => 'about',
                'label' => 'About Statistik 1 - Angka',
                'description' => 'Angka statistik pertama di halaman about',
            ],
            [
                'key' => 'about_stat_1_label',
                'value' => 'Agen Aktif',
                'type' => 'text',
                'group' => 'about',
                'label' => 'About Statistik 1 - Label',
                'description' => 'Label statistik pertama di halaman about',
            ],
            [
                'key' => 'about_stat_2_number',
                'value' => '1M+',
                'type' => 'text',
                'group' => 'about',
                'label' => 'About Statistik 2 - Angka',
                'description' => 'Angka statistik kedua di halaman about',
            ],
            [
                'key' => 'about_stat_2_label',
                'value' => 'Transaksi/Bulan',
                'type' => 'text',
                'group' => 'about',
                'label' => 'About Statistik 2 - Label',
                'description' => 'Label statistik kedua di halaman about',
            ],
        ];

        foreach ($newSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }

    public function down(): void
    {
        Setting::whereIn('key', [
            'about_stat_1_number',
            'about_stat_1_label',
            'about_stat_2_number',
            'about_stat_2_label',
        ])->delete();
    }
};
