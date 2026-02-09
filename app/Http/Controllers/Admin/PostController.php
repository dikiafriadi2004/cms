<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'category', 'tags']);

        // Author can only see their own posts
        if (Auth::user()->hasRole('author')) {
            $query->where('user_id', Auth::id());
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        $posts = $query->latest()->paginate(20);
        $categories = Category::active()->get();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        $tags = Tag::active()->get();
        
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:posts,slug',
            'excerpt' => 'nullable|string|max:160',
            'content' => 'required|string',
            'featured_image' => 'nullable|string',
            'status' => 'required|in:draft,published,scheduled',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
            'canonical_url' => 'nullable|url',
            'focus_keyword' => 'nullable|string',
            'published_at' => 'nullable|date',
        ]);

        if (!$validated['slug']) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['user_id'] = Auth::id();

        if ($validated['status'] === 'published' && !isset($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $post = Post::create($validated);

        // Handle tags - create new tags if needed
        if ($request->filled('tags')) {
            $tagIds = [];
            foreach ($request->tags as $tagInput) {
                if (str_starts_with($tagInput, 'new:')) {
                    // Create new tag
                    $tagName = substr($tagInput, 4); // Remove 'new:' prefix
                    $tag = Tag::firstOrCreate(
                        ['slug' => Str::slug($tagName)],
                        [
                            'name' => $tagName,
                            'is_active' => true
                        ]
                    );
                    $tagIds[] = $tag->id;
                } else {
                    // Existing tag
                    $tagIds[] = $tagInput;
                }
            }
            $post->tags()->sync($tagIds);
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post berhasil dibuat!');
    }

    public function show(Post $post)
    {
        // Author can only view their own posts
        if (Auth::user()->hasRole('author') && $post->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke post ini.');
        }

        $post->load(['user', 'category', 'tags']);
        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        // Check ownership for author role
        if (Auth::user()->hasRole('author')) {
            if ($post->user_id !== Auth::id()) {
                abort(403, 'Anda tidak memiliki akses untuk mengedit post ini.');
            }
        }

        $categories = Category::active()->get();
        $tags = Tag::active()->get();
        $post->load('tags');
        
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, Post $post)
    {
        // Check ownership for author role
        if (Auth::user()->hasRole('author')) {
            if ($post->user_id !== Auth::id()) {
                abort(403, 'Anda tidak memiliki akses untuk mengedit post ini.');
            }
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:posts,slug,' . $post->id,
            'excerpt' => 'nullable|string|max:160',
            'content' => 'required|string',
            'featured_image' => 'nullable|string',
            'status' => 'required|in:draft,published,scheduled',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
            'canonical_url' => 'nullable|url',
            'focus_keyword' => 'nullable|string',
            'published_at' => 'nullable|date',
        ]);

        if (!$validated['slug']) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($validated['status'] === 'published' && !$post->published_at && !isset($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $post->update($validated);

        // Handle tags - create new tags if needed
        if ($request->has('tags')) {
            $tagIds = [];
            foreach ($request->tags ?? [] as $tagInput) {
                if (str_starts_with($tagInput, 'new:')) {
                    // Create new tag
                    $tagName = substr($tagInput, 4); // Remove 'new:' prefix
                    $tag = Tag::firstOrCreate(
                        ['slug' => Str::slug($tagName)],
                        [
                            'name' => $tagName,
                            'is_active' => true
                        ]
                    );
                    $tagIds[] = $tag->id;
                } else {
                    // Existing tag
                    $tagIds[] = $tagInput;
                }
            }
            $post->tags()->sync($tagIds);
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post berhasil diupdate!');
    }

    public function destroy(Post $post)
    {
        // Check ownership for author role
        if (Auth::user()->hasRole('author')) {
            if ($post->user_id !== Auth::id()) {
                if (request()->ajax() || request()->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda tidak memiliki akses untuk menghapus post ini.'
                    ], 403);
                }
                abort(403, 'Anda tidak memiliki akses untuk menghapus post ini.');
            }
        }

        $post->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Post berhasil dihapus!'
            ]);
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post berhasil dihapus!');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,publish,draft',
            'posts' => 'required|array',
            'posts.*' => 'exists:posts,id',
        ]);

        $posts = Post::whereIn('id', $request->posts);

        switch ($request->action) {
            case 'delete':
                $posts->delete();
                $message = 'Posts berhasil dihapus!';
                break;
            case 'publish':
                $posts->update(['status' => 'published', 'published_at' => now()]);
                $message = 'Posts berhasil dipublish!';
                break;
            case 'draft':
                $posts->update(['status' => 'draft']);
                $message = 'Posts berhasil dijadikan draft!';
                break;
        }

        return redirect()->route('admin.posts.index')
            ->with('success', $message);
    }
}