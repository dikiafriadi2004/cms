@extends('frontend.layouts.frontend')

@section('title', 'Blog - ' . ($settings['site_name'] ?? 'Konter Digital'))
@section('description', 'Temukan tips eksklusif dan panduan sukses untuk mengembangkan bisnis server pulsa Anda.')

@section('content')
<!-- Minimal Template - Blog Index -->
<main class="min-h-screen bg-white">
    <!-- Header -->
    <section class="pt-32 pb-12 px-4 border-b border-gray-200">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl font-bold text-gray-900 mb-4">Blog</h1>
            <p class="text-xl text-gray-600">Thoughts, stories and ideas.</p>
        </div>
    </section>

    <!-- Posts List -->
    <section class="py-16 px-4">
        <div class="max-w-4xl mx-auto space-y-16">
            <!-- Content Top Ads -->
            @if(isset($ads['content_top']) && $ads['content_top']->count() > 0)
                <div class="border-t border-b border-gray-200 py-8">
                    @foreach($ads['content_top'] as $ad)
                        <div class="mb-4">
                            {!! $ad->render() !!}
                        </div>
                    @endforeach
                </div>
            @endif

            @forelse($posts as $index => $post)
            <article>
                <a href="{{ route('blog.show', $post->slug) }}" class="block group">
                    <time class="text-sm text-gray-500 uppercase tracking-wider">
                        {{ $post->published_at->format('F d, Y') }}
                    </time>
                    <h2 class="text-3xl font-bold text-gray-900 mt-2 mb-3 group-hover:text-gray-600 transition-colors">
                        {{ $post->title }}
                    </h2>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 200) }}
                    </p>
                    <span class="inline-block mt-4 text-sm font-medium text-gray-900 group-hover:underline">
                        Read more →
                    </span>
                </a>
            </article>

            <!-- Between Posts Ads (after every 3rd post) -->
            @if(($index + 1) % 3 == 0 && isset($ads['between_posts']) && $ads['between_posts']->count() > 0)
                <div class="border-t border-b border-gray-200 py-8">
                    @foreach($ads['between_posts'] as $ad)
                        <div class="mb-4">
                            {!! $ad->render() !!}
                        </div>
                    @endforeach
                </div>
            @endif
            @empty
            <div class="text-center py-12">
                <p class="text-gray-500">No articles yet.</p>
            </div>
            @endforelse

            <!-- Pagination -->
            @if($posts->hasPages())
            <div class="pt-8 border-t border-gray-200">
                {{ $posts->links() }}
            </div>
            @endif
        </div>
    </section>
</main>
@endsection
