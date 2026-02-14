@extends('frontend.layouts.frontend')

@section('title', $post->meta_title ?: $post->title . ' - ' . ($settings['site_name'] ?? 'Konter Digital'))
@section('description', $post->meta_description ?: Str::limit(strip_tags($post->content), 160))

@section('content')
<!-- Elegant Article Header -->
<article class="bg-gradient-to-b from-amber-50 to-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-40 pb-16">
        <!-- Category & Date -->
        <div class="flex items-center justify-center gap-4 mb-8">
            @if($post->category)
                <a href="{{ route('blog.category', $post->category->slug) }}" class="text-amber-700 text-sm font-medium tracking-wider uppercase hover:text-amber-800 transition">
                    {{ $post->category->name }}
                </a>
                <span class="text-amber-300">•</span>
            @endif
            <time class="text-slate-500 text-sm">{{ $post->published_at->format('d F Y') }}</time>
        </div>

        <!-- Title -->
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-serif text-slate-900 mb-8 text-center leading-tight" style="font-family: 'Playfair Display', serif;">
            {{ $post->title }}
        </h1>

        <!-- Author & Reading Time -->
        <div class="flex items-center justify-center gap-6 text-sm text-slate-600 mb-12">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white font-medium">
                    {{ substr($post->user->name, 0, 1) }}
                </div>
                <span class="font-medium">{{ $post->user->name }}</span>
            </div>
            <span class="text-amber-300">•</span>
            <span>{{ ceil(str_word_count(strip_tags($post->content)) / 200) }} menit baca</span>
        </div>

        <!-- Gold Divider -->
        <div class="flex items-center justify-center mb-12">
            <div class="h-px w-24 bg-gradient-to-r from-transparent via-amber-400 to-transparent"></div>
        </div>
    </div>

    <!-- Featured Image -->
    @if($post->featured_image)
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
        <div class="relative border-4 border-amber-100 overflow-hidden">
            <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-auto">
            <!-- Gold Corner Accents -->
            <div class="absolute top-0 left-0 w-20 h-20 bg-gradient-to-br from-amber-400 to-transparent opacity-50"></div>
            <div class="absolute bottom-0 right-0 w-20 h-20 bg-gradient-to-tl from-amber-400 to-transparent opacity-50"></div>
        </div>
    </div>
    @endif
</article>

<!-- Article Content -->
<div class="bg-white py-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Excerpt -->
        @if($post->excerpt)
        <div class="text-xl text-slate-700 leading-relaxed mb-12 pb-12 border-b border-amber-100 font-serif italic" style="font-family: 'Playfair Display', serif;">
            {{ $post->excerpt }}
        </div>
        @endif

        <!-- Content Top Ads -->
        @if(isset($ads['content_top']) && $ads['content_top']->count() > 0)
            <div class="my-12 bg-white border-2 border-amber-100 p-10">
                @foreach($ads['content_top'] as $ad)
                    <div class="mb-4">
                        {!! $ad->render() !!}
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Content -->
        <div class="prose prose-lg prose-slate max-w-none elegant-content">
            {!! $post->content !!}
        </div>

        <!-- Content Bottom Ads -->
        @if(isset($ads['content_bottom']) && $ads['content_bottom']->count() > 0)
            <div class="mt-12 bg-white border-2 border-amber-100 p-10">
                @foreach($ads['content_bottom'] as $ad)
                    <div class="mb-4">
                        {!! $ad->render() !!}
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Tags -->
        @if($post->tags->count() > 0)
        <div class="mt-16 pt-12 border-t border-amber-100">
            <div class="flex items-center gap-3 flex-wrap">
                <span class="text-amber-700 font-medium text-sm tracking-wider uppercase">Tags:</span>
                @foreach($post->tags as $tag)
                <a href="{{ route('blog.tag', $tag->slug) }}" class="px-4 py-2 bg-amber-50 text-amber-700 rounded-full text-sm hover:bg-amber-100 transition">
                    {{ $tag->name }}
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Share Buttons -->
        <div class="mt-12 pt-12 border-t border-amber-100">
            <p class="text-amber-700 font-medium text-sm tracking-wider uppercase mb-4">Bagikan Artikel:</p>
            <div class="flex gap-3">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $post->slug)) }}" target="_blank" class="w-12 h-12 flex items-center justify-center rounded-full bg-amber-50 text-amber-700 hover:bg-amber-100 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $post->slug)) }}&text={{ urlencode($post->title) }}" target="_blank" class="w-12 h-12 flex items-center justify-center rounded-full bg-amber-50 text-amber-700 hover:bg-amber-100 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                </a>
                <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . route('blog.show', $post->slug)) }}" target="_blank" class="w-12 h-12 flex items-center justify-center rounded-full bg-amber-50 text-amber-700 hover:bg-amber-100 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Related Posts -->
@if(isset($relatedPosts) && $relatedPosts->count() > 0)
<section class="bg-amber-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-amber-600 text-sm font-serif tracking-[0.3em] uppercase">Baca Juga</span>
            <div class="h-px w-24 bg-gradient-to-r from-transparent via-amber-400 to-transparent mx-auto mt-2 mb-6"></div>
            <h2 class="text-3xl md:text-4xl font-serif text-slate-900" style="font-family: 'Playfair Display', serif;">Artikel Terkait</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            @foreach($relatedPosts as $relatedPost)
            <article class="group bg-white overflow-hidden hover:transform hover:-translate-y-2 transition-all duration-500">
                <div class="relative overflow-hidden mb-6 border-2 border-amber-100 group-hover:border-amber-400 transition-colors duration-500">
                    @if($relatedPost->featured_image)
                        <img src="{{ $relatedPost->featured_image }}" class="w-full h-56 object-cover group-hover:scale-105 transition duration-700" alt="{{ $relatedPost->title }}">
                    @else
                        <div class="w-full h-56 bg-gradient-to-br from-amber-100 to-amber-200"></div>
                    @endif
                </div>
                <div class="px-2">
                    <h3 class="text-xl font-serif text-slate-900 group-hover:text-amber-700 transition-colors mb-3 leading-tight" style="font-family: 'Playfair Display', serif;">
                        <a href="{{ route('blog.show', $relatedPost->slug) }}">{{ $relatedPost->title }}</a>
                    </h3>
                    <p class="text-slate-600 text-sm mb-4 line-clamp-2">
                        {{ $relatedPost->excerpt ?: Str::limit(strip_tags($relatedPost->content), 100) }}
                    </p>
                    <a href="{{ route('blog.show', $relatedPost->slug) }}" class="text-amber-700 text-sm font-medium hover:text-amber-800 transition">
                        Baca Artikel →
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    .elegant-content {
        font-family: Georgia, 'Times New Roman', serif;
        line-height: 1.8;
    }
    .elegant-content h2 {
        font-family: 'Playfair Display', serif;
        color: #78350f;
        margin-top: 2.5rem;
        margin-bottom: 1.5rem;
    }
    .elegant-content h3 {
        font-family: 'Playfair Display', serif;
        color: #92400e;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }
    .elegant-content p {
        margin-bottom: 1.5rem;
        color: #475569;
    }
    .elegant-content a {
        color: #d97706;
        text-decoration: underline;
        text-decoration-color: #fbbf24;
    }
    .elegant-content a:hover {
        color: #b45309;
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
