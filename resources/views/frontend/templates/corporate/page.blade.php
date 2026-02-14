@extends('frontend.layouts.frontend')

@section('title', $page->meta_title ?? $page->title . ' - ' . ($settings['site_name'] ?? 'Konter Digital'))
@section('description', $page->meta_description ?? strip_tags(substr($page->content, 0, 160)))

@section('content')
<main class="pt-40 pb-24 min-h-screen bg-gray-50">
    <!-- Corporate Professional Header -->
    <div class="bg-gradient-to-br from-blue-900 to-blue-800 text-white py-16 mb-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">
                {{ $page->title }}
            </h1>
            
            @if($page->published_at)
            <p class="text-blue-100 font-medium">
                Last Updated: {{ $page->published_at->format('d F Y') }}
            </p>
            @endif
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Content -->
        <div class="bg-white p-10 md:p-12 rounded-lg shadow-md corporate-content">
            @if($page->excerpt)
            <p class="text-xl text-gray-700 mb-10 leading-relaxed font-medium border-l-4 border-blue-600 pl-6">
                {{ $page->excerpt }}
            </p>
            @endif

            @if($page->featured_image)
            <div class="mb-10 rounded-lg overflow-hidden">
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
.corporate-content h2 { 
    font-size: 2rem; 
    font-weight: 700; 
    color: #1e40af; 
    margin-top: 2.5rem; 
    margin-bottom: 1rem;
}
.corporate-content h3 { 
    font-size: 1.5rem; 
    font-weight: 600; 
    color: #1e40af; 
    margin-top: 2rem; 
    margin-bottom: 0.75rem;
}
.corporate-content p { 
    color: #4b5563; 
    line-height: 1.8; 
    margin-bottom: 1.25rem;
    font-size: 1.0625rem;
}
.corporate-content ul, .corporate-content ol { 
    margin-left: 1.5rem; 
    margin-bottom: 1.5rem; 
    color: #4b5563;
}
.corporate-content li { 
    margin-bottom: 0.5rem; 
}
.corporate-content a {
    color: #2563eb;
    text-decoration: underline;
    font-weight: 600;
}
.corporate-content a:hover {
    color: #1e40af;
}
.corporate-content strong {
    font-weight: 700;
    color: #1f2937;
}
.corporate-content blockquote {
    border-left: 4px solid #2563eb;
    padding-left: 1.5rem;
    margin: 2rem 0;
    font-style: italic;
    color: #6b7280;
}
</style>
@endpush
