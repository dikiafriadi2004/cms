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
            $query->where('name', 'like', '%' . $request->search . '%');
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
        $query = $request->get('q', '');
        
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