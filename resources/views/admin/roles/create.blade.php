@extends('layouts.admin')

@section('title', 'Create Role')
@section('page-title', 'Create New Role')

@section('content')
<form method="POST" action="{{ route('admin.roles.store') }}" class="max-w-4xl">
    @csrf
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-pink-50">
            <h3 class="text-lg font-semibold text-gray-900">Role Information</h3>
        </div>
        <div class="p-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Role Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror" 
                    value="{{ old('name') }}"
                    placeholder="e.g., Moderator, Contributor">
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Enter a unique name for this role (lowercase, no spaces)</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
            <h3 class="text-lg font-semibold text-gray-900">Assign Permissions</h3>
        </div>
        <div class="p-6">
            @foreach($permissions as $group => $groupPermissions)
            <div class="mb-6 last:mb-0">
                <h4 class="text-sm font-semibold text-gray-900 mb-3 capitalize flex items-center">
                    <span class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center text-white text-xs font-bold mr-2">
                        {{ strtoupper(substr($group, 0, 1)) }}
                    </span>
                    {{ $group }}
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 ml-10">
                    @foreach($groupPermissions as $permission)
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                            class="rounded border-gray-300 text-purple-600 focus:ring-purple-500 mr-3"
                            {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                        <span class="text-sm text-gray-700">{{ $permission->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="flex gap-3">
        <button type="submit" class="inline-flex items-center px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 focus:ring-4 focus:ring-purple-200 transition-all font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Create Role
        </button>
        <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Cancel
        </a>
    </div>
</form>
@endsection
