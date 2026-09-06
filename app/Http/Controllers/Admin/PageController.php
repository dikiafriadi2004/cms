<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $query = Page::with('user');

        // Trashed filter: ?trashed=only | ?trashed=with
        if ($request->trashed === 'only') {
            $query = Page::onlyTrashed()->with('user');
        } elseif ($request->trashed === 'with') {
            $query = Page::withTrashed()->with('user');
        }

        // Author can only see their own pages
        if (Auth::user()->hasRole('author')) {
            $query->where('user_id', Auth::id());
        }

        if ($request->filled('search')) {
            $search = safe_like_input($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pages = $query->latest()->paginate(20);

        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                \Illuminate\Validation\Rule::unique('pages', 'slug')->whereNull('deleted_at'),
                // Reserved slugs that conflict with reserved frontend routes.
                'not_in:admin,api,login,logout,register,blog,category,tag,contact,about,sitemap.xml,robots.txt',
            ],
            'content' => 'required|string',
            'featured_image' => 'nullable|string',
            'template' => 'required|string',
            'status' => 'required|in:draft,published',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:500',
            'show_in_menu' => 'boolean',
            'is_homepage' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        if (!$validated['slug']) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['user_id'] = Auth::id();

        // Enforce publish permission. Without `pages.publish` force to draft.
        if ($validated['status'] === 'published' && !Auth::user()->can('pages.publish')) {
            $validated['status'] = 'draft';
        }

        Page::create($validated);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page berhasil dibuat!');
    }

    public function show(Page $page)
    {
        // Author can only view their own pages
        if (Auth::user()->hasRole('author') && $page->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke page ini.');
        }

        $page->load('user');
        return view('admin.pages.show', compact('page'));
    }

    public function edit(Page $page)
    {
        // Check ownership for author role
        if (Auth::user()->hasRole('author')) {
            if ($page->user_id !== Auth::id()) {
                abort(403, 'Anda tidak memiliki akses untuk mengedit page ini.');
            }
        }

        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        // Check ownership for author role
        if (Auth::user()->hasRole('author')) {
            if ($page->user_id !== Auth::id()) {
                abort(403, 'Anda tidak memiliki akses untuk mengedit page ini.');
            }
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                \Illuminate\Validation\Rule::unique('pages', 'slug')
                    ->ignore($page->id)
                    ->whereNull('deleted_at'),
                'not_in:admin,api,login,logout,register,blog,category,tag,contact,about,sitemap.xml,robots.txt',
            ],
            'content' => 'required|string',
            'featured_image' => 'nullable|string',
            'template' => 'required|string',
            'status' => 'required|in:draft,published',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:500',
            'show_in_menu' => 'boolean',
            'is_homepage' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        if (!$validated['slug']) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Enforce publish permission on update
        if ($validated['status'] === 'published' && !Auth::user()->can('pages.publish')) {
            $validated['status'] = 'draft';
        }

        $page->update($validated);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page berhasil diupdate!');
    }

    public function destroy(Page $page)
    {
        if ($page->is_homepage) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Homepage tidak dapat dihapus!'
                ], 400);
            }
            return redirect()->route('admin.pages.index')
                ->with('error', 'Homepage tidak dapat dihapus!');
        }

        // Check ownership for author role
        if (Auth::user()->hasRole('author')) {
            if ($page->user_id !== Auth::id()) {
                if (request()->ajax() || request()->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda tidak memiliki akses untuk menghapus page ini.'
                    ], 403);
                }
                abort(403, 'Anda tidak memiliki akses untuk menghapus page ini.');
            }
        }

        $page->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Page berhasil dihapus!'
            ]);
        }

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page berhasil dihapus!');
    }

    /**
     * Restore a soft-deleted page.
     */
    public function restore($id)
    {
        $page = Page::onlyTrashed()->findOrFail($id);

        if (Auth::user()->hasRole('author') && $page->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk merestore page ini.');
        }

        $page->restore();

        return redirect()->route('admin.pages.index', ['trashed' => 'only'])
            ->with('success', 'Page berhasil direstore!');
    }

    /**
     * Permanently delete a soft-deleted page.
     */
    public function forceDestroy($id)
    {
        $page = Page::onlyTrashed()->findOrFail($id);

        if (!Auth::user()->can('pages.delete')) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus permanen.');
        }

        $page->forceDelete();

        return redirect()->route('admin.pages.index', ['trashed' => 'only'])
            ->with('success', 'Page berhasil dihapus permanen!');
    }
}