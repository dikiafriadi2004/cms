@extends('frontend.layouts.frontend')

@section('title', $post->title . ' - ' . ($settings['site_name'] ?? 'Konter Digital'))
@section('description', strip_tags(substr($post->content, 0, 160)))

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-8 py-16">
        <div class="grid lg:grid-cols-12 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-8">
                <article class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="p-8 md:p-10">
                        <!-- Category Badge -->
                        @if($post->category)
                        <a href="{{ route('blog.category', $post->category->slug) }}" 
                           class="inline-flex items-center px-3 py-1 text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 uppercase tracking-wider mb-5 rounded-full transition">
                            {{ $post->category->name }}
                        </a>
                        @endif

                        <!-- Title -->
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-5 leading-tight">
                            {{ $post->title }}
                        </h1>

                        <!-- Meta Info -->
                        <div class="flex items-center text-sm text-gray-500 mb-8 pb-6 border-b border-gray-200">
                            <div class="flex items-center gap-2">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-semibold">
                                    {{ substr($post->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $post->user->name }}</p>
                                    <div class="flex items-center text-xs text-gray-500">
                                        <time datetime="{{ $post->published_at->toISOString() }}">
                                            {{ $post->published_at->format('M d, Y') }}
                                        </time>
                                        <span class="mx-1.5">•</span>
                                        <span>{{ number_format($post->views_count) }} views</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Featured Image -->
                        @if($post->featured_image)
                        <figure class="mb-8 rounded-xl overflow-hidden shadow-md">
                            <div class="w-full aspect-[16/9] bg-gray-100">
                                <img src="{{ $post->featured_image }}" 
                                     alt="{{ $post->title }}" 
                                     class="w-full h-full object-cover object-center">
                            </div>
                        </figure>
                        @endif

                        <!-- Article Content -->
                        <div class="prose prose-lg max-w-none mb-10">
                            {!! $post->content !!}
                        </div>

                        <!-- Tags -->
                        @if($post->tags->count() > 0)
                        <div class="pt-6 border-t border-gray-200 mb-6">
                            <h3 class="text-sm font-semibold text-gray-900 mb-3">Tags</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($post->tags as $tag)
                                <a href="{{ route('blog.tag', $tag->slug) }}" 
                                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 hover:from-blue-50 hover:to-indigo-50 hover:text-blue-600 border border-gray-200 hover:border-blue-300 rounded-full transition-all duration-200 shadow-sm hover:shadow">
                                    <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $tag->name }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Social Share -->
                        <div class="pt-6 border-t border-gray-200">
                            <h3 class="text-sm font-semibold text-gray-900 mb-4">Share this article</h3>
                            <div class="flex flex-wrap gap-4">
                                <!-- Facebook -->
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $post->slug)) }}" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   title="Share on Facebook"
                                   class="text-gray-600 hover:text-blue-600 transition-colors duration-200">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </a>

                                <!-- Twitter/X -->
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $post->slug)) }}&text={{ urlencode($post->title) }}" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   title="Share on Twitter"
                                   class="text-gray-600 hover:text-black transition-colors duration-200">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                    </svg>
                                </a>

                                <!-- WhatsApp -->
                                <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . route('blog.show', $post->slug)) }}" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   title="Share on WhatsApp"
                                   class="text-gray-600 hover:text-green-600 transition-colors duration-200">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                    </svg>
                                </a>

                                <!-- LinkedIn -->
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('blog.show', $post->slug)) }}&title={{ urlencode($post->title) }}" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   title="Share on LinkedIn"
                                   class="text-gray-600 hover:text-blue-700 transition-colors duration-200">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                </a>

                                <!-- Copy Link -->
                                <button onclick="copyToClipboard('{{ route('blog.show', $post->slug) }}')" 
                                        title="Copy Link"
                                        class="text-gray-600 hover:text-gray-900 transition-colors duration-200">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Sidebar - Popular Posts -->
            <aside class="lg:col-span-4">
                <div class="lg:sticky lg:top-8">
                    <div class="bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                            <h3 class="text-lg font-bold text-gray-900">Popular Posts</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-5">
                                @forelse($popularPosts as $popular)
                                <article class="group">
                                    <a href="{{ route('blog.show', $popular->slug) }}" class="flex gap-4 hover:bg-gray-50 p-2 -m-2 rounded-lg transition">
                                        <!-- Thumbnail -->
                                        <div class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden bg-gray-100">
                                            @if($popular->featured_image)
                                                <img src="{{ $popular->featured_image }}" 
                                                     alt="{{ $popular->title }}" 
                                                     class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-300">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Content -->
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-semibold text-sm text-gray-900 group-hover:text-blue-600 transition mb-1.5 line-clamp-2 leading-snug">
                                                {{ $popular->title }}
                                            </h4>
                                            <div class="flex items-center text-xs text-gray-500">
                                                <time datetime="{{ $popular->published_at->toISOString() }}">
                                                    {{ $popular->published_at->format('M d, Y') }}
                                                </time>
                                                <span class="mx-1.5">•</span>
                                                <span>{{ number_format($popular->views_count) }} views</span>
                                            </div>
                                        </div>
                                    </a>
                                </article>
                                @if(!$loop->last)
                                <hr class="border-gray-200">
                                @endif
                                @empty
                                <p class="text-sm text-gray-500 text-center py-4">No popular posts available</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Link copied to clipboard!');
    }, function(err) {
        console.error('Could not copy text: ', err);
    });
}
</script>

