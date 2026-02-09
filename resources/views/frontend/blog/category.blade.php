@extends('frontend.layouts.standalone')

@section('title', $category->meta_title ?: $category->name . ' - Blog - ' . ($settings['site_name'] ?? 'Konter Digital'))
@section('description', $category->meta_description ?: 'Browse articles in ' . $category->name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-purple-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li><a href="{{ route('home') }}" class="hover:text-purple-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('blog.index') }}" class="hover:text-purple-600">Blog</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-purple-600 font-semibold">{{ $category->name }}</li>
            </ol>
        </nav>

        <!-- Category Header -->
        <div class="text-center mb-12">
            <div class="inline-block px-4 py-2 bg-purple-100 text-purple-600 text-sm font-semibold rounded-full mb-4">
                Category
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">{{ $category->name }}</h1>
            @if($category->description)
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">{{ $category->description }}</p>
            @endif
            <p class="text-sm text-gray-500 mt-4">{{ $posts->total() }} {{ Str::plural('article', $posts->total()) }}</p>
        </div>

        @if($posts->count() > 0)
            <!-- Posts Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($posts as $post)
                <article class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    @if($post->featured_image)
                        <a href="{{ route('blog.show', $post->slug) }}">
                            <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                        </a>
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-purple-400 to-indigo-500 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-3 hover:text-purple-600 transition-colors">
                            <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                        </h2>
                        <p class="text-gray-600 mb-4 line-clamp-3">{{ $post->excerpt ?: strip_tags(substr($post->content, 0, 150)) }}...</p>
                        
                        <!-- Tags -->
                        @if($post->tags->count() > 0)
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach($post->tags->take(3) as $tag)
                                    <a href="{{ route('blog.tag', $tag->slug) }}" class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded-full hover:bg-purple-100 hover:text-purple-600 transition-colors">
                                        #{{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $post->published_at->format('M d, Y') }}
                            </span>
                            <a href="{{ route('blog.show', $post->slug) }}" class="text-purple-600 font-semibold hover:text-purple-700">
                                Read More →
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $posts->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No articles in this category yet</h3>
                <p class="text-gray-600 mb-6">Check back soon for new content!</p>
                <a href="{{ route('blog.index') }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 font-semibold">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    View All Articles
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
