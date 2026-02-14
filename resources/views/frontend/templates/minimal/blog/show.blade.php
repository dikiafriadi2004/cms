@extends('frontend.layouts.frontend')

@section('title', $post->meta_title ?: $post->title . ' - ' . ($settings['site_name'] ?? 'Konter Digital'))
@section('description', $post->meta_description ?: Str::limit(strip_tags($post->content), 160))

@push('styles')
<style>
/* Minimal Template - Clean Typography */
.minimal-article {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
}

.minimal-article h1 {
    font-size: 3rem;
    font-weight: 700;
    line-height: 1.2;
    color: #111827;
    margin-bottom: 1.5rem;
}

.minimal-article .meta {
    color: #6b7280;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 3rem;
}

.minimal-article .prose {
    font-size: 1.125rem;
    line-height: 1.8;
    color: #374151;
}

.minimal-article .prose h2 {
    font-size: 2rem;
    font-weight: 700;
    color: #111827;
    margin-top: 3rem;
    margin-bottom: 1rem;
}

.minimal-article .prose h3 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #111827;
    margin-top: 2.5rem;
    margin-bottom: 0.75rem;
}

.minimal-article .prose p {
    margin-bottom: 1.5rem;
}

.minimal-article .prose a {
    color: #111827;
    text-decoration: underline;
    text-underline-offset: 2px;
}

.minimal-article .prose a:hover {
    color: #6b7280;
}

.minimal-article .prose blockquote {
    border-left: 3px solid #111827;
    padding-left: 1.5rem;
    font-style: italic;
    color: #6b7280;
    margin: 2rem 0;
}

.minimal-article .prose ul,
.minimal-article .prose ol {
    margin: 1.5rem 0;
    padding-left: 1.5rem;
}

.minimal-article .prose li {
    margin-bottom: 0.5rem;
}

.minimal-article .prose code {
    background: #f3f4f6;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
    font-size: 0.875em;
    font-family: 'Courier New', monospace;
}

.minimal-article .prose pre {
    background: #1f2937;
    color: #f3f4f6;
    padding: 1.5rem;
    border-radius: 0.5rem;
    overflow-x: auto;
    margin: 2rem 0;
}

.minimal-article .prose pre code {
    background: transparent;
    padding: 0;
    color: inherit;
}

.minimal-article .prose img {
    margin: 2rem 0;
    border-radius: 0.5rem;
}
</style>
@endpush

@section('content')
<main class="minimal-article min-h-screen bg-white">
    <!-- Article Header -->
    <article class="pt-32 pb-16 px-4">
        <div class="max-w-3xl mx-auto">
            <!-- Breadcrumb -->
            <nav class="mb-8">
                <a href="{{ route('blog.index') }}" class="text-sm text-gray-500 hover:text-gray-900 transition">
                    ← Back to Blog
                </a>
            </nav>

            <!-- Title -->
            <h1>{{ $post->title }}</h1>

            <!-- Meta -->
            <div class="meta flex items-center gap-4">
                <time>{{ $post->published_at->format('F d, Y') }}</time>
                @if($post->category)
                <span>•</span>
                <span>{{ $post->category->name }}</span>
                @endif
                <span>•</span>
                <span>{{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min read</span>
            </div>

            <!-- Featured Image (if exists) -->
            @if($post->featured_image)
            <div class="my-12">
                <img src="{{ $post->featured_image }}" 
                     alt="{{ $post->title }}"
                     class="w-full rounded-lg">
            </div>
            @endif

            <!-- Content Top Ads -->
            @if(isset($ads['content_top']) && $ads['content_top']->count() > 0)
                <div class="my-12 border-t border-b border-gray-200 py-8">
                    @foreach($ads['content_top'] as $ad)
                        <div class="mb-4">
                            {!! $ad->render() !!}
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Content -->
            <div class="prose max-w-none">
                {!! $post->content !!}
            </div>

            <!-- Content Bottom Ads -->
            @if(isset($ads['content_bottom']) && $ads['content_bottom']->count() > 0)
                <div class="mt-12 border-t border-b border-gray-200 py-8">
                    @foreach($ads['content_bottom'] as $ad)
                        <div class="mb-4">
                            {!! $ad->render() !!}
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Tags -->
            @if($post->tags->count() > 0)
            <div class="mt-16 pt-8 border-t border-gray-200">
                <div class="flex flex-wrap gap-2">
                    @foreach($post->tags as $tag)
                    <a href="{{ route('blog.tag', $tag->slug) }}" 
                       class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition">
                        {{ $tag->name }}
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Author -->
            <div class="mt-12 pt-8 border-t border-gray-200">
                <div class="flex items-center gap-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&bg=111827&color=fff" 
                         class="w-16 h-16 rounded-full" 
                         alt="{{ $post->user->name }}">
                    <div>
                        <p class="font-semibold text-gray-900">{{ $post->user->name }}</p>
                        <p class="text-sm text-gray-600">Author</p>
                    </div>
                </div>
            </div>
        </div>
    </article>

    <!-- Related Posts -->
    @if($relatedPosts->count() > 0)
    <section class="py-16 px-4 bg-gray-50 border-t border-gray-200">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Related Articles</h2>
            <div class="space-y-8">
                @foreach($relatedPosts as $related)
                <article>
                    <a href="{{ route('blog.show', $related->slug) }}" class="block group">
                        <time class="text-xs text-gray-500 uppercase tracking-wider">
                            {{ $related->published_at->format('F d, Y') }}
                        </time>
                        <h3 class="text-xl font-bold text-gray-900 mt-1 group-hover:text-gray-600 transition-colors">
                            {{ $related->title }}
                        </h3>
                    </a>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</main>
@endsection
