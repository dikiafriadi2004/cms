<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;

return new class extends Migration
{
    public function up(): void
    {
        // Add new hero settings
        $newSettings = [
            [
                'key' => 'hero_badge_text',
                'value' => 'Tersedia di Android & iOS',
                'type' => 'text',
                'group' => 'hero',
                'label' => 'Hero Badge Text',
                'description' => 'Text untuk badge di hero section',
            ],
            [
                'key' => 'hero_button_secondary_text',
                'value' => 'Pelajari Fitur',
                'type' => 'text',
                'group' => 'hero',
                'label' => 'Hero Secondary Button Text',
                'description' => 'Text untuk tombol sekunder di hero section',
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
            'hero_badge_text',
            'hero_button_secondary_text',
        ])->delete();
    }
};
