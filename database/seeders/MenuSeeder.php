<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\MenuItem;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Create Header Menu
        $headerMenu = Menu::firstOrCreate(
            ['location' => 'header'],
            [
                'name' => 'Header Menu',
                'is_active' => true,
            ]
        );

        // Header Menu Items
        $menuItems = [
            ['title' => 'Home', 'url' => '/', 'sort_order' => 1],
            ['title' => 'Blog', 'url' => '/blog', 'sort_order' => 2],
            ['title' => 'Contact', 'url' => '/contact', 'sort_order' => 3],
        ];

        foreach ($menuItems as $item) {
            MenuItem::firstOrCreate(
                [
                    'menu_id' => $headerMenu->id,
                    'title' => $item['title'],
                ],
                [
                    'url' => $item['url'],
                    'type' => 'custom',
                    'sort_order' => $item['sort_order'],
                    'target' => '_self',
                    'is_active' => true,
                ]
            );
        }

        // Create Footer Menu
        $footerMenu = Menu::firstOrCreate(
            ['location' => 'footer'],
            [
                'name' => 'Footer Menu',
                'is_active' => true,
            ]
        );

        // Footer Menu Items
        $footerItems = [
            ['title' => 'About Us', 'url' => '/about', 'sort_order' => 1],
            ['title' => 'Privacy Policy', 'url' => '/privacy', 'sort_order' => 2],
            ['title' => 'Terms of Service', 'url' => '/terms', 'sort_order' => 3],
            ['title' => 'Contact', 'url' => '/contact', 'sort_order' => 4],
        ];

        foreach ($footerItems as $item) {
            MenuItem::firstOrCreate(
                [
                    'menu_id' => $footerMenu->id,
                    'title' => $item['title'],
                ],
                [
                    'url' => $item['url'],
                    'type' => 'custom',
                    'sort_order' => $item['sort_order'],
                    'target' => '_self',
                    'is_active' => true,
                ]
            );
        }
    }
}
