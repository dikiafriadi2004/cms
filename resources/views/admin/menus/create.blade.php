@extends('layouts.admin')

@section('title', 'Create Menu')
@section('page-title', 'Create New Menu')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('admin.menus.store') }}" class="space-y-6">
            @csrf
            
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Menu Name *</label>
                <input type="text" name="name" id="name" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    value="{{ old('name') }}" placeholder="e.g., Main Menu">
            </div>

            <div>
                <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location *</label>
                <select name="location" id="location" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="header" {{ old('location') === 'header' ? 'selected' : '' }}>Header</option>
                    <option value="footer" {{ old('location') === 'footer' ? 'selected' : '' }}>Footer</option>
                    <option value="sidebar" {{ old('location') === 'sidebar' ? 'selected' : '' }}>Sidebar</option>
                </select>
                <p class="mt-1 text-xs text-gray-500">Where this menu will be displayed on your site</p>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="is_active" class="ml-2 text-sm text-gray-700">Active (display this menu on the site)</label>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all font-medium">
                    Create Menu
                </button>
                <a href="{{ route('admin.menus.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all font-medium">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
