@extends('layouts.admin')

@section('title', 'Create Ad')
@section('page-title', 'Create New Ad')

@section('content')
<div class="max-w-3xl">
    <form action="{{ route('admin.ads.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Basic Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
            
            <div class="space-y-4">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        Ad Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        placeholder="e.g., Homepage Sidebar Ad"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror">
                    <p class="mt-1 text-xs text-gray-500">Internal name for identification</p>
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">
                        Ad Type <span class="text-red-500">*</span>
                    </label>
                    <select name="type" id="type" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('type') border-red-500 @enderror">
                        <option value="">Select ad type...</option>
                        <option value="image" {{ old('type') == 'image' ? 'selected' : '' }}>Image Banner (Upload)</option>
                        <option value="adsense" {{ old('type') == 'adsense' ? 'selected' : '' }}>Google AdSense</option>
                        <option value="adsera" {{ old('type') == 'adsera' ? 'selected' : '' }}>Adsera</option>
                        <option value="manual" {{ old('type') == 'manual' ? 'selected' : '' }}>Manual HTML</option>
                    </select>
                    @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Position -->
                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700 mb-1">
                        Position <span class="text-red-500">*</span>
                    </label>
                    <select name="position" id="position" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('position') border-red-500 @enderror">
                        <option value="">Select position...</option>
                        <option value="header" {{ old('position') == 'header' ? 'selected' : '' }}>Header</option>
                        <option value="footer" {{ old('position') == 'footer' ? 'selected' : '' }}>Footer</option>
                        <option value="sidebar" {{ old('position') == 'sidebar' ? 'selected' : '' }}>Sidebar</option>
                        <option value="content_top" {{ old('position') == 'content_top' ? 'selected' : '' }}>Content Top</option>
                        <option value="content_bottom" {{ old('position') == 'content_bottom' ? 'selected' : '' }}>Content Bottom</option>
                        <option value="in_content" {{ old('position') == 'in_content' ? 'selected' : '' }}>In Content (Di Tengah Artikel)</option>
                        <option value="between_posts" {{ old('position') == 'between_posts' ? 'selected' : '' }}>Between Posts</option>
                    </select>
                    @error('position')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- In Content Paragraph (only for in_content position) -->
                <div id="inContentParagraphField" style="display: none;">
                    <label for="in_content_paragraph" class="block text-sm font-medium text-gray-700 mb-1">
                        Paragraph Number <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="in_content_paragraph" id="in_content_paragraph" value="{{ old('in_content_paragraph', 3) }}" min="1"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('in_content_paragraph') border-red-500 @enderror">
                    <p class="mt-1 text-xs text-gray-500">Ads akan muncul setelah paragraf ke-berapa (contoh: 3 = setelah paragraf ketiga)</p>
                    @error('in_content_paragraph')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sort Order -->
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">
                        Sort Order
                    </label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('sort_order') border-red-500 @enderror">
                    <p class="mt-1 text-xs text-gray-500">Lower numbers appear first</p>
                    @error('sort_order')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Ad Rotation Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Ad Rotation Settings</h3>
            <p class="text-sm text-gray-600 mb-4">Group multiple ads to rotate in the same position</p>
            
            <div class="space-y-4">
                <!-- Rotation Group -->
                <div>
                    <label for="rotation_group" class="block text-sm font-medium text-gray-700 mb-1">
                        Rotation Group (Optional)
                    </label>
                    <input type="text" name="rotation_group" id="rotation_group" value="{{ old('rotation_group') }}"
                        placeholder="e.g., sidebar-group-1"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('rotation_group') border-red-500 @enderror">
                    <p class="mt-1 text-xs text-gray-500">Ads with same group name will rotate. Leave empty for no rotation.</p>
                    @error('rotation_group')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rotation Mode -->
                <div>
                    <label for="rotation_mode" class="block text-sm font-medium text-gray-700 mb-1">
                        Rotation Mode
                    </label>
                    <select name="rotation_mode" id="rotation_mode"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('rotation_mode') border-red-500 @enderror">
                        <option value="random" {{ old('rotation_mode', 'random') == 'random' ? 'selected' : '' }}>Random - Show random ad from group</option>
                        <option value="weighted" {{ old('rotation_mode') == 'weighted' ? 'selected' : '' }}>Weighted - Based on weight value</option>
                        <option value="sequential" {{ old('rotation_mode') == 'sequential' ? 'selected' : '' }}>Sequential - Rotate evenly based on impressions</option>
                    </select>
                    <p class="mt-1 text-xs text-gray-500">How ads in the same group should rotate</p>
                    @error('rotation_mode')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rotation Weight -->
                <div id="rotationWeightField">
                    <label for="rotation_weight" class="block text-sm font-medium text-gray-700 mb-1">
                        Rotation Weight
                    </label>
                    <input type="number" name="rotation_weight" id="rotation_weight" value="{{ old('rotation_weight', 1) }}" min="1" max="100"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('rotation_weight') border-red-500 @enderror">
                    <p class="mt-1 text-xs text-gray-500">Higher weight = more likely to show (only for weighted mode)</p>
                    @error('rotation_weight')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Basic Information Continue -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Schedule & Status</h3>
            
            <div class="space-y-4">
                <!-- Active Status -->
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">
                        Active (Tampilkan iklan ini)
                    </label>
                </div>

                <!-- Start Date -->
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">
                        Start Date (Optional)
                    </label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('start_date') border-red-500 @enderror">
                    <p class="mt-1 text-xs text-gray-500">Iklan akan mulai ditampilkan dari tanggal ini. Kosongkan untuk langsung aktif.</p>
                    @error('start_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- End Date -->
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">
                        End Date (Optional)
                    </label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('end_date') border-red-500 @enderror">
                    <p class="mt-1 text-xs text-gray-500">Iklan akan otomatis berhenti ditampilkan setelah tanggal ini. Kosongkan untuk tidak ada batas waktu.</p>
                    @error('end_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Image Upload Section (for image type) -->
        <div id="imageSection" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6" style="display: none;">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Image Banner</h3>
            
            <div class="space-y-4">
                <!-- Image Upload -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">
                        Upload Image <span class="text-red-500">*</span>
                    </label>
                    <input type="file" name="image" id="image" accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('image') border-red-500 @enderror">
                    <p class="mt-1 text-xs text-gray-500">Supported: JPG, PNG, GIF, WebP (Max: 2MB)</p>
                    @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Link URL -->
                <div>
                    <label for="link" class="block text-sm font-medium text-gray-700 mb-1">
                        Link URL (Optional)
                    </label>
                    <input type="url" name="link" id="link" value="{{ old('link') }}"
                        placeholder="https://example.com/promo"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('link') border-red-500 @enderror">
                    <p class="mt-1 text-xs text-gray-500">URL tujuan ketika banner diklik (kosongkan jika tidak perlu link)</p>
                    @error('link')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Open in New Tab -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="open_new_tab" value="1" {{ old('open_new_tab', true) ? 'checked' : '' }}
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">Open link in new tab</span>
                    </label>
                </div>

                <!-- Size Settings -->
                <div class="border-t pt-4 mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Ukuran Gambar
                    </label>
                    
                    <select name="size_preset" id="size_preset"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent mb-3">
                        <option value="medium" {{ old('size_preset', 'medium') == 'medium' ? 'selected' : '' }}>Medium (Rekomendasi)</option>
                        <option value="small" {{ old('size_preset') == 'small' ? 'selected' : '' }}>Small (Kecil)</option>
                        <option value="large" {{ old('size_preset') == 'large' ? 'selected' : '' }}>Large (Besar)</option>
                        <option value="auto" {{ old('size_preset') == 'auto' ? 'selected' : '' }}>Auto (Full Width Responsive)</option>
                        <option value="custom" {{ old('size_preset') == 'custom' ? 'selected' : '' }}>Custom (Atur Sendiri)</option>
                    </select>

                    <!-- Custom Size Fields -->
                    <div id="customSizeFields" style="display: none;" class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="custom_width" class="block text-sm font-medium text-gray-700 mb-1">
                                Width (px)
                            </label>
                            <input type="number" name="custom_width" id="custom_width" value="{{ old('custom_width') }}" min="50" max="2000"
                                placeholder="e.g., 728"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="custom_height" class="block text-sm font-medium text-gray-700 mb-1">
                                Height (px)
                            </label>
                            <input type="number" name="custom_height" id="custom_height" value="{{ old('custom_height') }}" min="50" max="2000"
                                placeholder="e.g., 90"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <p class="mt-2 text-xs text-gray-500">
                        <strong>Rekomendasi ukuran:</strong><br>
                        • Header/Footer: 728x90 atau 970x90<br>
                        • Sidebar: 300x250 atau 300x600<br>
                        • Content: 728x90 atau 336x280
                    </p>
                </div>
            </div>
        </div>

        <!-- Ad Code (for non-image types) -->
        <div id="codeSection" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ad Code</h3>
            
            <div>
                <label for="code" class="block text-sm font-medium text-gray-700 mb-1">
                    HTML/JavaScript Code <span class="text-red-500">*</span>
                </label>
                <textarea name="code" id="code" rows="10"
                    placeholder="Paste your ad code here (AdSense script, Adsera code, or custom HTML)"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono text-sm @error('code') border-red-500 @enderror">{{ old('code') }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Paste the complete ad code from your ad provider</p>
                @error('code')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Display Rules (Optional) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Display Rules</h3>
            <p class="text-sm text-gray-600 mb-4">Optional: Control where this ad appears (leave empty to show everywhere)</p>
            
            <div class="space-y-4">
                <!-- Pages -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Show on specific pages
                    </label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="display_rules[pages][]" value="home" 
                                {{ in_array('home', old('display_rules.pages', [])) ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">Homepage</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="display_rules[pages][]" value="blog_index" 
                                {{ in_array('blog_index', old('display_rules.pages', [])) ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">Blog Index (List Artikel)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="display_rules[pages][]" value="blog_detail" 
                                {{ in_array('blog_detail', old('display_rules.pages', [])) ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">Blog Detail (Single Post)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="display_rules[pages][]" value="static_page" 
                                {{ in_array('static_page', old('display_rules.pages', [])) ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">Static Pages</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.ads.index') }}" 
                class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all font-medium">
                Cancel
            </a>
            <button type="submit" 
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all font-medium shadow-sm">
                Create Ad
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const positionSelect = document.getElementById('position');
    const imageSection = document.getElementById('imageSection');
    const codeSection = document.getElementById('codeSection');
    const codeTextarea = document.getElementById('code');
    const imageInput = document.getElementById('image');
    const inContentParagraphField = document.getElementById('inContentParagraphField');
    const inContentParagraphInput = document.getElementById('in_content_paragraph');
    const sizePresetSelect = document.getElementById('size_preset');
    const customSizeFields = document.getElementById('customSizeFields');
    const rotationModeSelect = document.getElementById('rotation_mode');
    const rotationWeightField = document.getElementById('rotationWeightField');

    function toggleSections() {
        const selectedType = typeSelect.value;
        
        if (selectedType === 'image') {
            imageSection.style.display = 'block';
            codeSection.style.display = 'none';
            codeTextarea.removeAttribute('required');
            imageInput.setAttribute('required', 'required');
        } else {
            imageSection.style.display = 'none';
            codeSection.style.display = 'block';
            codeTextarea.setAttribute('required', 'required');
            imageInput.removeAttribute('required');
        }
    }

    function toggleInContentField() {
        const selectedPosition = positionSelect.value;
        
        if (selectedPosition === 'in_content') {
            inContentParagraphField.style.display = 'block';
            inContentParagraphInput.setAttribute('required', 'required');
        } else {
            inContentParagraphField.style.display = 'none';
            inContentParagraphInput.removeAttribute('required');
        }
    }

    function toggleCustomSizeFields() {
        const selectedPreset = sizePresetSelect.value;
        
        if (selectedPreset === 'custom') {
            customSizeFields.style.display = 'grid';
        } else {
            customSizeFields.style.display = 'none';
        }
    }

    function toggleRotationWeightField() {
        const selectedMode = rotationModeSelect.value;
        
        if (selectedMode === 'weighted') {
            rotationWeightField.style.display = 'block';
        } else {
            rotationWeightField.style.display = 'none';
        }
    }

    // Initial state
    toggleRotationWeightField();
    
    // Event listener
    rotationModeSelect.addEventListener('change', toggleRotationWeightField);
    typeSelect.addEventListener('change', toggleSections);
    positionSelect.addEventListener('change', toggleInContentField);
    sizePresetSelect.addEventListener('change', toggleCustomSizeFields);
    
    toggleSections(); // Initial state
    toggleInContentField(); // Initial state
    toggleCustomSizeFields(); // Initial state
});
</script>
@endsection
