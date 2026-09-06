<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Ad;
use App\Services\TemplateService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:200',
            'category' => 'nullable|string|max:100',
        ]);

        $query = Post::published()
            ->with(['user', 'category', 'tags'])
            ->latest('published_at');

        // Search functionality
        if ($request->filled('search')) {
            $search = safe_like_input($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Category filter
        $selectedCategory = null;
        if ($request->filled('category')) {
            $categorySlug = $request->category;
            $selectedCategory = Category::where('slug', $categorySlug)->first();
            
            if ($selectedCategory) {
                $query->where('category_id', $selectedCategory->id);
            }
        }

        $posts = $query->paginate(9);
        if ($request->integer('page', 1) > $posts->lastPage() && $posts->lastPage() > 0) {
            abort(404);
        }
        $categories = Category::active()->withCount('publishedPosts')->get();
        $popularPosts = Post::popular(5);

        // Get ads for blog index page
        $context = ['page' => 'blog_index'];
        $ads = [
            'content_top' => Ad::getByPosition('content_top', $context),
            'between_posts' => Ad::getByPosition('between_posts', $context),
            'sidebar' => Ad::getByPosition('sidebar', $context),
        ];

        // Get template view
        $template = TemplateService::getCurrentTemplate();
        $view = TemplateService::getView($template, 'blog.index');

        // If AJAX request, return only posts HTML
        if ($request->ajax()) {
            return response()->json([
                'html' => view('frontend.templates.default.blog.partials.posts-grid', compact('posts'))->render(),
                'pagination' => $posts->onEachSide(1)->links('partials.pagination-custom')->render(),
                'total' => $posts->total(),
            ]);
        }

        return view($view, compact('posts', 'categories', 'popularPosts', 'ads', 'selectedCategory'));
    }

    public function show(Post $post)
    {
        if (!$post->isPublished()) {
            abort(404);
        }

        // Idempotent view tracking: only count once per IP+post per hour.
        // Use raw UPDATE to bypass model events — increment() would trigger
        // saving/saved which recompute SEO score and bust caches every view.
        $viewKey = sprintf('post:viewed:%d:%s', $post->id, sha1(request()->ip()));
        if (!\Illuminate\Support\Facades\Cache::has($viewKey)) {
            \Illuminate\Support\Facades\Cache::put($viewKey, 1, now()->addHour());
            \Illuminate\Support\Facades\DB::table('posts')
                ->where('id', $post->id)
                ->update(['views_count' => \Illuminate\Support\Facades\DB::raw('views_count + 1')]);
        }

        // Eager load tags BEFORE building related-posts query to avoid N+1.
        $post->load(['user', 'category', 'tags']);

        // Get related posts
        $relatedPosts = Post::published()
            ->with(['user', 'category', 'tags'])
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

        // Popular posts excluding current post (cannot reuse Post::popular()
        // cache since this filter is per-post). Limit to 5 with eager-loaded relations.
        $popularPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->with(['user', 'category'])
            ->orderBy('views_count', 'desc')
            ->limit(5)
            ->get();

        // Get ads for blog detail page
        $context = [
            'page' => 'blog_detail',
            'post' => $post->id,
            'category' => $post->category_id,
        ];
        
        $ads = [
            'content_top' => Ad::getByPosition('content_top', $context),
            'content_bottom' => Ad::getByPosition('content_bottom', $context),
            'sidebar' => Ad::getByPosition('sidebar', $context),
        ];

        // Get template view
        $template = TemplateService::getCurrentTemplate();
        $view = TemplateService::getView($template, 'blog.show');

        return view($view, compact('post', 'relatedPosts', 'popularPosts', 'ads'));
    }

    public function category(Category $category)
    {
        if (!$category->is_active) {
            abort(404);
        }

        $posts = $category->publishedPosts()
            ->with(['user', 'tags'])
            ->latest('published_at')
            ->paginate(9);

        $categories = Category::active()->withCount('publishedPosts')->get();

        // Get ads for category page
        $context = [
            'page' => 'blog_category',
            'category' => $category->id,
        ];
        $ads = [
            'content_top' => Ad::getByPosition('content_top', $context),
            'between_posts' => Ad::getByPosition('between_posts', $context),
            'sidebar' => Ad::getByPosition('sidebar', $context),
        ];

        // Get template view
        $template = TemplateService::getCurrentTemplate();
        $view = TemplateService::getView($template, 'blog.category');

        return view($view, compact('category', 'posts', 'categories', 'ads'));
    }

    public function tag(Tag $tag)
    {
        if (!$tag->is_active) {
            abort(404);
        }

        $posts = $tag->publishedPosts()
            ->with(['user', 'category'])
            ->latest('published_at')
            ->paginate(9);

        // Get ads for tag page
        $context = ['page' => 'blog_tag'];
        $ads = [
            'content_top' => Ad::getByPosition('content_top', $context),
            'between_posts' => Ad::getByPosition('between_posts', $context),
            'sidebar' => Ad::getByPosition('sidebar', $context),
        ];

        // Get template view
        $template = TemplateService::getCurrentTemplate();
        $view = TemplateService::getView($template, 'blog.tag');

        return view($view, compact('tag', 'posts', 'ads'));
    }
}