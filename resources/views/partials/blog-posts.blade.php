@forelse($posts as $post)
    <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
        @if($post->featured_image)
            <a href="{{ route('blog.show', $post->slug) }}">
                <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
            </a>
        @endif
        
        <div class="p-6">
            <div class="flex items-center gap-4 text-sm text-gray-600 mb-3">
                @if($post->category)
                    <a href="{{ route('blog.category', $post->category->slug) }}" class="text-blue-600 hover:text-blue-800">
                        {{ $post->category->name }}
                    </a>
                @endif
                <span>{{ $post->published_at->format('d M Y') }}</span>
                <span>{{ $post->reading_time }} min read</span>
            </div>
            
            <h2 class="text-2xl font-bold mb-3">
                <a href="{{ route('blog.show', $post->slug) }}" class="text-gray-900 hover:text-blue-600 transition-colors">
                    {{ $post->title }}
                </a>
            </h2>
            
            @if($post->excerpt)
                <p class="text-gray-600 mb-4">{{ $post->excerpt }}</p>
            @endif
            
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <img src="{{ $post->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) }}" 
                         alt="{{ $post->user->name }}" 
                         class="w-8 h-8 rounded-full">
                    <span class="text-sm text-gray-600">{{ $post->user->name }}</span>
                </div>
                
                <a href="{{ route('blog.show', $post->slug) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    Read More →
                </a>
            </div>
        </div>
    </article>
@empty
    <div class="col-span-full text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No posts found</h3>
        <p class="mt-1 text-sm text-gray-500">Try adjusting your filters or search query.</p>
    </div>
@endforelse
