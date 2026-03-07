@forelse($posts as $index => $post)
<article class="group bg-white rounded-[2.5rem] overflow-hidden shadow-sm border border-slate-100 hover:shadow-2xl transition-all duration-500 flex flex-col">
    <!-- Featured Image -->
    <div class="relative overflow-hidden h-64">
        @if($post->featured_image)
            <img src="{{ $post->featured_image }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700" alt="{{ $post->title }}">
        @else
            <div class="w-full h-full bg-gradient-to-br from-brand-400 to-indigo-500 flex items-center justify-center">
                <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        @endif
    </div>

    <!-- Content -->
    <div class="p-8 flex flex-col flex-1">
        <!-- Meta -->
        <div class="flex items-center gap-3 text-xs font-bold text-brand-600 mb-4 uppercase tracking-wider">
            @if($post->category)
                <span>{{ $post->category->name }}</span>
                <span class="text-slate-300">•</span>
            @endif
            <span class="text-slate-400 font-medium lowercase">{{ $post->published_at->format('d M Y') }}</span>
        </div>

        <!-- Title -->
        <h2 class="text-xl font-extrabold text-slate-900 group-hover:text-brand-600 transition-colors mb-4 leading-tight">
            <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
        </h2>

        <!-- Excerpt -->
        <p class="text-slate-500 text-sm leading-relaxed mb-6 flex-1 line-clamp-3">
            {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 150) }}
        </p>

        <!-- Read More -->
        <a href="{{ route('blog.show', $post->slug) }}" class="text-brand-600 font-bold text-sm flex items-center gap-2 group/link">
            Baca Selengkapnya
            <svg class="w-4 h-4 group-hover/link:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
    </div>
</article>
@empty
<!-- Empty State -->
<div class="col-span-full text-center py-20">
    <svg class="w-24 h-24 mx-auto text-slate-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
    </svg>
    <h3 class="text-2xl font-bold text-slate-900 mb-2">Tidak Ada Artikel</h3>
    <p class="text-slate-500">Tidak ada artikel yang sesuai dengan filter Anda.</p>
</div>
@endforelse
