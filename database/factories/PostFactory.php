<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'slug' => fake()->unique()->slug(),
            'excerpt' => fake()->paragraph(),
            'content' => fake()->paragraphs(5, true),
            'featured_image' => null,
            'status' => 'published',
            'category_id' => \App\Models\Category::factory(),
            'user_id' => \App\Models\User::factory(),
            'meta_title' => fake()->sentence(),
            'meta_description' => fake()->paragraph(),
            'meta_keywords' => implode(', ', fake()->words(5)),
            'focus_keyword' => fake()->word(),
            'seo_score' => fake()->numberBetween(0, 100),
            'views_count' => fake()->numberBetween(0, 1000),
            'reading_time' => fake()->numberBetween(1, 10),
            'published_at' => now(),
        ];
    }
}
