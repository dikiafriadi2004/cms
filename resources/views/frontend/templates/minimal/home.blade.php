@extends('frontend.layouts.frontend')

@section('title', ($settings['site_name'] ?? 'Konter Digital') . ' - ' . ($settings['site_description'] ?? 'Modern CMS'))
@section('description', $settings['meta_description'] ?? $settings['site_description'] ?? '')

@section('content')
<!-- Minimal Template - Home -->
<main class="min-h-screen bg-white">
    <!-- Hero Section - Minimal Style -->
    <section class="pt-32 pb-20 px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl md:text-7xl font-bold text-gray-900 mb-6 leading-tight">
                {{ $settings['hero_title'] ?? 'Welcome' }}
            </h1>
            <p class="text-xl md:text-2xl text-gray-600 mb-8 leading-relaxed max-w-2xl mx-auto">
                {{ $settings['hero_subtitle'] ?? 'Clean. Simple. Focused on content.' }}
            </p>
            @if(isset($settings['hero_cta_text']) && $settings['hero_cta_text'])
            <a href="{{ $settings['hero_cta_link'] ?? '#' }}" 
               class="inline-block px-8 py-4 bg-gray-900 text-white font-medium hover:bg-gray-800 transition-colors">
                {{ $settings['hero_cta_text'] }}
            </a>
            @endif
        </div>
    </section>

    <!-- Latest Posts - Minimal Grid -->
    <section class="py-20 px-4 border-t border-gray-200">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-900 mb-12">Latest Articles</h2>
            
            <div class="space-y-12">
                @foreach($latestPosts as $post)
                <article class="group">
                    <a href="{{ route('blog.show', $post->slug) }}" class="block">
                        <div class="flex flex-col md:flex-row gap-8">
                            @if($post->featured_image)
                            <div class="md:w-1/3">
                                <div class="aspect-[4/3] overflow-hidden bg-gray-100">
                                    <img src="{{ $post->featured_image }}" 
                                         alt="{{ $post->title }}"
                                         class="w-full h-full object-cover group-hover:opacity-80 transition-opacity">
                                </div>
                            </div>
                            @endif
                            
                            <div class="flex-1">
                                <time class="text-sm text-gray-500 uppercase tracking-wider">
                                    {{ $post->published_at->format('F d, Y') }}
                                </time>
                                <h3 class="text-2xl font-bold text-gray-900 mt-2 mb-3 group-hover:text-gray-600 transition-colors">
                                    {{ $post->title }}
                                </h3>
                                <p class="text-gray-600 leading-relaxed mb-4">
                                    {{ $post->excerpt }}
                                </p>
                                <span class="text-sm font-medium text-gray-900 group-hover:underline">
                                    Read more →
                                </span>
                            </div>
                        </div>
                    </a>
                </article>
                @endforeach
            </div>
            
            <div class="text-center mt-16">
                <a href="{{ route('blog.index') }}" 
                   class="inline-block px-8 py-3 border-2 border-gray-900 text-gray-900 font-medium hover:bg-gray-900 hover:text-white transition-colors">
                    View All Articles
                </a>
            </div>
        </div>
    </section>

    <!-- About Section (if enabled) -->
    @if(isset($settings['about_enabled']) && $settings['about_enabled'])
    <section class="py-20 px-4 bg-gray-50">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">
                {{ $settings['about_title'] ?? 'About Us' }}
            </h2>
            <div class="text-lg text-gray-600 leading-relaxed">
                {!! nl2br(e($settings['about_description'] ?? '')) !!}
            </div>
        </div>
    </section>
    @endif
</main>
@endsection
