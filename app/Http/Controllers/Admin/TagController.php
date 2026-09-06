<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $query = Tag::withCount('posts');

        if ($request->filled('search')) {
            $search = safe_like_input($request->search);
            $query->where('name', 'like', '%' . $search . '%');
        }

        $tags = $query->latest()->paginate(20);

        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:tags,slug',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'is_active' => 'boolean',
        ]);

        if (!$validated['slug']) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        Tag::create($validated);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag berhasil dibuat!');
    }

    public function show(Tag $tag)
    {
        $tag->load(['posts' => function ($query) {
            $query->latest()->limit(10);
        }]);

        return view('admin.tags.show', compact('tag'));
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:tags,slug,' . $tag->id,
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'is_active' => 'boolean',
        ]);

        if (!$validated['slug']) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $tag->update($validated);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag berhasil diupdate!');
    }

    public function destroy(Tag $tag)
    {
        // Warn admin if tag has posts. The cascade pivot delete still happens
        // via DB constraint, but the admin should consciously confirm.
        $postCount = $tag->posts()->count();
        if ($postCount > 0 && !request()->boolean('force')) {
            $message = "Tag ini terhubung dengan {$postCount} post. "
                . "Hapus tag akan melepas tag dari semua post tersebut. "
                . "Kirim ulang dengan parameter force=1 untuk konfirmasi.";

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'requires_confirmation' => true,
                    'post_count' => $postCount,
                    'message' => $message,
                ], 409);
            }
            return redirect()->route('admin.tags.index')->with('error', $message);
        }

        $tag->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Tag berhasil dihapus!'
            ]);
        }

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag berhasil dihapus!');
    }

    public function search(Request $request)
    {
        $request->validate(['q' => 'nullable|string|max:200']);
        $query = safe_like_input($request->get('q', ''));

        $tags = Tag::where('is_active', true)
            ->where('name', 'like', '%' . $query . '%')
            ->limit(10)
            ->get()
            ->map(function ($tag) {
                return [
                    'id' => $tag->id,
                    'text' => $tag->name
                ];
            });

        return response()->json($tags);
    }
}