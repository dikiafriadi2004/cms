@extends('layouts.admin')

@section('title', 'Edit User')
@section('page-title', 'Edit User: ' . $user->name)

@section('content')
<div class="max-w-3xl">
    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
            
            <div class="space-y-4">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror">
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror">
                    @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        New Password
                    </label>
                    <input type="password" name="password" id="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror">
                    <p class="mt-1 text-xs text-gray-500">Leave blank to keep current password. Minimum 8 characters if changing.</p>
                    @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                        Confirm New Password
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Bio -->
                <div>
                    <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">
                        Bio
                    </label>
                    <textarea name="bio" id="bio" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('bio') border-red-500 @enderror">{{ old('bio', $user->bio) }}</textarea>
                    @error('bio')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Roles & Permissions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 {{ $user->id === auth()->id() ? 'opacity-60' : '' }}">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Roles & Permissions</h3>
                @if($user->id === auth()->id())
                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">
                    Cannot edit your own roles
                </span>
                @endif
            </div>
            
            <div class="space-y-3">
                @foreach($roles as $role)
                <label class="flex items-start p-4 border border-gray-200 rounded-lg {{ $user->id === auth()->id() ? 'cursor-not-allowed bg-gray-50' : 'hover:bg-gray-50 cursor-pointer' }} transition-colors">
                    <input type="checkbox" name="roles[]" value="{{ $role->name }}" 
                        {{ in_array($role->name, old('roles', $user->roles->pluck('name')->toArray())) ? 'checked' : '' }}
                        {{ $user->id === auth()->id() ? 'disabled' : '' }}
                        class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded {{ $user->id === auth()->id() ? 'cursor-not-allowed' : '' }}">
                    <div class="ml-3 flex-1">
                        <div class="flex items-center gap-2">
                            <span class="font-medium text-gray-900">{{ ucfirst($role->name) }}</span>
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full 
                                {{ $role->name === 'admin' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $role->name === 'editor' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $role->name === 'author' ? 'bg-green-100 text-green-800' : '' }}">
                                {{ $role->permissions->count() }} permissions
                            </span>
                        </div>
                        @if($role->permissions->count() > 0)
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $role->permissions->pluck('name')->take(3)->implode(', ') }}
                            @if($role->permissions->count() > 3)
                            <span class="text-gray-400">and {{ $role->permissions->count() - 3 }} more...</span>
                            @endif
                        </p>
                        @endif
                    </div>
                </label>
                @endforeach
                @error('roles')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            @if($user->id === auth()->id())
            <p class="mt-3 text-sm text-gray-600 bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                <strong>⚠️ Security Notice:</strong> You cannot modify your own roles to prevent accidental loss of admin access.
            </p>
            @endif
        </div>

        <!-- Status -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 {{ $user->id === auth()->id() ? 'opacity-60' : '' }}">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Account Status</h3>
                @if($user->id === auth()->id())
                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">
                    Cannot deactivate your own account
                </span>
                @endif
            </div>
            
            <label class="flex items-center {{ $user->id === auth()->id() ? 'cursor-not-allowed' : '' }}">
                <input type="hidden" name="is_active" value="{{ $user->id === auth()->id() ? '1' : '0' }}">
                <input type="checkbox" name="is_active" value="1" 
                    {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                    {{ $user->id === auth()->id() ? 'disabled' : '' }}
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded {{ $user->id === auth()->id() ? 'cursor-not-allowed' : '' }}">
                <span class="ml-2 text-sm text-gray-700">Active (User can login and access the system)</span>
            </label>
            
            @if($user->id === auth()->id())
            <p class="mt-3 text-sm text-gray-600 bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                <strong>⚠️ Security Notice:</strong> You cannot deactivate your own account to prevent accidental lockout.
            </p>
            @endif
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.users.index') }}" 
                class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all font-medium">
                Cancel
            </a>
            <button type="submit" 
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all font-medium shadow-sm">
                Update User
            </button>
        </div>
    </form>
</div>
@endsection
