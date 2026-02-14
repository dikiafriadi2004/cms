@extends('frontend.layouts.frontend')

@section('title', ($settings['site_name'] ?? 'Konter Digital') . ' - ' . ($settings['site_description'] ?? 'Modern CMS'))
@section('description', $settings['meta_description'] ?? $settings['site_description'] ?? '')

@section('content')
<!-- Corporate Template - Professional & Trust-Building -->
<main class="bg-white">
    <!-- Hero Section - Corporate Style -->
    <section class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900 text-white overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full mb-6">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-semibold">{{ $settings['hero_badge_text'] ?? 'Trusted by 10,000+ Businesses' }}</span>
                </div>
                
                <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-6">
                    {{ $settings['hero_title'] ?? 'Enterprise Solutions for Modern Business' }}
                </h1>
                <p class="text-xl text-blue-100 mb-8 leading-relaxed">
                    {{ $settings['hero_subtitle'] ?? 'Empowering organizations with innovative technology and strategic insights to drive growth and success.' }}
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    @if(isset($settings['hero_cta_text']) && $settings['hero_cta_text'])
                    <a href="{{ $settings['hero_cta_link'] ?? '#' }}" 
                       class="inline-flex items-center justify-center px-8 py-4 bg-white text-blue-900 font-semibold rounded-lg hover:bg-blue-50 transition-colors shadow-xl">
                        {{ $settings['hero_cta_text'] }}
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    @endif
                    <a href="#about" 
                       class="inline-flex items-center justify-center px-8 py-4 bg-transparent text-white font-semibold rounded-lg border-2 border-white/30 hover:bg-white/10 transition-colors">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Wave Divider -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white"/>
            </svg>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl font-bold text-blue-900 mb-2">10K+</div>
                    <div class="text-gray-600 font-medium">Active Clients</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-blue-900 mb-2">98%</div>
                    <div class="text-gray-600 font-medium">Satisfaction Rate</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-blue-900 mb-2">24/7</div>
                    <div class="text-gray-600 font-medium">Support Available</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-blue-900 mb-2">15+</div>
                    <div class="text-gray-600 font-medium">Years Experience</div>
                </div>
            </div>
        </div>
    </section>

    @if(isset($latestPosts) && $latestPosts->count() > 0)
    <!-- Insights Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Latest Insights</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Stay informed with our expert analysis and industry perspectives
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($latestPosts->take(3) as $post)
                <article class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-shadow duration-300 group">
                    <div class="relative h-56 overflow-hidden bg-gray-200">
                        @if($post->featured_image)
                        <img src="{{ $post->featured_image }}" 
                             alt="{{ $post->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-500 to-blue-700"></div>
                        @endif
                    </div>
                    
                    <div class="p-6">
                        @if($post->category)
                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold uppercase tracking-wider rounded-full mb-3">
                            {{ $post->category->name }}
                        </span>
                        @endif
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-blue-900 transition-colors leading-tight">
                            <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                        </h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            {{ Str::limit($post->excerpt ?: strip_tags($post->content), 120) }}
                        </p>
                        
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $post->published_at->format('M d, Y') }}
                            </div>
                            <a href="{{ route('blog.show', $post->slug) }}" 
                               class="text-blue-600 font-semibold text-sm hover:text-blue-800 transition-colors">
                                Read More →
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('blog.index') }}" 
                   class="inline-flex items-center px-8 py-3 bg-blue-900 text-white font-semibold rounded-lg hover:bg-blue-800 transition-colors">
                    View All Insights
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- CTA Section -->
    <section class="py-20 bg-blue-900 text-white">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">
                Ready to Transform Your Business?
            </h2>
            <p class="text-xl text-blue-100 mb-10 leading-relaxed">
                Join thousands of successful organizations that trust us with their digital transformation.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ $settings['hero_button_url'] ?? '#' }}" 
                   class="inline-flex items-center justify-center px-8 py-4 bg-white text-blue-900 font-semibold rounded-lg hover:bg-blue-50 transition-colors">
                    Get Started Today
                </a>
                <a href="#contact" 
                   class="inline-flex items-center justify-center px-8 py-4 bg-transparent text-white font-semibold rounded-lg border-2 border-white/30 hover:bg-white/10 transition-colors">
                    Contact Sales
                </a>
            </div>
        </div>
    </section>
</main>
@endsection
