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
            'type' => 'required|string|in:adsense,adsera,manual,image',
            'position' => 'required|string|in:header,footer,sidebar,content_top,content_bottom,between_posts,in_content',
            'code' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'link' => 'nullable|url|max:500',
            'open_new_tab' => 'boolean',
            'is_active' => 'boolean',
            'display_rules' => 'nullable|array',
            'sort_order' => 'integer|min:0',
            'in_content_paragraph' => 'nullable|integer|min:1',
            'size_preset' => 'nullable|string|in:auto,small,medium,large,custom',
            'custom_width' => 'nullable|integer|min:50|max:2000',
            'custom_height' => 'nullable|integer|min:50|max:2000',
        ]);

        // Handle image upload with resize
        if ($request->hasFile('image')) {
            $validated['image'] = $this->handleImageUpload(
                $request->file('image'),
                $request->input('position'),
                $request->input('size_preset', 'medium'),
                $request->input('custom_width'),
                $request->input('custom_height')
            );
        }

        // Set open_new_tab default
        $validated['open_new_tab'] = $request->has('open_new_tab');

        Ad::create($validated);

        return redirect()->route('admin.ads.index')
            ->with('success', 'Ad berhasil dibuat!');
    }

    /**
     * Handle image upload and resize based on preset
     */
    protected function handleImageUpload($file, $position, $sizePreset, $customWidth = null, $customHeight = null)
    {
        // Get target dimensions
        $dimensions = $this->getTargetDimensions($position, $sizePreset, $customWidth, $customHeight);
        
        // Load image using Intervention Image
        $manager = new \Intervention\Image\ImageManager(
            new \Intervention\Image\Drivers\Gd\Driver()
        );
        
        $image = $manager->read($file->getRealPath());
        
        // Resize image maintaining aspect ratio
        if ($dimensions['width'] && $dimensions['height']) {
            // Both width and height specified - cover the area
            $image->cover($dimensions['width'], $dimensions['height']);
        } elseif ($dimensions['width']) {
            // Only width specified - scale to width
            $image->scale(width: $dimensions['width']);
        } elseif ($dimensions['height']) {
            // Only height specified - scale to height
            $image->scale(height: $dimensions['height']);
        }
        
        // Generate filename
        $filename = uniqid() . '_' . time() . '.jpg';
        $path = storage_path('app/public/ads/' . $filename);
        
        // Ensure directory exists
        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }
        
        // Save as JPEG with quality 85
        $image->toJpeg(85)->save($path);
        
        return 'ads/' . $filename;
    }

    /**
     * Get target dimensions based on position and preset
     */
    protected function getTargetDimensions($position, $preset, $customWidth = null, $customHeight = null)
    {
        // Custom size
        if ($preset === 'custom') {
            return [
                'width' => $customWidth,
                'height' => $customHeight,
            ];
        }
        
        // Preset dimensions by position
        $presets = [
            'small' => [
                'header' => ['width' => 468, 'height' => 60],
                'footer' => ['width' => 468, 'height' => 60],
                'sidebar' => ['width' => 200, 'height' => 200],
                'content_top' => ['width' => 468, 'height' => 60],
                'content_bottom' => ['width' => 468, 'height' => 60],
                'in_content' => ['width' => 468, 'height' => 60],
                'between_posts' => ['width' => 468, 'height' => 60],
            ],
            'medium' => [
                'header' => ['width' => 728, 'height' => 90],
                'footer' => ['width' => 728, 'height' => 90],
                'sidebar' => ['width' => 300, 'height' => 250],
                'content_top' => ['width' => 728, 'height' => 90],
                'content_bottom' => ['width' => 728, 'height' => 90],
                'in_content' => ['width' => 600, 'height' => 200],
                'between_posts' => ['width' => 728, 'height' => 90],
            ],
            'large' => [
                'header' => ['width' => 970, 'height' => 90],
                'footer' => ['width' => 970, 'height' => 90],
                'sidebar' => ['width' => 400, 'height' => 400],
                'content_top' => ['width' => 970, 'height' => 90],
                'content_bottom' => ['width' => 970, 'height' => 90],
                'in_content' => ['width' => 800, 'height' => 250],
                'between_posts' => ['width' => 970, 'height' => 90],
            ],
            'auto' => [
                'header' => ['width' => 1200, 'height' => null],
                'footer' => ['width' => 1200, 'height' => null],
                'sidebar' => ['width' => 500, 'height' => null],
                'content_top' => ['width' => 1200, 'height' => null],
                'content_bottom' => ['width' => 1200, 'height' => null],
                'in_content' => ['width' => 1000, 'height' => null],
                'between_posts' => ['width' => 1200, 'height' => null],
            ],
        ];
        
        return $presets[$preset][$position] ?? $presets['medium'][$position];
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
            'type' => 'required|string|in:adsense,adsera,manual,image',
            'position' => 'required|string|in:header,footer,sidebar,content_top,content_bottom,between_posts,in_content',
            'code' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'link' => 'nullable|url|max:500',
            'open_new_tab' => 'boolean',
            'is_active' => 'boolean',
            'display_rules' => 'nullable|array',
            'sort_order' => 'integer|min:0',
            'in_content_paragraph' => 'nullable|integer|min:1',
            'size_preset' => 'nullable|string|in:auto,small,medium,large,custom',
            'custom_width' => 'nullable|integer|min:50|max:2000',
            'custom_height' => 'nullable|integer|min:50|max:2000',
        ]);

        // Handle image upload with resize
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($ad->image && \Storage::disk('public')->exists($ad->image)) {
                \Storage::disk('public')->delete($ad->image);
            }
            
            $validated['image'] = $this->handleImageUpload(
                $request->file('image'),
                $request->input('position'),
                $request->input('size_preset', 'medium'),
                $request->input('custom_width'),
                $request->input('custom_height')
            );
        }

        // Handle image removal
        if ($request->has('remove_image') && $request->remove_image) {
            if ($ad->image && \Storage::disk('public')->exists($ad->image)) {
                \Storage::disk('public')->delete($ad->image);
            }
            $validated['image'] = null;
        }

        // Set open_new_tab
        $validated['open_new_tab'] = $request->has('open_new_tab');

        $ad->update($validated);

        return redirect()->route('admin.ads.index')
            ->with('success', 'Ad berhasil diupdate!');
    }

    public function destroy(Ad $ad)
    {
        // Delete image if exists
        if ($ad->image && \Storage::disk('public')->exists($ad->image)) {
            \Storage::disk('public')->delete($ad->image);
        }

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