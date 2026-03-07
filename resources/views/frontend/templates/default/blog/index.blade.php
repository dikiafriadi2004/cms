@extends('frontend.layouts.frontend')

@section('title', ($settings['site_name'] ?? config('app.name')) . ' - Blog & Berita')
@section('description', $settings['blog_page_description'] ?? 'Baca artikel dan berita terbaru dari kami.')

@section('content')
<!-- Header -->
<header class="pt-40 pb-12 bg-white border-b border-slate-100 text-center">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="inline-block py-1 px-4 rounded-full bg-brand-50 text-brand-600 text-xs font-bold mb-4 uppercase tracking-widest">Wawasan Agen</span>
        <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-4 tracking-tight">Blog {{ $settings['site_name'] ?? 'Konter Digital' }}</h1>
        <p class="text-slate-500 max-w-2xl mx-auto text-lg">{{ $settings['blog_page_description'] ?? 'Baca artikel dan berita terbaru dari kami.' }}</p>
    </div>
</header>

<!-- Main Content -->
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 bg-white">
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

    <!-- Category Filter with AJAX -->
    <div class="flex flex-wrap items-center justify-center gap-3 mb-16">
        <button 
            class="category-filter-btn px-6 py-2.5 rounded-xl text-white font-bold text-sm transition-all duration-200 active"
            data-category=""
            style="background-color: #3b82f6; box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.3); border: none;">
            Semua
        </button>
        
        @foreach($categories as $category)
        <button 
            class="category-filter-btn px-6 py-2.5 rounded-xl bg-white text-slate-600 border border-slate-200 hover:border-brand-600 hover:text-brand-600 font-bold text-sm transition-all duration-200"
            data-category="{{ $category->slug }}">
            {{ $category->name }}
        </button>
        @endforeach
    </div>

    <!-- Blog Grid -->
    <div id="posts-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 min-h-[400px]">
        @include('frontend.templates.default.blog.partials.posts-grid')
    </div>

    <!-- Pagination -->
    <div id="pagination-container" class="mt-20">
        {{ $posts->onEachSide(1)->links('partials.pagination-custom') }}
    </div>
</main>
@endsection

@push('styles')
<style>
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Category Filter Button Styles */
    .category-filter-btn {
        transition: all 0.2s ease;
    }
    
    .category-filter-btn:hover {
        transform: translateY(-2px);
    }
    
    /* Active button style - using Tailwind classes via JavaScript */
    
    /* Loading State */
    #posts-container.loading {
        position: relative;
        opacity: 0.5;
        pointer-events: none;
    }
    
    #posts-container.loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 50px;
        height: 50px;
        border: 4px solid #f3f4f6;
        border-top-color: #3b82f6;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }
    
    @keyframes spin {
        to { transform: translate(-50%, -50%) rotate(360deg); }
    }
    
    /* Fade In Animation */
    .fade-in {
        animation: fadeIn 0.4s ease-in;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/blog-filter.js') }}"></script>
@endpush
