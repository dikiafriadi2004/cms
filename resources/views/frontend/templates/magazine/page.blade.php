@extends('frontend.layouts.frontend')

@section('title', $page->meta_title ?? $page->title . ' - ' . ($settings['site_name'] ?? 'Konter Digital'))
@section('description', $page->meta_description ?? strip_tags(substr($page->content, 0, 160)))

@section('content')
<main class="pt-40 pb-24 min-h-screen bg-white">
    <!-- Magazine Bold Header -->
    <div class="bg-gradient-to-r from-red-600 to-orange-500 text-white py-16 mb-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-2 h-20 bg-white"></div>
                <h1 class="text-5xl md:text-7xl font-black uppercase tracking-tight">
                    {{ $page->title }}
                </h1>
            </div>
            
            @if($page->published_at)
            <p class="text-white/90 font-bold text-lg">
                Last Updated: {{ $page->published_at->format('d F Y') }}
            </p>
            @endif
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Content -->
        <div class="magazine-content">
            @if($page->excerpt)
            <p class="text-2xl text-gray-800 mb-12 leading-relaxed font-bold border-l-8 border-red-600 pl-6">
                {{ $page->excerpt }}
            </p>
            @endif

            @if($page->featured_image)
            <div class="mb-12 border-4 border-black">
                <img src="{{ $page->featured_image }}" 
                     alt="{{ $page->title }}" 
                     class="w-full h-auto">
            </div>
            @endif

            <div class="prose-content">
                {!! $page->content !!}
            </div>
        </div>
    </div>
</main>
@endsection

@push('styles')
<style>
.magazine-content h2 { 
    font-size: 2.5rem; 
    font-weight: 900; 
    color: #dc2626; 
    margin-top: 3rem; 
    margin-bottom: 1.5rem;
    text-transform: uppercase;
    letter-spacing: -0.02em;
}
.magazine-content h3 { 
    font-size: 2rem; 
    font-weight: 800; 
    color: #ea580c; 
    margin-top: 2.5rem; 
    margin-bottom: 1rem;
    text-transform: uppercase;
}
.magazine-content p { 
    color: #1f2937; 
    line-height: 1.8; 
    margin-bottom: 1.5rem;
    font-size: 1.125rem;
    font-weight: 500;
}
.magazine-content ul, .magazine-content ol { 
    margin-left: 2rem; 
    margin-bottom: 2rem; 
    color: #1f2937;
    font-size: 1.125rem;
    font-weight: 500;
}
.magazine-content li { 
    margin-bottom: 1rem; 
}
.magazine-content a {
    color: #dc2626;
    text-decoration: underline;
    font-weight: 700;
}
.magazine-content a:hover {
    color: #b91c1c;
}
.magazine-content strong {
    font-weight: 900;
    color: #000;
}
.magazine-content blockquote {
    border-left: 8px solid #dc2626;
    padding-left: 2rem;
    margin: 2rem 0;
    font-weight: 700;
    font-size: 1.25rem;
    color: #1f2937;
}
</style>
@endpush
