@extends('frontend.layouts.frontend')

@section('title', 'Blog & Berita - ' . ($settings['site_name'] ?? 'Konter Digital'))
@section('description', 'Temukan tips eksklusif dan panduan sukses untuk mengembangkan bisnis server pulsa Anda.')

@section('content')
<!-- Elegant Header with Gold Accent -->
<header class="pt-40 pb-16 bg-gradient-to-b from-amber-50 to-white border-b border-amber-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-block mb-6">
            <span class="text-amber-600 text-sm font-serif tracking-[0.3em] uppercase">Wawasan Premium</span>
            <div class="h-px bg-gradient-to-r from-transparent via-amber-400 to-transparent mt-2"></div>
        </div>
        <h1 class="text-5xl md:text-6xl font-serif text-slate-900 mb-6 tracking-tight" style="font-family: 'Playfair Display', serif;">
            Blog {{ $settings['site_name'] ?? 'Konter Digital' }}
        </h1>
        <p class="text-slate-600 max-w-2xl mx-auto text-lg leading-relaxed">
            Temukan tips eksklusif dan panduan sukses untuk mengembangkan bisnis server pulsa Anda.
        </p>
    </div>
</header>

<!-- Main Content -->
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 bg-white">
    <!-- Category Filter -->
    @if(isset($categories) && $categories->count() > 0)
    <div class="flex flex-wrap items-center justify-center gap-4 mb-20">
        <a href="{{ route('blog.index') }}" class="px-8 py-3 rounded-full {{ !request()->route('category') ? 'bg-gradient-to-r from-amber-500 to-amber-600 text-white shadow-lg shadow-amber-500/30' : 'bg-white text-slate-700 border border-amber-200 hover:border-amber-400' }} font-medium text-sm transition-all duration-300">
            Semua Artikel
        </a>
        @foreach($categories as $category)
        <a href="{{ route('blog.category', $category->slug) }}" class="px-8 py-3 rounded-full {{ request()->route('category') == $category->slug ? 'bg-gradient-to-r from-amber-500 to-amber-600 text-white shadow-lg shadow-amber-500/30' : 'bg-white text-slate-700 border border-amber-200 hover:border-amber-400' }} font-medium text-sm transition-all duration-300">
            {{ $category->name }}
        </a>
        @endforeach
    </div>
    @endif

    <!-- Luxury Blog Grid -->
    @if($posts->count() > 0)
    <!-- Content Top Ads -->
    @if(isset($ads['content_top']) && $ads['content_top']->count() > 0)
        <div class="mb-12 bg-white border-2 border-amber-100 p-10">
            @foreach($ads['content_top'] as $ad)
                <div class="mb-4">
                    {!! $ad->render() !!}
                </div>
            @endforeach
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
        @foreach($posts as $index => $post)
        <article class="group bg-white overflow-hidden hover:transform hover:-translate-y-2 transition-all duration-500">
            <!-- Featured Image with Gold Border -->
            <div class="relative overflow-hidden mb-6 border-2 border-amber-100 group-hover:border-amber-400 transition-colors duration-500">
                @if($post->featured_image)
                    <img src="{{ $post->featured_image }}" class="w-full h-72 object-cover group-hover:scale-105 transition duration-700" alt="{{ $post->title }}">
                @else
                    <div class="w-full h-72 bg-gradient-to-br from-amber-100 to-amber-200 flex items-center justify-center">
                        <svg class="w-20 h-20 text-amber-400 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
                <!-- Gold Corner Accent -->
                <div class="absolute top-0 right-0 w-16 h-16 bg-gradient-to-br from-amber-400 to-amber-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500" style="clip-path: polygon(100% 0, 0 0, 100% 100%);"></div>
            </div>

            <!-- Content -->
            <div class="px-2">
                <!-- Meta -->
                <div class="flex items-center gap-3 text-xs text-amber-700 mb-4 font-medium tracking-wider">
                    @if($post->category)
                        <span class="uppercase">{{ $post->category->name }}</span>
                        <span class="text-amber-300">•</span>
                    @endif
                    <span class="text-slate-500">{{ $post->published_at->format('d M Y') }}</span>
                </div>

                <!-- Title -->
                <h2 class="text-2xl font-serif text-slate-900 group-hover:text-amber-700 transition-colors mb-4 leading-tight" style="font-family: 'Playfair Display', serif;">
                    <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                </h2>

                <!-- Excerpt -->
                <p class="text-slate-600 text-sm leading-relaxed mb-6 line-clamp-3">
                    {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 150) }}
                </p>

                <!-- Read More with Gold Underline -->
                <a href="{{ route('blog.show', $post->slug) }}" class="inline-flex items-center gap-2 text-amber-700 font-medium text-sm group/link relative">
                    <span class="relative">
                        Baca Selengkapnya
                        <span class="absolute bottom-0 left-0 w-0 h-px bg-gradient-to-r from-amber-500 to-amber-600 group-hover/link:w-full transition-all duration-300"></span>
                    </span>
                    <svg class="w-4 h-4 group-hover/link:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </article>

        <!-- Between Posts Ads (after every 3rd post) -->
        @if(($index + 1) % 3 == 0 && isset($ads['between_posts']) && $ads['between_posts']->count() > 0)
            <div class="col-span-1 md:col-span-2 lg:col-span-3 bg-white border-2 border-amber-100 p-10">
                @foreach($ads['between_posts'] as $ad)
                    <div class="mb-4">
                        {!! $ad->render() !!}
                    </div>
                @endforeach
            </div>
        @endif
        @endforeach
    </div>

    <!-- Elegant Pagination -->
    @if($posts->hasPages())
    <div class="mt-24 flex justify-center items-center gap-2">
        @if($posts->onFirstPage())
            <span class="w-12 h-12 flex items-center justify-center rounded-full bg-amber-50 text-amber-300 cursor-not-allowed">&larr;</span>
        @else
            <a href="{{ $posts->previousPageUrl() }}" class="w-12 h-12 flex items-center justify-center rounded-full bg-white border border-amber-200 text-amber-700 hover:bg-amber-50 transition">&larr;</a>
        @endif

        @foreach($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
            @if($page == $posts->currentPage())
                <span class="w-12 h-12 flex items-center justify-center rounded-full bg-gradient-to-r from-amber-500 to-amber-600 text-white shadow-lg shadow-amber-500/30 font-medium">{{ $page }}</span>
            @else
                <a href="{{ $url }}" class="w-12 h-12 flex items-center justify-center rounded-full bg-white border border-amber-200 text-slate-700 hover:bg-amber-50 transition font-medium">{{ $page }}</a>
            @endif
        @endforeach

        @if($posts->hasMorePages())
            <a href="{{ $posts->nextPageUrl() }}" class="w-12 h-12 flex items-center justify-center rounded-full bg-white border border-amber-200 text-amber-700 hover:bg-amber-50 transition">&rarr;</a>
        @else
            <span class="w-12 h-12 flex items-center justify-center rounded-full bg-amber-50 text-amber-300 cursor-not-allowed">&rarr;</span>
        @endif
    </div>
    @endif
    @else
    <!-- Elegant Empty State -->
    <div class="text-center py-24">
        <div class="inline-block p-6 bg-amber-50 rounded-full mb-6">
            <svg class="w-16 h-16 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <h3 class="text-3xl font-serif text-slate-900 mb-3" style="font-family: 'Playfair Display', serif;">Belum Ada Artikel</h3>
        <p class="text-slate-600">Artikel premium akan segera hadir. Pantau terus halaman ini!</p>
    </div>
    @endif
</main>
@endsection

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
