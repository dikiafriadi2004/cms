@extends('frontend.layouts.frontend')

@section('title', $page->meta_title ?? $page->title . ' - ' . ($settings['site_name'] ?? 'Konter Digital'))
@section('description', $page->meta_description ?? strip_tags(substr($page->content, 0, 160)))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-purple-50 py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">{{ $page->title }}</h1>
            @if($page->excerpt)
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">{{ $page->excerpt }}</p>
            @endif
            <div class="flex items-center justify-center text-sm text-gray-500 mt-4 space-x-4">
                @if($page->published_at)
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $page->published_at->format('F d, Y') }}
                    </span>
                @endif
                @if($page->updated_at && $page->updated_at != $page->created_at)
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Updated {{ $page->updated_at->format('M d, Y') }}
                    </span>
                @endif
            </div>
        </div>

        <!-- Content -->
        <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12">
            @if($page->featured_image)
                <div class="mb-8 -mx-8 md:-mx-12 -mt-8 md:-mt-12">
                    <img src="{{ $page->featured_image }}" alt="{{ $page->title }}" class="w-full h-64 md:h-96 object-cover rounded-t-3xl">
                </div>
            @endif

            <div class="prose prose-lg max-w-none">
                <div class="text-gray-700 leading-relaxed">
                    {!! $page->content !!}
                </div>
            </div>

            <!-- Last Updated -->
            @if($page->updated_at)
                <div class="mt-12 pt-8 border-t border-gray-200">
                    <p class="text-sm text-gray-500">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Last updated: {{ $page->updated_at->format('F d, Y \a\t h:i A') }}
                    </p>
                </div>
            @endif
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-8">
            <a href="{{ route('home') }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 font-semibold">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Home
            </a>
        </div>
    </div>
</div>

<style>
.prose {
    color: #374151;
}
.prose h1 {
    font-size: 2.25rem;
    font-weight: 800;
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: #111827;
}
.prose h2 {
    font-size: 1.875rem;
    font-weight: 700;
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: #111827;
}
.prose h3 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
    color: #111827;
}
.prose p {
    margin-bottom: 1.25rem;
    line-height: 1.75;
}
.prose ul, .prose ol {
    margin-bottom: 1.25rem;
    padding-left: 1.5rem;
}
.prose li {
    margin-bottom: 0.5rem;
}
.prose a {
    color: #7c3aed;
    text-decoration: underline;
}
.prose a:hover {
    color: #6d28d9;
}
.prose strong {
    font-weight: 600;
    color: #111827;
}
.prose blockquote {
    border-left: 4px solid #7c3aed;
    padding-left: 1rem;
    font-style: italic;
    color: #6b7280;
    margin: 1.5rem 0;
}
.prose code {
    background-color: #f3f4f6;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
    color: #7c3aed;
}
.prose pre {
    background-color: #1f2937;
    color: #f9fafb;
    padding: 1rem;
    border-radius: 0.5rem;
    overflow-x: auto;
    margin: 1.5rem 0;
}
.prose img {
    border-radius: 0.5rem;
    margin: 1.5rem 0;
}
.prose table {
    width: 100%;
    border-collapse: collapse;
    margin: 1.5rem 0;
}
.prose th {
    background-color: #f3f4f6;
    padding: 0.75rem;
    text-align: left;
    font-weight: 600;
    border: 1px solid #e5e7eb;
}
.prose td {
    padding: 0.75rem;
    border: 1px solid #e5e7eb;
}
</style>
@endsection
