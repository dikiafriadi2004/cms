@extends('layouts.admin')

@section('title', 'View Role')
@section('page-title', 'Role: ' . $role->name)

@section('content')
<div class="max-w-4xl space-y-6">
    <!-- Action Buttons -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Roles
        </a>
        
        <div class="flex gap-3">
            <a href="{{ route('admin.roles.edit', $role) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Role
            </a>
            
            @if(!in_array($role->name, ['super-admin', 'admin']))
            <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return handleDelete(event, 'Delete Role', 'Are you sure you want to delete this role? This action cannot be undone.')" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Delete
                </button>
            </form>
            @endif
        </div>
    </div>

    <!-- Role Information -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-pink-50">
            <h3 class="text-lg font-semibold text-gray-900">Role Information</h3>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role Name</label>
                <p class="text-lg font-semibold text-gray-900 capitalize">{{ $role->name }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Guard</label>
                <p class="text-gray-900">{{ $role->guard_name }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Created</label>
                <p class="text-gray-900">{{ $role->created_at->format('M d, Y H:i') }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Last Updated</label>
                <p class="text-gray-900">{{ $role->updated_at->format('M d, Y H:i') }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Users with this Role</label>
                <p class="text-2xl font-bold text-purple-600">{{ $role->users()->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Permissions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
            <h3 class="text-lg font-semibold text-gray-900">Assigned Permissions ({{ $role->permissions->count() }})</h3>
        </div>
        <div class="p-6">
            @if($role->permissions->count() > 0)
                @php
                    $groupedPermissions = $role->permissions->groupBy(function($permission) {
                        return explode('.', $permission->name)[0];
                    });
                @endphp

                @foreach($groupedPermissions as $group => $groupPermissions)
                <div class="mb-6 last:mb-0">
                    <h4 class="text-sm font-semibold text-gray-900 mb-3 capitalize flex items-center">
                        <span class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center text-white text-xs font-bold mr-2">
                            {{ strtoupper(substr($group, 0, 1)) }}
                        </span>
                        {{ $group }}
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 ml-10">
                        @foreach($groupPermissions as $permission)
                        <div class="flex items-center p-3 border border-gray-200 rounded-lg bg-green-50">
                            <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-sm text-gray-700">{{ $permission->name }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            @else
                <p class="text-gray-500 text-center py-8">No permissions assigned to this role.</p>
            @endif
        </div>
    </div>
</div>
@endsection
