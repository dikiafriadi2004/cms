@extends('frontend.layouts.frontend')

@section('title', ($settings['site_name'] ?? 'Konter Digital') . ' - ' . ($settings['site_description'] ?? 'Modern CMS'))
@section('description', $settings['meta_description'] ?? $settings['site_description'] ?? '')

@push('styles')
<style>
.magazine-grid { display: grid; grid-template-columns: repeat(12, 1fr); gap: 1.5rem; }
.magazine-featured { grid-column: span 8; }
.magazine-sidebar { grid-column: span 4; }
@media (max-width: 768px) {
    .magazine-featured, .magazine-sidebar { grid-column: span 12; }
}
</style>
@endpush

@section('content')
<!-- Magazine Template - Bold & Image-Heavy -->
<main class="bg-white">
    <!-- Hero Section - Magazine Style -->
    <section class="relative h-[70vh] min-h-[600px] overflow-hidden">
        @if(isset($settings['hero_image']) && $settings['hero_image'])
        <img src="{{ storage_url($settings['hero_image']) }}" 
             alt="Hero" 
             class="absolute inset-0 w-full h-full object-cover">
        @else
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900"></div>
        @endif
        
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
        
        <div class="relative h-full flex items-end">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 w-full">
                <div class="max-w-3xl">
                    <div class="inline-block px-4 py-2 bg-red-600 text-white text-xs font-bold uppercase tracking-wider mb-4">
                        {{ $settings['hero_badge_text'] ?? 'Featured' }}
                    </div>
                    <h1 class="text-5xl md:text-7xl font-black text-white leading-tight mb-6">
                        {{ $settings['hero_title'] ?? 'Bold Stories, Big Impact' }}
                    </h1>
                    <p class="text-xl text-gray-200 mb-8 leading-relaxed">
                        {{ $settings['hero_subtitle'] ?? 'Discover the latest news, trends, and insights that matter.' }}
                    </p>
                    @if(isset($settings['hero_cta_text']) && $settings['hero_cta_text'])
                    <a href="{{ $settings['hero_cta_link'] ?? '#' }}" 
                       class="inline-block px-8 py-4 bg-red-600 text-white font-bold uppercase tracking-wider hover:bg-red-700 transition-colors">
                        {{ $settings['hero_cta_text'] }}
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @if(isset($latestPosts) && $latestPosts->count() > 0)
    <!-- Featured Posts - Magazine Grid -->
    <section class="py-16 px-4 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-4xl font-black text-gray-900 uppercase tracking-tight">Latest Stories</h2>
                <a href="{{ route('blog.index') }}" class="text-sm font-bold text-red-600 uppercase tracking-wider hover:text-red-700">
                    View All →
                </a>
            </div>
            
            <div class="magazine-grid">
                <!-- Main Featured Post -->
                @if($latestPosts->first())
                @php $featured = $latestPosts->first(); @endphp
                <article class="magazine-featured group">
                    <a href="{{ route('blog.show', $featured->slug) }}" class="block">
                        <div class="relative h-[500px] overflow-hidden bg-gray-900 mb-6">
                            @if($featured->featured_image)
                            <img src="{{ $featured->featured_image }}" 
                                 alt="{{ $featured->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            @else
                            <div class="w-full h-full bg-gradient-to-br from-red-600 to-orange-600"></div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            
                            @if($featured->category)
                            <div class="absolute top-6 left-6">
                                <span class="px-4 py-2 bg-red-600 text-white text-xs font-bold uppercase tracking-wider">
                                    {{ $featured->category->name }}
                                </span>
                            </div>
                            @endif
                        </div>
                        
                        <h3 class="text-3xl font-black text-gray-900 mb-3 group-hover:text-red-600 transition-colors leading-tight">
                            {{ $featured->title }}
                        </h3>
                        <p class="text-gray-600 text-lg mb-4 leading-relaxed">
                            {{ Str::limit($featured->excerpt ?: strip_tags($featured->content), 150) }}
                        </p>
                        <div class="flex items-center text-sm text-gray-500">
                            <span class="font-bold">{{ $featured->user->name }}</span>
                            <span class="mx-2">•</span>
                            <time>{{ $featured->published_at->format('M d, Y') }}</time>
                        </div>
                    </a>
                </article>
                
                <!-- Sidebar Posts -->
                <div class="magazine-sidebar space-y-6">
                    @foreach($latestPosts->skip(1)->take(3) as $post)
                    <article class="group">
                        <a href="{{ route('blog.show', $post->slug) }}" class="block">
                            <div class="relative h-48 overflow-hidden bg-gray-900 mb-4">
                                @if($post->featured_image)
                                <img src="{{ $post->featured_image }}" 
                                     alt="{{ $post->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                @else
                                <div class="w-full h-full bg-gradient-to-br from-gray-700 to-gray-900"></div>
                                @endif
                            </div>
                            
                            @if($post->category)
                            <span class="inline-block px-3 py-1 bg-gray-900 text-white text-xs font-bold uppercase tracking-wider mb-2">
                                {{ $post->category->name }}
                            </span>
                            @endif
                            
                            <h4 class="text-xl font-black text-gray-900 mb-2 group-hover:text-red-600 transition-colors leading-tight">
                                {{ $post->title }}
                            </h4>
                            <time class="text-xs text-gray-500 font-bold uppercase tracking-wider">
                                {{ $post->published_at->format('M d, Y') }}
                            </time>
                        </a>
                    </article>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- More Posts Grid -->
    <section class="py-16 px-4">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-black text-gray-900 uppercase tracking-tight mb-8">More Stories</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($latestPosts->skip(4) as $post)
                <article class="group">
                    <a href="{{ route('blog.show', $post->slug) }}" class="block">
                        <div class="relative h-56 overflow-hidden bg-gray-900 mb-4">
                            @if($post->featured_image)
                            <img src="{{ $post->featured_image }}" 
                                 alt="{{ $post->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            @else
                            <div class="w-full h-full bg-gradient-to-br from-gray-600 to-gray-800"></div>
                            @endif
                        </div>
                        
                        @if($post->category)
                        <span class="inline-block px-3 py-1 bg-gray-900 text-white text-xs font-bold uppercase tracking-wider mb-3">
                            {{ $post->category->name }}
                        </span>
                        @endif
                        
                        <h3 class="text-xl font-black text-gray-900 mb-2 group-hover:text-red-600 transition-colors leading-tight">
                            {{ $post->title }}
                        </h3>
                        <p class="text-gray-600 text-sm mb-3">
                            {{ Str::limit($post->excerpt ?: strip_tags($post->content), 100) }}
                        </p>
                        <time class="text-xs text-gray-500 font-bold uppercase tracking-wider">
                            {{ $post->published_at->format('M d, Y') }}
                        </time>
                    </a>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- CTA Section -->
    <section class="py-20 bg-gray-900 text-white">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-4xl md:text-5xl font-black mb-6 uppercase tracking-tight">
                Stay Updated
            </h2>
            <p class="text-xl text-gray-300 mb-10">
                Get the latest stories delivered straight to your inbox.
            </p>
            <a href="{{ $settings['hero_button_url'] ?? '#' }}" 
               class="inline-block px-10 py-4 bg-red-600 text-white font-bold uppercase tracking-wider hover:bg-red-700 transition-colors">
                Subscribe Now
            </a>
        </div>
    </section>
</main>
@endsection
