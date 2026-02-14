@extends('frontend.layouts.frontend')

@section('title', $page->meta_title ?? $page->title . ' - ' . ($settings['site_name'] ?? 'Konter Digital'))
@section('description', $page->meta_description ?? strip_tags(substr($page->content, 0, 160)))

@section('content')
<main class="pt-40 pb-24 min-h-screen bg-gradient-to-b from-amber-50 to-white">
    <!-- Elegant Header -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-16">
        <div class="inline-block mb-6">
            <div class="h-px w-24 bg-gradient-to-r from-transparent via-amber-400 to-transparent"></div>
        </div>
        
        <h1 class="text-5xl md:text-6xl font-serif text-slate-900 mb-6 tracking-tight" style="font-family: 'Playfair Display', serif;">
            {{ $page->title }}
        </h1>
        
        @if($page->published_at)
        <p class="text-amber-700 text-sm tracking-wider uppercase">
            Last Updated: {{ $page->published_at->format('d F Y') }}
        </p>
        @endif
        
        <div class="h-px w-24 bg-gradient-to-r from-transparent via-amber-400 to-transparent mx-auto mt-6"></div>
    </div>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Content -->
        <div class="bg-white p-10 md:p-12 border-2 border-amber-100 elegant-content">
            @if($page->excerpt)
            <p class="text-xl text-slate-700 mb-10 leading-relaxed font-serif italic border-l-4 border-amber-400 pl-6" style="font-family: 'Playfair Display', serif;">
                {{ $page->excerpt }}
            </p>
            @endif

            @if($page->featured_image)
            <div class="mb-10 border-4 border-amber-100">
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
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
.elegant-content {
    font-family: Georgia, 'Times New Roman', serif;
}
.elegant-content h2 { 
    font-family: 'Playfair Display', serif;
    font-size: 2rem; 
    font-weight: 600; 
    color: #78350f; 
    margin-top: 2.5rem; 
    margin-bottom: 1rem;
}
.elegant-content h3 { 
    font-family: 'Playfair Display', serif;
    font-size: 1.5rem; 
    font-weight: 600; 
    color: #92400e; 
    margin-top: 2rem; 
    margin-bottom: 0.75rem;
}
.elegant-content p { 
    color: #475569; 
    line-height: 1.8; 
    margin-bottom: 1.5rem;
    font-size: 1.0625rem;
}
.elegant-content ul, .elegant-content ol { 
    margin-left: 1.5rem; 
    margin-bottom: 1.5rem; 
    color: #475569;
}
.elegant-content li { 
    margin-bottom: 0.5rem; 
}
.elegant-content a {
    color: #d97706;
    text-decoration: underline;
    text-decoration-color: #fbbf24;
}
.elegant-content a:hover {
    color: #b45309;
}
.elegant-content strong {
    font-weight: 700;
    color: #78350f;
}
.elegant-content blockquote {
    border-left: 4px solid #f59e0b;
    padding-left: 1.5rem;
    margin: 2rem 0;
    font-style: italic;
    color: #64748b;
    font-family: 'Playfair Display', serif;
}
</style>
@endpush
