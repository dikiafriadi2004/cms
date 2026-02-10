@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Posts Card -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium mb-1">Total Posts</p>
                <h3 class="text-3xl font-bold mb-1">{{ $stats['posts']['total'] }}</h3>
                <p class="text-blue-100 text-xs">{{ $stats['posts']['published'] }} Published</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Pages Card -->
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium mb-1">Total Pages</p>
                <h3 class="text-3xl font-bold mb-1">{{ $stats['pages']['total'] }}</h3>
                <p class="text-green-100 text-xs">{{ $stats['pages']['published'] }} Published</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Users Card -->
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm font-medium mb-1">Total Users</p>
                <h3 class="text-3xl font-bold mb-1">{{ $stats['users']['total'] }}</h3>
                <p class="text-purple-100 text-xs">{{ $stats['users']['active'] }} Active</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Media Files Card -->
    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-orange-100 text-sm font-medium mb-1">Media Files</p>
                <h3 class="text-3xl font-bold mb-1">{{ $stats['media']['total'] }}</h3>
                <p class="text-orange-100 text-xs">{{ number_format($stats['media']['size'] / 1024 / 1024, 1) }} MB</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Recent Posts -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Recent Posts</h3>
                <a href="{{ route('admin.posts.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors">
                    View All →
                </a>
            </div>
            <div class="p-6">
                @if($recentPosts->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($recentPosts as $post)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-4">
                                        <a href="{{ route('admin.posts.show', $post) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600">
                                            {{ Str::limit($post->title, 40) }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-600">{{ $post->user->name }}</td>
                                    <td class="px-4 py-4">
                                        @if($post->category)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ $post->category->name }}
                                            </span>
                                        @else
                                            <span class="text-sm text-gray-400">No Category</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4">
                                        @if($post->status === 'published')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Published
                                            </span>
                                        @elseif($post->status === 'draft')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Draft
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Scheduled
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-600">{{ $post->created_at->format('M d, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="mt-4 text-sm text-gray-500">No posts found.</p>
                        <a href="{{ route('admin.posts.create') }}" class="mt-2 inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-700">
                            Create your first post →
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Popular Posts -->
    <div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Popular Posts</h3>
            </div>
            <div class="p-6">
                @if($popularPosts->count() > 0)
                    <div class="space-y-4">
                        @foreach($popularPosts as $post)
                        <div class="flex items-start space-x-3 {{ !$loop->last ? 'pb-4 border-b border-gray-100' : '' }}">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center text-white font-semibold text-sm">
                                    {{ $loop->iteration }}
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('admin.posts.show', $post) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600 line-clamp-2">
                                    {{ Str::limit($post->title, 50) }}
                                </a>
                                <p class="mt-1 text-xs text-gray-500">
                                    <span class="font-medium">{{ $post->views_count }}</span> views • 
                                    {{ $post->published_at->format('M d') }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        <p class="mt-3 text-sm text-gray-500">No popular posts yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Google Analytics Widget -->
@if(!empty($settings['google_analytics_id']))
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900">Google Analytics</h3>
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
            Active
        </span>
    </div>
    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-sm text-gray-600 mb-1">Tracking ID</p>
                <p class="text-lg font-semibold text-gray-900">{{ $settings['google_analytics_id'] }}</p>
            </div>
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-4 pt-4 border-t border-gray-200">
            <div class="text-center">
                <p class="text-2xl font-bold text-gray-900">{{ $stats['posts']['total'] }}</p>
                <p class="text-xs text-gray-500 mt-1">Total Posts</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold text-gray-900">{{ $stats['pages']['total'] }}</p>
                <p class="text-xs text-gray-500 mt-1">Total Pages</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold text-gray-900">{{ $stats['users']['total'] }}</p>
                <p class="text-xs text-gray-500 mt-1">Total Users</p>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-gray-200">
            <a href="https://analytics.google.com" target="_blank" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-700">
                View Analytics Dashboard
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </a>
        </div>
    </div>
</div>
@endif
@endsection