<style>
/* Prose Styles */
.prose {
    color: #374151;
    font-size: 1.0625rem;
    line-height: 1.8;
}

.prose h1,
.prose h2,
.prose h3,
.prose h4,
.prose h5,
.prose h6 {
    color: #111827;
    font-weight: 700;
    margin-top: 2em;
    margin-bottom: 0.75em;
    line-height: 1.3;
}

.prose h1 { font-size: 2rem; }
.prose h2 { font-size: 1.75rem; }
.prose h3 { font-size: 1.5rem; }
.prose h4 { font-size: 1.25rem; }
.prose h5 { font-size: 1.125rem; }
.prose h6 { font-size: 1rem; }

.prose p {
    margin-bottom: 1.5em;
}

.prose a {
    color: #2563eb;
    text-decoration: underline;
    font-weight: 500;
    transition: color 0.2s;
}

.prose a:hover {
    color: #1d4ed8;
}

.prose strong,
.prose b {
    font-weight: 600;
    color: #111827;
}

.prose em,
.prose i {
    font-style: italic;
}

.prose ul,
.prose ol {
    margin-bottom: 1.5em;
    padding-left: 1.75em;
}

.prose ul {
    list-style-type: disc;
}

.prose ol {
    list-style-type: decimal;
}

.prose li {
    margin-bottom: 0.5em;
}

.prose li > p {
    margin-bottom: 0.5em;
}

.prose blockquote {
    border-left: 4px solid #3b82f6;
    padding-left: 1.5em;
    margin: 2em 0;
    font-style: italic;
    color: #4b5563;
    background: #f9fafb;
    padding: 1.25em 1.5em;
    border-radius: 0.375rem;
}

.prose code {
    background: #f3f4f6;
    padding: 0.2em 0.4em;
    border-radius: 0.25rem;
    font-size: 0.875em;
    color: #dc2626;
    font-family: 'Courier New', Courier, monospace;
    font-weight: 500;
}

.prose pre {
    background: #1f2937;
    color: #f9fafb;
    padding: 1.5em;
    border-radius: 0.5rem;
    overflow-x: auto;
    margin: 2em 0;
    line-height: 1.6;
}

.prose pre code {
    background: transparent;
    padding: 0;
    color: #f9fafb;
    font-weight: 400;
}

.prose img {
    margin: 2em 0;
    border-radius: 0.5rem;
    max-width: 100%;
    height: auto;
}

.prose hr {
    border: none;
    border-top: 1px solid #e5e7eb;
    margin: 3em 0;
}

.prose table {
    width: 100%;
    border-collapse: collapse;
    margin: 2em 0;
    font-size: 0.9375rem;
}

.prose th,
.prose td {
    padding: 0.75em 1em;
    border: 1px solid #e5e7eb;
    text-align: left;
}

.prose th {
    background: #f9fafb;
    font-weight: 600;
    color: #111827;
}

.prose td {
    color: #374151;
}

.prose figure {
    margin: 2em 0;
}

.prose figcaption {
    margin-top: 0.75em;
    font-size: 0.875em;
    color: #6b7280;
    text-align: center;
}

/* Line Clamp Utility */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
