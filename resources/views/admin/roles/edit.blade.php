@extends('layouts.admin')

@section('title', 'Edit Role')
@section('page-title', 'Edit Role: ' . $role->name)

@section('content')
<form method="POST" action="{{ route('admin.roles.update', $role) }}" class="max-w-4xl">
    @csrf
    @method('PUT')
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-pink-50">
            <h3 class="text-lg font-semibold text-gray-900">Role Information</h3>
        </div>
        <div class="p-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Role Name <span class="text-red-500">*</span>
                </label>
                @php
                    $systemRoles = ['super-admin', 'admin', 'editor', 'author'];
                    $isSystemRole = in_array($role->name, $systemRoles);
                @endphp
                <input type="text" name="name" id="name" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror {{ $isSystemRole ? 'bg-gray-100 cursor-not-allowed' : '' }}" 
                    value="{{ old('name', $role->name) }}"
                    placeholder="e.g., Moderator, Contributor"
                    {{ $isSystemRole ? 'readonly' : '' }}>
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @if($isSystemRole)
                    <p class="mt-1 text-xs text-amber-600">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        System role name cannot be changed
                    </p>
                @else
                    <p class="mt-1 text-xs text-gray-500">Enter a unique name for this role (lowercase, no spaces)</p>
                @endif
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
                            {{ in_array($permission->id, old('permissions', $role->permissions->pluck('id')->toArray())) ? 'checked' : '' }}>
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
            Update Role
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
