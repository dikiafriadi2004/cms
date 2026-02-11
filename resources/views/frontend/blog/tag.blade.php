@extends('frontend.layouts.frontend')

@section('title', $tag->meta_title ?: $tag->name . ' - Blog - ' . ($settings['site_name'] ?? 'Konter Digital'))
@section('description', $tag->meta_description ?: 'Browse articles tagged with ' . $tag->name)

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
            <h1 class="text-4xl font-bold text-gray-900 mb-2">#{{ $tag->name }}</h1>
            @if($tag->description)
                <p class="text-gray-600">{{ $tag->description }}</p>
            @endif
        </div>

        <!-- Content Top Ads -->
        @if(isset($ads['content_top']) && $ads['content_top']->count() > 0)
            <div class="mb-12">
                @foreach($ads['content_top'] as $ad)
                    <div class="mb-4">
                        {!! $ad->render() !!}
                    </div>
                @endforeach
            </div>
        @endif

        @if($posts->count() > 0)
            <!-- Posts Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                @foreach($posts as $index => $post)
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
                                <!-- Category -->
                                @if($post->category)
                                    <span class="inline-block text-xs font-semibold text-blue-600 uppercase tracking-wider mb-3">
                                        {{ $post->category->name }}
                                    </span>
                                @endif

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

                    <!-- Between Posts Ads (after every 3rd post) -->
                    @if(($index + 1) % 3 == 0 && isset($ads['between_posts']) && $ads['between_posts']->count() > 0)
                        <div class="col-span-1 md:col-span-2 lg:col-span-3">
                            @foreach($ads['between_posts'] as $ad)
                                <div class="mb-4">
                                    {!! $ad->render() !!}
                                </div>
                            @endforeach
                        </div>
                    @endif
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
                <h3 class="text-lg font-semibold text-gray-900 mb-1">No articles with this tag</h3>
                <p class="text-gray-600">Check back soon for new content</p>
            </div>
        @endif
    </div>
</div>
@endsection
