<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;

return new class extends Migration
{
    public function up(): void
    {
        // Remove unused hero statistics settings
        Setting::whereIn('key', [
            'hero_stat_1_number',
            'hero_stat_1_label',
            'hero_stat_2_number',
            'hero_stat_2_label',
            'hero_stat_3_number',
            'hero_stat_3_label',
        ])->delete();
    }

    public function down(): void
    {
        // Restore the settings if needed
        $settings = [
            [
                'key' => 'hero_stat_1_number',
                'value' => '10K+',
                'type' => 'text',
                'group' => 'hero',
                'label' => 'Statistik 1 - Angka',
                'description' => 'Angka statistik pertama',
            ],
            [
                'key' => 'hero_stat_1_label',
                'value' => 'Pengguna Aktif',
                'type' => 'text',
                'group' => 'hero',
                'label' => 'Statistik 1 - Label',
                'description' => 'Label statistik pertama',
            ],
            [
                'key' => 'hero_stat_2_number',
                'value' => '50K+',
                'type' => 'text',
                'group' => 'hero',
                'label' => 'Statistik 2 - Angka',
                'description' => 'Angka statistik kedua',
            ],
            [
                'key' => 'hero_stat_2_label',
                'value' => 'Transaksi/Hari',
                'type' => 'text',
                'group' => 'hero',
                'label' => 'Statistik 2 - Label',
                'description' => 'Label statistik kedua',
            ],
            [
                'key' => 'hero_stat_3_number',
                'value' => '4.8★',
                'type' => 'text',
                'group' => 'hero',
                'label' => 'Statistik 3 - Angka',
                'description' => 'Angka statistik ketiga',
            ],
            [
                'key' => 'hero_stat_3_label',
                'value' => 'Rating Aplikasi',
                'type' => 'text',
                'group' => 'hero',
                'label' => 'Statistik 3 - Label',
                'description' => 'Label statistik ketiga',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
};
