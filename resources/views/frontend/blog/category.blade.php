@extends('frontend.layouts.standalone')

@section('title', $category->meta_title ?: $category->name . ' - Blog - ' . ($settings['site_name'] ?? 'Konter Digital'))
@section('description', $category->meta_description ?: 'Browse articles in ' . $category->name)

@section('content')
<div class="min-h-screen bg-white">
    <div class="max-w-7xl mx-auto px-8 py-20">
        <!-- Header -->
        <div class="mb-20 text-center mt-8">
            <a href="{{ route('blog.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 mb-4 transition">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Blog
            </a>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $category->name }}</h1>
            @if($category->description)
                <p class="text-gray-600">{{ $category->description }}</p>
            @endif
        </div>

        @if($posts->count() > 0)
            <!-- Posts Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                @foreach($posts as $post)
                    <article class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 border border-gray-200 overflow-hidden">
                        <a href="{{ route('blog.show', $post->slug) }}" class="block">
                            <!-- Image -->
                            <div class="relative aspect-[16/9] overflow-hidden bg-gray-100">
                                @if($post->featured_image)
                                    <img src="{{ $post->featured_image }}" 
                                         alt="{{ $post->title }}" 
                                         class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <!-- Title -->
                                <h2 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                    {{ $post->title }}
                                </h2>

                                <!-- Excerpt -->
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                    {{ Str::limit($post->excerpt ?: strip_tags($post->content), 120) }}
                                </p>

                                <!-- Meta -->
                                <div class="flex items-center text-xs text-gray-500">
                                    <time datetime="{{ $post->published_at->toISOString() }}">
                                        {{ $post->published_at->format('M d, Y') }}
                                    </time>
                                    <span class="mx-2">•</span>
                                    <span>{{ $post->user->name }}</span>
                                </div>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($posts->hasPages())
            <div class="flex items-center justify-center gap-2 mb-12">
                @if(!$posts->onFirstPage())
                    <a href="{{ $posts->previousPageUrl() }}" 
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Previous
                    </a>
                @endif

                <div class="flex gap-1">
                    @foreach(range(1, $posts->lastPage()) as $page)
                        @if($page == $posts->currentPage())
                            <span class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $posts->url($page) }}" 
                               class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                </div>

                @if($posts->hasMorePages())
                    <a href="{{ $posts->nextPageUrl() }}" 
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Next
                    </a>
                @endif
            </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-1">No articles in this category</h3>
                <p class="text-gray-600">Check back soon for new content</p>
            </div>
        @endif
    </div>
</div>
@endsection
