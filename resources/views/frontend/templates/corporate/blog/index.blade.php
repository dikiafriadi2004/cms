@extends('frontend.layouts.frontend')

@section('title', 'Blog & Insights - ' . ($settings['site_name'] ?? 'Konter Digital'))
@section('description', 'Temukan tips eksklusif dan panduan sukses untuk mengembangkan bisnis server pulsa Anda.')

@push('styles')
<style>
/* Corporate Template - Professional & Trust-Building */
.corporate-blog {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

.corporate-header {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
}

.corporate-card {
    transition: all 0.3s ease;
    border: 2px solid #e5e7eb;
}

.corporate-card:hover {
    border-color: #3b82f6;
    box-shadow: 0 10px 30px rgba(59, 130, 246, 0.15);
}
</style>
@endpush

@section('content')
<div class="corporate-blog bg-gray-50">
    <!-- Professional Header -->
    <header class="corporate-header py-20 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <span class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm rounded-lg text-sm font-semibold uppercase tracking-wider mb-4">
                    Knowledge Center
                </span>
                <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">
                    Insights & Resources
                </h1>
                <p class="text-xl opacity-90">
                    Expert perspectives, industry trends, and practical guides to help your business succeed.
                </p>
            </div>
        </div>
    </header>

    <!-- Category Filter -->
    @if(isset($categories) && $categories->count() > 0)
    <div class="bg-white border-b shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-wrap items-center gap-3">
                <span class="text-sm font-semibold text-gray-600">Filter by:</span>
                <a href="{{ route('blog.index') }}" 
                   class="px-5 py-2 rounded-lg font-semibold text-sm transition {{ !request()->route('category') ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-blue-50' }}">
                    All Topics
                </a>
                @foreach($categories as $category)
                <a href="{{ route('blog.category', $category->slug) }}" 
                   class="px-5 py-2 rounded-lg font-semibold text-sm transition {{ request()->route('category') == $category->slug ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-blue-50' }}">
                    {{ $category->name }}
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Professional Grid -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Content Top Ads -->
        @if(isset($ads['content_top']) && $ads['content_top']->count() > 0)
            <div class="mb-12 bg-white rounded-lg shadow-md p-8">
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
            <article class="corporate-card bg-white rounded-xl overflow-hidden">
                <!-- Image -->
                <div class="relative h-56 overflow-hidden bg-gray-100">
                    @if($post->featured_image)
                        <img src="{{ $post->featured_image }}" 
                             class="w-full h-full object-cover" 
                             alt="{{ $post->title }}">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Content -->
                <div class="p-6">
                    <!-- Meta -->
                    <div class="flex items-center gap-3 text-xs text-gray-500 font-medium mb-3">
                        @if($post->category)
                            <span class="text-blue-600 font-semibold">{{ $post->category->name }}</span>
                            <span>•</span>
                        @endif
                        <time>{{ $post->published_at->format('M d, Y') }}</time>
                    </div>

                    <!-- Title -->
                    <h2 class="text-xl font-bold text-gray-900 mb-3 leading-tight hover:text-blue-600 transition">
                        <a href="{{ route('blog.show', $post->slug) }}">
                            {{ $post->title }}
                        </a>
                    </h2>

                    <!-- Excerpt -->
                    <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3">
                        {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 120) }}
                    </p>

                    <!-- Read More -->
                    <a href="{{ route('blog.show', $post->slug) }}" 
                       class="inline-flex items-center gap-2 text-blue-600 font-semibold text-sm hover:gap-3 transition-all">
                        Read Article
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </article>

            <!-- Between Posts Ads (after every 3rd post) -->
            @if(($index + 1) % 3 == 0 && isset($ads['between_posts']) && $ads['between_posts']->count() > 0)
                <div class="col-span-1 md:col-span-2 lg:col-span-3 bg-white rounded-lg shadow-md p-8">
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
            <svg class="w-24 h-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">No Articles Available</h3>
            <p class="text-gray-600">Check back soon for new insights and resources.</p>
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
