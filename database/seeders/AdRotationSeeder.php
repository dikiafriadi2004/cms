<?php

namespace Database\Seeders;

use App\Models\Ad;
use Illuminate\Database\Seeder;

class AdRotationSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create 3 ads in sidebar rotation group with random mode
        Ad::create([
            'name' => 'Sidebar Ad 1 - Random Group',
            'type' => 'manual',
            'position' => 'sidebar',
            'rotation_group' => 'sidebar-random',
            'rotation_mode' => 'random',
            'rotation_weight' => 1,
            'code' => '<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px; border-radius: 8px; color: white; text-align: center;"><h3>Promo 1</h3><p>Special Offer!</p></div>',
            'is_active' => true,
            'sort_order' => 0,
        ]);

        Ad::create([
            'name' => 'Sidebar Ad 2 - Random Group',
            'type' => 'manual',
            'position' => 'sidebar',
            'rotation_group' => 'sidebar-random',
            'rotation_mode' => 'random',
            'rotation_weight' => 1,
            'code' => '<div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); padding: 20px; border-radius: 8px; color: white; text-align: center;"><h3>Promo 2</h3><p>Limited Time!</p></div>',
            'is_active' => true,
            'sort_order' => 0,
        ]);

        Ad::create([
            'name' => 'Sidebar Ad 3 - Random Group',
            'type' => 'manual',
            'position' => 'sidebar',
            'rotation_group' => 'sidebar-random',
            'rotation_mode' => 'random',
            'rotation_weight' => 1,
            'code' => '<div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); padding: 20px; border-radius: 8px; color: white; text-align: center;"><h3>Promo 3</h3><p>Best Deal!</p></div>',
            'is_active' => true,
            'sort_order' => 0,
        ]);

        // Create 3 ads in header rotation group with weighted mode
        Ad::create([
            'name' => 'Header Ad 1 - Weighted (High)',
            'type' => 'manual',
            'position' => 'header',
            'rotation_group' => 'header-weighted',
            'rotation_mode' => 'weighted',
            'rotation_weight' => 50, // High weight - shows more often
            'code' => '<div style="background: #10b981; padding: 15px; text-align: center; color: white; font-weight: bold;">🎯 Premium Ad - High Priority (Weight: 50)</div>',
            'is_active' => true,
            'sort_order' => 0,
        ]);

        Ad::create([
            'name' => 'Header Ad 2 - Weighted (Medium)',
            'type' => 'manual',
            'position' => 'header',
            'rotation_group' => 'header-weighted',
            'rotation_mode' => 'weighted',
            'rotation_weight' => 30, // Medium weight
            'code' => '<div style="background: #3b82f6; padding: 15px; text-align: center; color: white; font-weight: bold;">⭐ Standard Ad - Medium Priority (Weight: 30)</div>',
            'is_active' => true,
            'sort_order' => 0,
        ]);

        Ad::create([
            'name' => 'Header Ad 3 - Weighted (Low)',
            'type' => 'manual',
            'position' => 'header',
            'rotation_group' => 'header-weighted',
            'rotation_mode' => 'weighted',
            'rotation_weight' => 20, // Low weight
            'code' => '<div style="background: #6b7280; padding: 15px; text-align: center; color: white; font-weight: bold;">💡 Basic Ad - Low Priority (Weight: 20)</div>',
            'is_active' => true,
            'sort_order' => 0,
        ]);

        // Create 3 ads in content_top rotation group with sequential mode
        Ad::create([
            'name' => 'Content Top Ad 1 - Sequential',
            'type' => 'manual',
            'position' => 'content_top',
            'rotation_group' => 'content-sequential',
            'rotation_mode' => 'sequential',
            'rotation_weight' => 1,
            'code' => '<div style="background: linear-gradient(90deg, #ff6b6b 0%, #ee5a6f 100%); padding: 20px; text-align: center; color: white; border-radius: 8px;"><strong>Ad Slot A</strong> - Rotates evenly based on impressions</div>',
            'is_active' => true,
            'sort_order' => 0,
        ]);

        Ad::create([
            'name' => 'Content Top Ad 2 - Sequential',
            'type' => 'manual',
            'position' => 'content_top',
            'rotation_group' => 'content-sequential',
            'rotation_mode' => 'sequential',
            'rotation_weight' => 1,
            'code' => '<div style="background: linear-gradient(90deg, #4ecdc4 0%, #44a08d 100%); padding: 20px; text-align: center; color: white; border-radius: 8px;"><strong>Ad Slot B</strong> - Rotates evenly based on impressions</div>',
            'is_active' => true,
            'sort_order' => 0,
        ]);

        Ad::create([
            'name' => 'Content Top Ad 3 - Sequential',
            'type' => 'manual',
            'position' => 'content_top',
            'rotation_group' => 'content-sequential',
            'rotation_mode' => 'sequential',
            'rotation_weight' => 1,
            'code' => '<div style="background: linear-gradient(90deg, #f7b733 0%, #fc4a1a 100%); padding: 20px; text-align: center; color: white; border-radius: 8px;"><strong>Ad Slot C</strong> - Rotates evenly based on impressions</div>',
            'is_active' => true,
            'sort_order' => 0,
        ]);

        // Create a standalone ad (no rotation)
        Ad::create([
            'name' => 'Footer Ad - No Rotation',
            'type' => 'manual',
            'position' => 'footer',
            'rotation_group' => null,
            'rotation_mode' => 'random',
            'rotation_weight' => 1,
            'code' => '<div style="background: #1f2937; padding: 20px; text-align: center; color: white; border-radius: 8px;">📢 Static Footer Ad - Always Shows (No Rotation)</div>',
            'is_active' => true,
            'sort_order' => 0,
        ]);

        $this->command->info('✅ Ad rotation test data created successfully!');
        $this->command->info('   - 3 ads in sidebar-random group (Random mode)');
        $this->command->info('   - 3 ads in header-weighted group (Weighted mode: 50, 30, 20)');
        $this->command->info('   - 3 ads in content-sequential group (Sequential mode)');
        $this->command->info('   - 1 standalone footer ad (No rotation)');
    }
}
