@extends('frontend.layouts.frontend')

@section('title', $post->meta_title ?: $post->title . ' - ' . ($settings['site_name'] ?? 'Konter Digital'))
@section('description', $post->meta_description ?: Str::limit(strip_tags($post->content), 160))

@push('styles')
<style>
/* Magazine Template - Bold Article Style */
.magazine-article {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

.magazine-article h1 {
    font-size: 3.5rem;
    font-weight: 900;
    line-height: 1.1;
    color: #111827;
}

.magazine-article .prose {
    font-size: 1.125rem;
    line-height: 1.8;
}

.magazine-article .prose h2 {
    font-size: 2.25rem;
    font-weight: 900;
    color: #111827;
    margin-top: 3rem;
    margin-bottom: 1rem;
    border-left: 6px solid #dc2626;
    padding-left: 1rem;
}

.magazine-article .prose h3 {
    font-size: 1.75rem;
    font-weight: 800;
    color: #111827;
    margin-top: 2.5rem;
    margin-bottom: 0.75rem;
}

.magazine-article .prose p {
    margin-bottom: 1.5rem;
    color: #374151;
}

.magazine-article .prose strong {
    font-weight: 800;
    color: #111827;
}

.magazine-article .prose a {
    color: #dc2626;
    font-weight: 700;
    text-decoration: underline;
}

.magazine-article .prose blockquote {
    border-left: 6px solid #dc2626;
    background: #fef2f2;
    padding: 1.5rem;
    font-size: 1.25rem;
    font-weight: 600;
    font-style: italic;
    color: #991b1b;
    margin: 2rem 0;
}

.magazine-article .prose img {
    margin: 2.5rem 0;
    border-radius: 0;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
}
</style>
@endpush

@section('content')
<div class="magazine-article bg-white">
    <!-- Article Header -->
    <article class="pt-32 pb-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Category Badge -->
            @if($post->category)
            <div class="mb-6">
                <span class="inline-block px-4 py-2 bg-red-600 text-white text-xs font-black uppercase tracking-wider rounded">
                    {{ $post->category->name }}
                </span>
            </div>
            @endif

            <!-- Title -->
            <h1 class="mb-6">{{ $post->title }}</h1>

            <!-- Meta -->
            <div class="flex items-center gap-6 pb-8 mb-8 border-b-2 border-gray-200">
                <div class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&bg=dc2626&color=fff" 
                         class="w-12 h-12 rounded-full" 
                         alt="{{ $post->user->name }}">
                    <div>
                        <p class="font-black text-gray-900">{{ $post->user->name }}</p>
                        <p class="text-sm text-gray-600">
                            {{ $post->published_at->format('F d, Y') }} • 
                            {{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min read
                        </p>
                    </div>
                </div>
            </div>

            <!-- Featured Image -->
            @if($post->featured_image)
            <div class="mb-12 -mx-4 sm:-mx-6 lg:-mx-8">
                <img src="{{ $post->featured_image }}" 
                     alt="{{ $post->title }}"
                     class="w-full">
            </div>
            @endif

            <!-- Content Top Ads -->
            @if(isset($ads['content_top']) && $ads['content_top']->count() > 0)
                <div class="my-12 border-4 border-black p-6 bg-white">
                    @foreach($ads['content_top'] as $ad)
                        <div class="mb-4">
                            {!! $ad->render() !!}
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Content -->
            <div class="prose prose-lg max-w-none">
                {!! $post->content !!}
            </div>

            <!-- Content Bottom Ads -->
            @if(isset($ads['content_bottom']) && $ads['content_bottom']->count() > 0)
                <div class="mt-12 border-4 border-black p-6 bg-white">
                    @foreach($ads['content_bottom'] as $ad)
                        <div class="mb-4">
                            {!! $ad->render() !!}
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Tags -->
            @if($post->tags->count() > 0)
            <div class="mt-12 pt-8 border-t-2 border-gray-200">
                <h3 class="text-sm font-black uppercase tracking-wider text-gray-500 mb-4">Tagged:</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($post->tags as $tag)
                    <a href="{{ route('blog.tag', $tag->slug) }}" 
                       class="px-4 py-2 bg-gray-100 text-gray-900 font-bold text-sm rounded hover:bg-red-600 hover:text-white transition">
                        #{{ $tag->name }}
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Share -->
            <div class="mt-12 pt-8 border-t-2 border-gray-200">
                <h3 class="text-sm font-black uppercase tracking-wider text-gray-500 mb-4">Share This Story:</h3>
                <div class="flex gap-3">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $post->slug)) }}" 
                       target="_blank"
                       class="w-12 h-12 bg-blue-600 text-white rounded-lg flex items-center justify-center hover:bg-blue-700 transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $post->slug)) }}&text={{ urlencode($post->title) }}" 
                       target="_blank"
                       class="w-12 h-12 bg-gray-900 text-white rounded-lg flex items-center justify-center hover:bg-gray-800 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . route('blog.show', $post->slug)) }}" 
                       target="_blank"
                       class="w-12 h-12 bg-green-600 text-white rounded-lg flex items-center justify-center hover:bg-green-700 transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </article>

    <!-- Related Posts -->
    @if($relatedPosts->count() > 0)
    <section class="py-16 bg-gray-50 border-t-4 border-red-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-black text-gray-900 mb-8 uppercase">More Stories</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($relatedPosts->take(3) as $related)
                <article class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition">
                    @if($related->featured_image)
                    <div class="h-48 overflow-hidden">
                        <img src="{{ $related->featured_image }}" 
                             class="w-full h-full object-cover hover:scale-110 transition duration-500" 
                             alt="{{ $related->title }}">
                    </div>
                    @endif
                    <div class="p-6">
                        <h3 class="text-xl font-black text-gray-900 mb-2 hover:text-red-600 transition">
                            <a href="{{ route('blog.show', $related->slug) }}">
                                {{ $related->title }}
                            </a>
                        </h3>
                        <time class="text-xs text-gray-500 font-bold uppercase">
                            {{ $related->published_at->format('M d, Y') }}
                        </time>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</div>
@endsection
