<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;

class AdController extends Controller
{
    public function index(Request $request)
    {
        $query = Ad::query();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('position')) {
            $query->where('position', $request->position);
        }

        $ads = $query->orderBy('position')->orderBy('sort_order')->paginate(20);

        return view('admin.ads.index', compact('ads'));
    }

    public function create()
    {
        return view('admin.ads.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:adsense,adsera,manual',
            'position' => 'required|string|in:header,footer,sidebar,content_top,content_bottom,between_posts',
            'code' => 'required|string',
            'is_active' => 'boolean',
            'display_rules' => 'nullable|array',
            'sort_order' => 'integer|min:0',
        ]);

        Ad::create($validated);

        return redirect()->route('admin.ads.index')
            ->with('success', 'Ad berhasil dibuat!');
    }

    public function show(Ad $ad)
    {
        return view('admin.ads.show', compact('ad'));
    }

    public function edit(Ad $ad)
    {
        return view('admin.ads.edit', compact('ad'));
    }

    public function update(Request $request, Ad $ad)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:adsense,adsera,manual',
            'position' => 'required|string|in:header,footer,sidebar,content_top,content_bottom,between_posts',
            'code' => 'required|string',
            'is_active' => 'boolean',
            'display_rules' => 'nullable|array',
            'sort_order' => 'integer|min:0',
        ]);

        $ad->update($validated);

        return redirect()->route('admin.ads.index')
            ->with('success', 'Ad berhasil diupdate!');
    }

    public function destroy(Ad $ad)
    {
        $ad->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Ad berhasil dihapus!'
            ]);
        }

        return redirect()->route('admin.ads.index')
            ->with('success', 'Ad berhasil dihapus!');
    }
}