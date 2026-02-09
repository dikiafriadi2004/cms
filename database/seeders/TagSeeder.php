<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            ['name' => 'Laravel', 'slug' => 'laravel', 'is_active' => true],
            ['name' => 'PHP', 'slug' => 'php', 'is_active' => true],
            ['name' => 'JavaScript', 'slug' => 'javascript', 'is_active' => true],
            ['name' => 'Vue.js', 'slug' => 'vuejs', 'is_active' => true],
            ['name' => 'React', 'slug' => 'react', 'is_active' => true],
            ['name' => 'Tailwind CSS', 'slug' => 'tailwind-css', 'is_active' => true],
            ['name' => 'Web Development', 'slug' => 'web-development', 'is_active' => true],
            ['name' => 'Tutorial', 'slug' => 'tutorial', 'is_active' => true],
            ['name' => 'Tips & Tricks', 'slug' => 'tips-tricks', 'is_active' => true],
            ['name' => 'Best Practices', 'slug' => 'best-practices', 'is_active' => true],
            ['name' => 'SEO', 'slug' => 'seo', 'is_active' => true],
            ['name' => 'Performance', 'slug' => 'performance', 'is_active' => true],
            ['name' => 'Security', 'slug' => 'security', 'is_active' => true],
            ['name' => 'Database', 'slug' => 'database', 'is_active' => true],
            ['name' => 'API', 'slug' => 'api', 'is_active' => true],
        ];

        foreach ($tags as $tag) {
            Tag::updateOrCreate(
                ['slug' => $tag['slug']],
                $tag
            );
        }
    }
}
