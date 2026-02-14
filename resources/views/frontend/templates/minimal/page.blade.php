@extends('frontend.layouts.frontend')

@section('title', $page->meta_title ?? $page->title . ' - ' . ($settings['site_name'] ?? 'Konter Digital'))
@section('description', $page->meta_description ?? strip_tags(substr($page->content, 0, 160)))

@section('content')
<main class="pt-40 pb-24 min-h-screen bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Minimal Header -->
        <div class="mb-16 pb-12 border-b-2 border-black">
            <h1 class="text-5xl md:text-7xl font-black text-black mb-6 tracking-tight">
                {{ $page->title }}
            </h1>
            
            @if($page->published_at)
            <p class="text-gray-500 text-sm uppercase tracking-wider">
                Updated: {{ $page->published_at->format('d F Y') }}
            </p>
            @endif
        </div>

        <!-- Page Content -->
        <div class="minimal-content">
            @if($page->excerpt)
            <p class="text-xl text-gray-700 mb-12 leading-relaxed font-medium">
                {{ $page->excerpt }}
            </p>
            @endif

            @if($page->featured_image)
            <div class="mb-12">
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
.minimal-content h2 { 
    font-size: 2rem; 
    font-weight: 900; 
    color: #000; 
    margin-top: 3rem; 
    margin-bottom: 1rem;
    text-transform: uppercase;
    letter-spacing: -0.02em;
}
.minimal-content h3 { 
    font-size: 1.5rem; 
    font-weight: 800; 
    color: #000; 
    margin-top: 2.5rem; 
    margin-bottom: 0.75rem;
}
.minimal-content p { 
    color: #374151; 
    line-height: 1.8; 
    margin-bottom: 1.5rem;
    font-size: 1.125rem;
}
.minimal-content ul, .minimal-content ol { 
    margin-left: 2rem; 
    margin-bottom: 2rem; 
    color: #374151;
    font-size: 1.125rem;
}
.minimal-content li { 
    margin-bottom: 0.75rem; 
}
.minimal-content a {
    color: #000;
    text-decoration: underline;
    font-weight: 600;
}
.minimal-content a:hover {
    color: #374151;
}
.minimal-content strong {
    font-weight: 800;
    color: #000;
}
</style>
@endpush
