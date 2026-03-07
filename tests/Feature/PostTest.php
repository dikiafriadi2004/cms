<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user can view published posts
     */
    public function test_user_can_view_published_posts(): void
    {
        $category = Category::factory()->create();
        $user = User::factory()->create();
        
        $post = Post::factory()->create([
            'status' => 'published',
            'published_at' => now()->subDay(),
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);

        $response = $this->get('/blog');

        $response->assertStatus(200);
        $response->assertSee($post->title);
    }

    /**
     * Test user cannot view draft posts
     */
    public function test_user_cannot_view_draft_posts(): void
    {
        $category = Category::factory()->create();
        $user = User::factory()->create();
        
        $post = Post::factory()->create([
            'status' => 'draft',
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);

        $response = $this->get('/blog');

        $response->assertStatus(200);
        $response->assertDontSee($post->title);
    }

    /**
     * Test user can view single post
     */
    public function test_user_can_view_single_post(): void
    {
        $category = Category::factory()->create();
        $user = User::factory()->create();
        
        $post = Post::factory()->create([
            'status' => 'published',
            'published_at' => now()->subDay(),
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);

        $response = $this->get("/blog/{$post->slug}");

        $response->assertStatus(200);
        $response->assertSee($post->title);
        $response->assertSee($post->content);
    }

    /**
     * Test authenticated user can create post
     */
    public function test_authenticated_user_can_create_post(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->post('/admin/posts', [
            'title' => 'Test Post',
            'content' => 'This is test content',
            'excerpt' => 'Test excerpt',
            'status' => 'draft',
            'category_id' => $category->id,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
            'status' => 'draft',
        ]);
    }

    /**
     * Test guest cannot create post
     */
    public function test_guest_cannot_create_post(): void
    {
        $category = Category::factory()->create();

        $response = $this->post('/admin/posts', [
            'title' => 'Test Post',
            'content' => 'This is test content',
            'category_id' => $category->id,
        ]);

        $response->assertRedirect('/login');
    }

    /**
     * Test post SEO score is calculated
     */
    public function test_post_seo_score_is_calculated(): void
    {
        $category = Category::factory()->create();
        $user = User::factory()->create();
        
        $post = Post::factory()->create([
            'title' => 'This is a test post title with good length',
            'content' => str_repeat('This is test content. ', 50),
            'meta_description' => 'This is a meta description with good length for SEO optimization and it should be between 120 and 160 characters long.',
            'focus_keyword' => 'test',
            'featured_image' => 'test.jpg',
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);

        $this->assertGreaterThan(0, $post->seo_score);
        $this->assertLessThanOrEqual(100, $post->seo_score);
    }

    /**
     * Test post views count increments
     */
    public function test_post_views_count_increments(): void
    {
        $category = Category::factory()->create();
        $user = User::factory()->create();
        
        $post = Post::factory()->create([
            'status' => 'published',
            'published_at' => now()->subDay(),
            'category_id' => $category->id,
            'user_id' => $user->id,
            'views_count' => 0,
        ]);

        $this->get("/blog/{$post->slug}");

        $post->refresh();
        $this->assertEquals(1, $post->views_count);
    }

    /**
     * Test post can be filtered by category
     */
    public function test_post_can_be_filtered_by_category(): void
    {
        $category1 = Category::factory()->create(['slug' => 'category-1']);
        $category2 = Category::factory()->create(['slug' => 'category-2']);
        $user = User::factory()->create();
        
        $post1 = Post::factory()->create([
            'status' => 'published',
            'published_at' => now()->subDay(),
            'category_id' => $category1->id,
            'user_id' => $user->id,
        ]);
        
        $post2 = Post::factory()->create([
            'status' => 'published',
            'published_at' => now()->subDay(),
            'category_id' => $category2->id,
            'user_id' => $user->id,
        ]);

        $response = $this->get("/blog?category={$category1->slug}");

        $response->assertStatus(200);
        $response->assertSee($post1->title);
        $response->assertDontSee($post2->title);
    }
}

