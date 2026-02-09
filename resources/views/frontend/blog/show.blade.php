@extends('frontend.layouts.standalone')

@section('title', $post->meta_title ?? $post->title . ' - ' . ($settings['site_name'] ?? 'Konter Digital'))
@section('description', $post->meta_description ?? strip_tags(substr($post->content, 0, 160)))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-purple-50 py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li><a href="{{ route('home') }}" class="hover:text-purple-600">Home</a></li>
                <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                <li><a href="{{ route('blog.index') }}" class="hover:text-purple-600">Blog</a></li>
                @if($post->category)
                    <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                    <li><a href="{{ route('blog.category', $post->category->slug) }}" class="hover:text-purple-600">{{ $post->category->name }}</a></li>
                @endif
            </ol>
        </nav>

        <!-- Article -->
        <article class="bg-white rounded-3xl shadow-xl overflow-hidden">
            @if($post->featured_image)
                <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-64 md:h-96 object-cover">
            @endif
            
            <div class="p-8 md:p-12">
                <!-- Category & Meta -->
                <div class="flex flex-wrap items-center gap-4 mb-6">
                    @if($post->category)
                        <a href="{{ route('blog.category', $post->category->slug) }}" class="inline-block px-4 py-2 bg-purple-100 text-purple-600 text-sm font-semibold rounded-full hover:bg-purple-200 transition-colors">
                            {{ $post->category->name }}
                        </a>
                    @endif
                    <span class="flex items-center text-sm text-gray-500">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ $post->published_at->format('F d, Y') }}
                    </span>
                    <span class="flex items-center text-sm text-gray-500">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        {{ $post->views_count }} views
                    </span>
                </div>

                <!-- Title -->
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">{{ $post->title }}</h1>

                <!-- Author -->
                <div class="flex items-center mb-8 pb-8 border-b border-gray-200">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                        {{ substr($post->user->name, 0, 1) }}
                    </div>
                    <div class="ml-4">
                        <p class="font-semibold text-gray-900">{{ $post->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $post->published_at->diffForHumans() }}</p>
                    </div>
                </div>

                <!-- Content -->
                <div class="prose prose-lg max-w-none mb-8">
                    {!! $post->content !!}
                </div>

                <!-- Tags -->
                @if($post->tags->count() > 0)
                    <div class="pt-8 border-t border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Tags:</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($post->tags as $tag)
                                <a href="{{ route('blog.tag', $tag->slug) }}" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm rounded-full hover:bg-purple-100 hover:text-purple-600 transition-colors">
                                    #{{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </article>

        <!-- Related Posts -->
        @if($relatedPosts->count() > 0)
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Related Articles</h2>
                <div class="grid md:grid-cols-2 gap-6">
                    @foreach($relatedPosts->take(2) as $related)
                        <a href="{{ route('blog.show', $related->slug) }}" class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all">
                            @if($related->featured_image)
                                <img src="{{ $related->featured_image }}" alt="{{ $related->title }}" class="w-full h-40 object-cover">
                            @else
                                <div class="w-full h-40 bg-gradient-to-br from-purple-400 to-indigo-500"></div>
                            @endif
                            <div class="p-6">
                                <h3 class="font-bold text-gray-900 mb-2 hover:text-purple-600">{{ $related->title }}</h3>
                                <p class="text-sm text-gray-600">{{ $related->published_at->format('M d, Y') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Back to Blog -->
        <div class="text-center mt-12">
            <a href="{{ route('blog.index') }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 font-semibold">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Blog
            </a>
        </div>
    </div>
</div>

<style>
.prose { color: #374151; }
.prose h1, .prose h2, .prose h3 { font-weight: 700; color: #111827; margin-top: 2rem; margin-bottom: 1rem; }
.prose h1 { font-size: 2.25rem; }
.prose h2 { font-size: 1.875rem; }
.prose h3 { font-size: 1.5rem; }
.prose p { margin-bottom: 1.25rem; line-height: 1.75; }
.prose ul, .prose ol { margin-bottom: 1.25rem; padding-left: 1.5rem; }
.prose li { margin-bottom: 0.5rem; }
.prose a { color: #7c3aed; text-decoration: underline; }
.prose a:hover { color: #6d28d9; }
.prose strong { font-weight: 600; color: #111827; }
.prose img { border-radius: 0.5rem; margin: 1.5rem 0; }
</style>
@endsection
