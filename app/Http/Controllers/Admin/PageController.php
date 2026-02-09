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

        // Author can only see their own pages
        if (Auth::user()->hasRole('author')) {
            $query->where('user_id', Auth::id());
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
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
            'slug' => 'nullable|string|unique:pages,slug',
            'content' => 'required|string',
            'template' => 'required|string',
            'status' => 'required|in:draft,published',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
            'canonical_url' => 'nullable|url',
            'show_in_menu' => 'boolean',
            'is_homepage' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        if (!$validated['slug']) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['user_id'] = Auth::id();

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
            'slug' => 'nullable|string|unique:pages,slug,' . $page->id,
            'content' => 'required|string',
            'template' => 'required|string',
            'status' => 'required|in:draft,published',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
            'canonical_url' => 'nullable|url',
            'show_in_menu' => 'boolean',
            'is_homepage' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        if (!$validated['slug']) {
            $validated['slug'] = Str::slug($validated['title']);
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
}