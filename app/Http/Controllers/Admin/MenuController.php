<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with(['items' => function ($query) {
            $query->whereNull('parent_id')->orderBy('sort_order');
        }])->get();

        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menus.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|in:header,footer,sidebar',
            'is_active' => 'boolean',
        ]);

        Menu::create($validated);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil dibuat!');
    }

    public function show(Menu $menu)
    {
        $menu->load(['items' => function ($query) {
            $query->with('children')->whereNull('parent_id')->orderBy('sort_order');
        }]);

        // Get available items for menu builder
        $pages = Page::published()->get();
        $categories = Category::active()->get();
        $posts = Post::published()->latest()->limit(20)->get();

        return view('admin.menus.show', compact('menu', 'pages', 'categories', 'posts'));
    }

    public function edit(Menu $menu)
    {
        return view('admin.menus.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|in:header,footer,sidebar',
            'is_active' => 'boolean',
        ]);

        $menu->update($validated);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil diupdate!');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil dihapus!'
            ]);
        }

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil dihapus!');
    }

    public function storeItem(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:page,post,category,custom,external',
            'target_id' => 'nullable|integer',
            'url' => 'nullable|string',
            'parent_id' => 'nullable|exists:menu_items,id',
            'target' => 'required|string|in:_self,_blank',
            'css_class' => 'nullable|string',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Validasi: Cek apakah page sudah ada di menu ini
        if ($validated['type'] === 'page' && $validated['target_id']) {
            $exists = MenuItem::where('menu_id', $menu->id)
                ->where('type', 'page')
                ->where('target_id', $validated['target_id'])
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Page ini sudah ada di menu! Setiap page hanya boleh ditambahkan sekali.'
                ], 422);
            }
        }

        // Validasi: Cek apakah category sudah ada di menu ini
        if ($validated['type'] === 'category' && $validated['target_id']) {
            $exists = MenuItem::where('menu_id', $menu->id)
                ->where('type', 'category')
                ->where('target_id', $validated['target_id'])
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category ini sudah ada di menu! Setiap category hanya boleh ditambahkan sekali.'
                ], 422);
            }
        }

        $validated['menu_id'] = $menu->id;

        MenuItem::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Menu item berhasil ditambahkan!'
        ]);
    }

    public function updateItem(Request $request, Menu $menu, MenuItem $item)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:page,post,category,custom,external',
            'target_id' => 'nullable|integer',
            'url' => 'nullable|string',
            'parent_id' => 'nullable|exists:menu_items,id',
            'target' => 'required|string|in:_self,_blank',
            'css_class' => 'nullable|string',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $item->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Menu item berhasil diupdate!'
        ]);
    }

    public function destroyItem(Menu $menu, MenuItem $item)
    {
        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Menu item berhasil dihapus!'
        ]);
    }

    public function reorderItems(Request $request, Menu $menu)
    {
        $items = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:menu_items,id',
            'items.*.sort_order' => 'required|integer|min:0',
            'items.*.parent_id' => 'nullable|exists:menu_items,id',
        ])['items'];

        foreach ($items as $itemData) {
            MenuItem::where('id', $itemData['id'])->update([
                'sort_order' => $itemData['sort_order'],
                'parent_id' => $itemData['parent_id'],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Menu order berhasil diupdate!'
        ]);
    }
}