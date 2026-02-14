@extends('frontend.layouts.frontend')

@section('title', 'Blog & Berita - ' . ($settings['site_name'] ?? 'Konter Digital'))
@section('description', 'Temukan tips eksklusif dan panduan sukses untuk mengembangkan bisnis server pulsa Anda.')

@push('styles')
<style>
/* Magazine Template - Bold & Image Heavy */
.magazine-blog {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

.magazine-header {
    background: linear-gradient(135deg, #dc2626 0%, #f97316 100%);
}

.magazine-card {
    transition: all 0.3s ease;
}

.magazine-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(220, 38, 38, 0.2);
}

.magazine-category {
    background: #dc2626;
    color: white;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
</style>
@endpush

@section('content')
<div class="magazine-blog bg-gray-50">
    <!-- Bold Header -->
    <header class="magazine-header py-24 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <span class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-black uppercase tracking-wider mb-4">
                    Latest News
                </span>
                <h1 class="text-5xl md:text-7xl font-black mb-6 leading-tight">
                    MAGAZINE
                </h1>
                <p class="text-xl md:text-2xl font-medium opacity-90 max-w-3xl mx-auto">
                    Breaking stories, exclusive interviews, and in-depth analysis
                </p>
            </div>
        </div>
    </header>

    <!-- Category Filter -->
    @if(isset($categories) && $categories->count() > 0)
    <div class="bg-white border-b-4 border-red-600 sticky top-0 z-40 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-wrap items-center justify-center gap-2">
                <a href="{{ route('blog.index') }}" 
                   class="px-6 py-2 rounded-full font-black text-sm uppercase tracking-wider transition {{ !request()->route('category') ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-red-100' }}">
                    All
                </a>
                @foreach($categories as $category)
                <a href="{{ route('blog.category', $category->slug) }}" 
                   class="px-6 py-2 rounded-full font-black text-sm uppercase tracking-wider transition {{ request()->route('category') == $category->slug ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-red-100' }}">
                    {{ $category->name }}
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Magazine Grid -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Content Top Ads -->
        @if(isset($ads['content_top']) && $ads['content_top']->count() > 0)
            <div class="mb-12 border-4 border-black p-6 bg-white">
                @foreach($ads['content_top'] as $ad)
                    <div class="mb-4">
                        {!! $ad->render() !!}
                    </div>
                @endforeach
            </div>
        @endif

        @if($posts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($posts as $index => $post)
            <article class="magazine-card bg-white rounded-2xl overflow-hidden shadow-lg">
                <!-- Large Image -->
                <div class="relative h-64 overflow-hidden">
                    @if($post->featured_image)
                        <img src="{{ $post->featured_image }}" 
                             class="w-full h-full object-cover" 
                             alt="{{ $post->title }}">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-red-500 to-orange-500"></div>
                    @endif
                    
                    <!-- Category Badge -->
                    @if($post->category)
                    <div class="absolute top-4 left-4">
                        <span class="magazine-category px-4 py-2 rounded-lg text-xs">
                            {{ $post->category->name }}
                        </span>
                    </div>
                    @endif
                </div>

                <!-- Content -->
                <div class="p-6">
                    <!-- Date -->
                    <time class="text-xs text-gray-500 font-bold uppercase tracking-wider">
                        {{ $post->published_at->format('M d, Y') }}
                    </time>

                    <!-- Title -->
                    <h2 class="text-2xl font-black text-gray-900 mt-3 mb-3 leading-tight hover:text-red-600 transition">
                        <a href="{{ route('blog.show', $post->slug) }}">
                            {{ $post->title }}
                        </a>
                    </h2>

                    <!-- Excerpt -->
                    <p class="text-gray-600 leading-relaxed line-clamp-3">
                        {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 120) }}
                    </p>

                    <!-- Read More -->
                    <a href="{{ route('blog.show', $post->slug) }}" 
                       class="inline-flex items-center gap-2 mt-4 text-red-600 font-black text-sm uppercase tracking-wider hover:gap-3 transition-all">
                        Read Full Story
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </article>

            <!-- Between Posts Ads (after every 3rd post) -->
            @if(($index + 1) % 3 == 0 && isset($ads['between_posts']) && $ads['between_posts']->count() > 0)
                <div class="col-span-1 md:col-span-2 lg:col-span-3 border-4 border-black p-6 bg-white">
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
        <div class="mt-16 flex justify-center">
            {{ $posts->links() }}
        </div>
        @endif
        @else
        <div class="text-center py-20">
            <div class="text-6xl font-black text-gray-300 mb-4">404</div>
            <h3 class="text-2xl font-black text-gray-900 mb-2">No Stories Yet</h3>
            <p class="text-gray-600">Check back soon for breaking news!</p>
        </div>
        @endif
    </main>
</div>
@endsection

@push('scripts')
<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endpush
