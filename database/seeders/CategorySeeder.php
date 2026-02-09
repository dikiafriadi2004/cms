<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Technology',
                'slug' => 'technology',
                'description' => 'Latest technology news, tutorials, and insights',
                'meta_title' => 'Technology Articles & Tutorials',
                'meta_description' => 'Explore the latest in technology, programming, and digital innovation',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Business',
                'slug' => 'business',
                'description' => 'Business strategies, entrepreneurship, and market insights',
                'meta_title' => 'Business & Entrepreneurship',
                'meta_description' => 'Learn about business strategies, startups, and entrepreneurship',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Lifestyle',
                'slug' => 'lifestyle',
                'description' => 'Health, wellness, travel, and lifestyle tips',
                'meta_title' => 'Lifestyle & Wellness',
                'meta_description' => 'Discover tips for healthy living, travel, and lifestyle improvement',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Design',
                'slug' => 'design',
                'description' => 'UI/UX design, graphic design, and creative inspiration',
                'meta_title' => 'Design & Creativity',
                'meta_description' => 'Explore design trends, UI/UX best practices, and creative inspiration',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Marketing',
                'slug' => 'marketing',
                'description' => 'Digital marketing, SEO, and growth strategies',
                'meta_title' => 'Marketing & Growth',
                'meta_description' => 'Learn digital marketing strategies, SEO tips, and growth hacking',
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
