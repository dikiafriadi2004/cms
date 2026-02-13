<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ad;
use App\Models\AdAnalytic;
use Carbon\Carbon;

class AdAnalyticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ads = Ad::all();
        
        if ($ads->isEmpty()) {
            $this->command->warn('No ads found. Please run AdSeeder first.');
            return;
        }

        $this->command->info('Generating sample analytics data...');

        $devices = ['desktop', 'mobile', 'tablet'];
        $browsers = ['Chrome', 'Firefox', 'Safari', 'Edge', 'Opera'];
        $os = ['Windows', 'macOS', 'Linux', 'Android', 'iOS'];
        $pageTypes = ['home', 'blog_index', 'blog_detail', 'blog_category', 'static_page'];

        // Generate data for last 30 days
        foreach ($ads as $ad) {
            for ($i = 29; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                
                // Generate impressions (random between 50-500 per day)
                $impressionsCount = rand(50, 500);
                for ($j = 0; $j < $impressionsCount; $j++) {
                    AdAnalytic::create([
                        'ad_id' => $ad->id,
                        'event_type' => 'impression',
                        'page_url' => 'https://example.com/page-' . rand(1, 10),
                        'page_type' => $pageTypes[array_rand($pageTypes)],
                        'referrer' => rand(0, 1) ? 'https://google.com' : null,
                        'user_agent' => 'Mozilla/5.0',
                        'ip_address' => rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255),
                        'device_type' => $devices[array_rand($devices)],
                        'browser' => $browsers[array_rand($browsers)],
                        'os' => $os[array_rand($os)],
                        'event_date' => $date->copy()->addHours(rand(0, 23))->addMinutes(rand(0, 59)),
                    ]);
                }
                
                // Generate clicks (1-5% CTR)
                $clicksCount = rand($impressionsCount * 0.01, $impressionsCount * 0.05);
                for ($j = 0; $j < $clicksCount; $j++) {
                    AdAnalytic::create([
                        'ad_id' => $ad->id,
                        'event_type' => 'click',
                        'page_url' => 'https://example.com/page-' . rand(1, 10),
                        'page_type' => $pageTypes[array_rand($pageTypes)],
                        'referrer' => rand(0, 1) ? 'https://google.com' : null,
                        'user_agent' => 'Mozilla/5.0',
                        'ip_address' => rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255),
                        'device_type' => $devices[array_rand($devices)],
                        'browser' => $browsers[array_rand($browsers)],
                        'os' => $os[array_rand($os)],
                        'event_date' => $date->copy()->addHours(rand(0, 23))->addMinutes(rand(0, 59)),
                    ]);
                }
            }
            
            $this->command->info("Generated analytics for: {$ad->name}");
        }

        $this->command->info('Sample analytics data generated successfully!');
    }
}
