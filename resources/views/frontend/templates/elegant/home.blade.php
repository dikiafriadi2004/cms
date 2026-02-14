@extends('frontend.layouts.frontend')

@section('title', ($settings['site_name'] ?? 'Konter Digital') . ' - ' . ($settings['site_description'] ?? 'Modern CMS'))
@section('description', $settings['meta_description'] ?? $settings['site_description'] ?? '')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&display=swap');
.elegant-title { font-family: 'Playfair Display', serif; }
</style>
@endpush

@section('content')
<!-- Elegant Template - Luxury & Sophisticated -->
<main class="bg-white">
    <!-- Hero Section - Elegant Style -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-b from-amber-50 to-white">
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'100\' height=\'100\' viewBox=\'0 0 100 100\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z\' fill=\'%23d97706\' fill-opacity=\'1\' fill-rule=\'evenodd\'/%3E%3C/svg%3E');"></div>
        </div>
        
        <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center py-20">
            <div class="inline-block mb-8">
                <div class="w-16 h-0.5 bg-amber-600 mx-auto mb-6"></div>
                <p class="text-sm font-semibold text-amber-800 uppercase tracking-[0.3em]">
                    {{ $settings['hero_badge_text'] ?? 'Exquisite Excellence' }}
                </p>
                <div class="w-16 h-0.5 bg-amber-600 mx-auto mt-6"></div>
            </div>
            
            <h1 class="elegant-title text-5xl md:text-7xl lg:text-8xl font-black text-gray-900 leading-[1.1] mb-8">
                {{ $settings['hero_title'] ?? 'Timeless Elegance Meets Modern Innovation' }}
            </h1>
            
            <p class="text-xl md:text-2xl text-gray-600 mb-12 leading-relaxed max-w-3xl mx-auto font-light">
                {{ $settings['hero_subtitle'] ?? 'Experience the perfect harmony of sophistication and functionality, crafted for those who appreciate the finer details.' }}
            </p>
            
            @if(isset($settings['hero_cta_text']) && $settings['hero_cta_text'])
            <a href="{{ $settings['hero_cta_link'] ?? '#' }}" 
               class="inline-block px-12 py-5 bg-gray-900 text-white font-semibold uppercase tracking-wider text-sm hover:bg-gray-800 transition-all duration-300 shadow-2xl">
                {{ $settings['hero_cta_text'] }}
            </a>
            @endif
            
            <!-- Scroll Indicator -->
            <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </div>
        </div>
    </section>

    <!-- Divider -->
    <div class="max-w-7xl mx-auto px-4">
        <div class="h-px bg-gradient-to-r from-transparent via-amber-300 to-transparent"></div>
    </div>

    @if(isset($latestPosts) && $latestPosts->count() > 0)
    <!-- Featured Content -->
    <section class="py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="w-16 h-0.5 bg-amber-600 mx-auto mb-6"></div>
                <h2 class="elegant-title text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Curated Stories
                </h2>
                <p class="text-xl text-gray-600 font-light">
                    Thoughtfully selected narratives for the discerning reader
                </p>
                <div class="w-16 h-0.5 bg-amber-600 mx-auto mt-6"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-16">
                @foreach($latestPosts->take(2) as $post)
                <article class="group">
                    <a href="{{ route('blog.show', $post->slug) }}" class="block">
                        <div class="relative h-96 overflow-hidden mb-6 bg-gray-100">
                            @if($post->featured_image)
                            <img src="{{ $post->featured_image }}" 
                                 alt="{{ $post->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                            @else
                            <div class="w-full h-full bg-gradient-to-br from-amber-100 to-amber-200"></div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        </div>
                        
                        @if($post->category)
                        <p class="text-xs font-semibold text-amber-700 uppercase tracking-[0.2em] mb-3">
                            {{ $post->category->name }}
                        </p>
                        @endif
                        
                        <h3 class="elegant-title text-3xl font-bold text-gray-900 mb-4 group-hover:text-amber-800 transition-colors leading-tight">
                            {{ $post->title }}
                        </h3>
                        <p class="text-gray-600 text-lg leading-relaxed mb-4 font-light">
                            {{ Str::limit($post->excerpt ?: strip_tags($post->content), 150) }}
                        </p>
                        
                        <div class="flex items-center text-sm text-gray-500">
                            <span class="font-medium">{{ $post->user->name }}</span>
                            <span class="mx-3">•</span>
                            <time>{{ $post->published_at->format('F d, Y') }}</time>
                        </div>
                    </a>
                </article>
                @endforeach
            </div>
            
            <!-- More Articles -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($latestPosts->skip(2)->take(3) as $post)
                <article class="group">
                    <a href="{{ route('blog.show', $post->slug) }}" class="block">
                        <div class="relative h-64 overflow-hidden mb-4 bg-gray-100">
                            @if($post->featured_image)
                            <img src="{{ $post->featured_image }}" 
                                 alt="{{ $post->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            @else
                            <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200"></div>
                            @endif
                        </div>
                        
                        @if($post->category)
                        <p class="text-xs font-semibold text-amber-700 uppercase tracking-[0.2em] mb-2">
                            {{ $post->category->name }}
                        </p>
                        @endif
                        
                        <h4 class="elegant-title text-xl font-bold text-gray-900 mb-2 group-hover:text-amber-800 transition-colors leading-tight">
                            {{ $post->title }}
                        </h4>
                        <time class="text-xs text-gray-500 uppercase tracking-wider">
                            {{ $post->published_at->format('F d, Y') }}
                        </time>
                    </a>
                </article>
                @endforeach
            </div>
            
            <div class="text-center mt-16">
                <a href="{{ route('blog.index') }}" 
                   class="inline-block px-10 py-4 border-2 border-gray-900 text-gray-900 font-semibold uppercase tracking-wider text-sm hover:bg-gray-900 hover:text-white transition-all duration-300">
                    Explore All Stories
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- Newsletter Section -->
    <section class="py-24 bg-gradient-to-b from-amber-50 to-white">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <div class="w-16 h-0.5 bg-amber-600 mx-auto mb-6"></div>
            <h2 class="elegant-title text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                Join Our Circle
            </h2>
            <p class="text-xl text-gray-600 mb-10 font-light leading-relaxed">
                Receive exclusive insights and carefully curated content delivered to your inbox.
            </p>
            <a href="{{ $settings['hero_button_url'] ?? '#' }}" 
               class="inline-block px-12 py-5 bg-gray-900 text-white font-semibold uppercase tracking-wider text-sm hover:bg-gray-800 transition-all duration-300">
                Subscribe Now
            </a>
            <div class="w-16 h-0.5 bg-amber-600 mx-auto mt-6"></div>
        </div>
    </section>
</main>
@endsection
