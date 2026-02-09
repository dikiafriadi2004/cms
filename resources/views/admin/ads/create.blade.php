@extends('layouts.admin')

@section('title', 'Create Ad')
@section('page-title', 'Create New Ad')

@section('content')
<div class="max-w-3xl">
    <form action="{{ route('admin.ads.store') }}" method="POST" class="space-y-6">
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
                        <option value="between_posts" {{ old('position') == 'between_posts' ? 'selected' : '' }}>Between Posts</option>
                    </select>
                    @error('position')
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

        <!-- Ad Code -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ad Code</h3>
            
            <div>
                <label for="code" class="block text-sm font-medium text-gray-700 mb-1">
                    HTML/JavaScript Code <span class="text-red-500">*</span>
                </label>
                <textarea name="code" id="code" rows="10" required
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
                            <input type="checkbox" name="display_rules[pages][]" value="blog" 
                                {{ in_array('blog', old('display_rules.pages', [])) ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">Blog</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="display_rules[pages][]" value="post" 
                                {{ in_array('post', old('display_rules.pages', [])) ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">Single Post</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="display_rules[pages][]" value="page" 
                                {{ in_array('page', old('display_rules.pages', [])) ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">Pages</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Status</h3>
            
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <span class="ml-2 text-sm text-gray-700">Active (Ad will be displayed on the website)</span>
            </label>
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
@endsection
