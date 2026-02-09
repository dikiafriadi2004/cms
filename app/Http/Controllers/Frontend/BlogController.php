<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Setting;
use App\Models\Menu;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    private function getCommonData()
    {
        return [
            'settings' => Setting::pluck('value', 'key')->toArray(),
            'headerMenu' => Menu::where('location', 'header')->with(['items' => function($query) {
                $query->where('is_active', true)->whereNull('parent_id')->orderBy('sort_order')->with('children');
            }])->first(),
            'footerMenu' => Menu::where('location', 'footer')->with(['items' => function($query) {
                $query->where('is_active', true)->whereNull('parent_id')->orderBy('sort_order');
            }])->first(),
        ];
    }

    public function index(Request $request)
    {
        $query = Post::published()
            ->with(['user', 'category', 'tags'])
            ->latest('published_at');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $posts = $query->paginate(12);
        $categories = Category::active()->withCount('publishedPosts')->get();
        $popularPosts = Post::published()
            ->orderBy('views_count', 'desc')
            ->limit(5)
            ->get();

        return view('frontend.blog.index', array_merge(
            $this->getCommonData(),
            compact('posts', 'categories', 'popularPosts')
        ));
    }

    public function show(Post $post)
    {
        if (!$post->isPublished()) {
            abort(404);
        }

        // Increment view count
        $post->increment('views_count');

        // Get related posts
        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->where(function ($query) use ($post) {
                if ($post->category_id) {
                    $query->where('category_id', $post->category_id);
                }
                
                if ($post->tags->count() > 0) {
                    $query->orWhereHas('tags', function ($q) use ($post) {
                        $q->whereIn('tags.id', $post->tags->pluck('id'));
                    });
                }
            })
            ->limit(4)
            ->get();

        $post->load(['user', 'category', 'tags']);

        return view('frontend.blog.show', array_merge(
            $this->getCommonData(),
            compact('post', 'relatedPosts')
        ));
    }

    public function category(Category $category)
    {
        if (!$category->is_active) {
            abort(404);
        }

        $posts = $category->publishedPosts()
            ->with(['user', 'tags'])
            ->latest('published_at')
            ->paginate(12);

        return view('frontend.blog.category', array_merge(
            $this->getCommonData(),
            compact('category', 'posts')
        ));
    }

    public function tag(Tag $tag)
    {
        if (!$tag->is_active) {
            abort(404);
        }

        $posts = $tag->publishedPosts()
            ->with(['user', 'category'])
            ->latest('published_at')
            ->paginate(12);

        return view('frontend.blog.tag', array_merge(
            $this->getCommonData(),
            compact('tag', 'posts')
        ));
    }
}