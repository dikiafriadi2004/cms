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

        // Trashed filter: ?trashed=only | ?trashed=with
        if ($request->trashed === 'only') {
            $query = Post::onlyTrashed()->with(['user', 'category', 'tags']);
        } elseif ($request->trashed === 'with') {
            $query = Post::withTrashed()->with(['user', 'category', 'tags']);
        }

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
            $search = safe_like_input($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%');
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
            'slug' => [
                'nullable',
                'string',
                \Illuminate\Validation\Rule::unique('posts', 'slug')->whereNull('deleted_at'),
            ],
            'excerpt' => 'nullable|string|max:160',
            'content' => 'required|string',
            'featured_image' => 'nullable|string',
            'status' => 'required|in:draft,published,scheduled',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:100',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:500',
            'focus_keyword' => 'nullable|string|max:1000',
            'published_at' => 'nullable|date',
        ]);

        if (!$validated['slug']) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['user_id'] = Auth::id();

        // Enforce publish permission. Author without `posts.publish` is forced to draft.
        if (in_array($validated['status'], ['published', 'scheduled'])
            && !Auth::user()->can('posts.publish')) {
            $validated['status'] = 'draft';
            unset($validated['published_at']);
        }

        if ($validated['status'] === 'published' && !isset($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        try {
            $post = Post::create($validated);

            // Handle tags - create new tags if needed
            if ($request->filled('tags')) {
                $tagIds = $this->resolveTagIds($request->tags);
                $post->tags()->sync($tagIds);
            }

            return redirect()->route('admin.posts.index')
                ->with('success', 'Post berhasil dibuat!');
                
        } catch (\Exception $e) {
            \Log::error('Post Creation Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'Gagal membuat post: ' . $e->getMessage());
        }
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
            'slug' => [
                'nullable',
                'string',
                \Illuminate\Validation\Rule::unique('posts', 'slug')
                    ->ignore($post->id)
                    ->whereNull('deleted_at'),
            ],
            'excerpt' => 'nullable|string|max:160',
            'content' => 'required|string',
            'featured_image' => 'nullable|string',
            'status' => 'required|in:draft,published,scheduled',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:100',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:500',
            'focus_keyword' => 'nullable|string|max:1000',
            'published_at' => 'nullable|date',
        ]);

        if (!$validated['slug']) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Enforce publish permission on update
        if (in_array($validated['status'], ['published', 'scheduled'])
            && !Auth::user()->can('posts.publish')) {
            $validated['status'] = 'draft';
            unset($validated['published_at']);
        }

        if ($validated['status'] === 'published' && !$post->published_at && !isset($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $post->update($validated);

        // Handle tags - create new tags if needed
        if ($request->has('tags')) {
            $tagIds = $this->resolveTagIds($request->tags ?? []);
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

    /**
     * Resolve tag IDs from input. Each item is either:
     * - 'new:Tag Name' → create or fetch by slug
     * - integer/string id → validate exists in DB
     *
     * Race-safe: handles UNIQUE constraint violation when two requests
     * try to create the same tag simultaneously.
     *
     * @param array<int, string|int> $tagInputs
     * @return array<int, int>
     */
    protected function resolveTagIds(array $tagInputs): array
    {
        $tagIds = [];
        $existingIds = [];

        foreach ($tagInputs as $tagInput) {
            if (is_string($tagInput) && str_starts_with($tagInput, 'new:')) {
                $tagName = trim(substr($tagInput, 4));
                if ($tagName === '') {
                    continue;
                }

                $slug = Str::slug($tagName);

                try {
                    $tag = Tag::firstOrCreate(
                        ['slug' => $slug],
                        ['name' => $tagName, 'is_active' => true]
                    );
                } catch (\Illuminate\Database\QueryException $e) {
                    // UNIQUE violation race: another request inserted the same
                    // slug between our SELECT and INSERT. Re-fetch the row.
                    $tag = Tag::where('slug', $slug)->firstOrFail();
                }

                $tagIds[] = $tag->id;
            } elseif (is_numeric($tagInput)) {
                $existingIds[] = (int) $tagInput;
            }
        }

        if (!empty($existingIds)) {
            // Validate IDs exist in DB before sync — prevents orphan references
            $validIds = Tag::whereIn('id', $existingIds)->pluck('id')->toArray();
            $tagIds = array_merge($tagIds, $validIds);
        }

        return array_values(array_unique($tagIds));
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,publish,draft',
            'posts' => 'required|array|min:1|max:100',
            'posts.*' => 'exists:posts,id',
        ]);

        // Filter post IDs by ownership for author role to prevent
        // information leakage and unauthorized bulk modifications.
        $postIds = $request->posts;
        if (Auth::user()->hasRole('author')) {
            $ownedIds = Post::whereIn('id', $postIds)
                ->where('user_id', Auth::id())
                ->pluck('id')
                ->toArray();

            if (count($ownedIds) !== count($postIds)) {
                return redirect()->route('admin.posts.index')
                    ->with('error', 'Anda tidak memiliki akses untuk melakukan aksi pada beberapa post yang dipilih.');
            }
            $postIds = $ownedIds;
        }

        switch ($request->action) {
            case 'delete':
                // delete() on Eloquent collection does fire deleting/deleted events.
                Post::whereIn('id', $postIds)->get()->each->delete();
                $message = 'Posts berhasil dihapus!';
                break;
            case 'publish':
                // Enforce posts.publish permission for bulk publish
                if (!Auth::user()->can('posts.publish')) {
                    return redirect()->route('admin.posts.index')
                        ->with('error', 'Anda tidak memiliki akses untuk publish post.');
                }
                // Loop to fire model events (cache invalidation, OG/Twitter regen)
                Post::whereIn('id', $postIds)->get()->each(function ($p) {
                    if ($p->status !== 'published' || !$p->published_at) {
                        $p->status = 'published';
                        if (!$p->published_at) {
                            $p->published_at = now();
                        }
                        $p->save();
                    }
                });
                $message = 'Posts berhasil dipublish!';
                break;
            case 'draft':
                Post::whereIn('id', $postIds)->get()->each(function ($p) {
                    $p->status = 'draft';
                    $p->save();
                });
                $message = 'Posts berhasil dijadikan draft!';
                break;
        }

        // Defensive: ensure caches cleared even if events somehow skip.
        Post::clearCache();

        return redirect()->route('admin.posts.index')
            ->with('success', $message);
    }

    /**
     * Restore a soft-deleted post.
     */
    public function restore($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);

        // Author can only restore own posts
        if (Auth::user()->hasRole('author') && $post->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk merestore post ini.');
        }

        $post->restore();
        Post::clearCache();

        return redirect()->route('admin.posts.index', ['trashed' => 'only'])
            ->with('success', 'Post berhasil direstore!');
    }

    /**
     * Permanently delete a soft-deleted post.
     */
    public function forceDestroy($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);

        // Only users with full delete permission can force-delete
        if (!Auth::user()->can('posts.delete')) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus permanen.');
        }

        $post->forceDelete();
        Post::clearCache();

        return redirect()->route('admin.posts.index', ['trashed' => 'only'])
            ->with('success', 'Post berhasil dihapus permanen!');
    }
}