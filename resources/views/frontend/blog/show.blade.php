@extends('frontend.layouts.frontend')

@section('title', $post->title . ' - ' . ($settings['site_name'] ?? 'Konter Digital'))
@section('description', $post->excerpt ?: strip_tags(substr($post->content, 0, 160)))
@section('keywords', $post->tags->pluck('name')->implode(', '))
@section('canonical', route('blog.show', $post->slug))

@section('og_type', 'article')
@section('og_title', $post->title)
@section('og_description', $post->excerpt ?: strip_tags(substr($post->content, 0, 160)))
@section('og_image', $post->featured_image ?: (isset($settings['og_image']) ? storage_url($settings['og_image']) : storage_url(($settings['logo'] ?? 'default-og-image.jpg'))))

@section('twitter_title', $post->title)
@section('twitter_description', $post->excerpt ?: strip_tags(substr($post->content, 0, 160)))
@section('twitter_image', $post->featured_image ?: (isset($settings['og_image']) ? storage_url($settings['og_image']) : storage_url(($settings['logo'] ?? 'default-og-image.jpg'))))



@push('styles')
<style>
.prose h3 { 
    margin-top: 2.5rem; 
    margin-bottom: 1rem; 
    font-size: 1.5rem; 
    font-weight: 800; 
    color: #1e1b4b; 
}
.prose h2 {
    margin-top: 2.5rem;
    margin-bottom: 1rem;
    font-size: 1.875rem;
    font-weight: 800;
    color: #1e1b4b;
}
.prose h4 {
    margin-top: 2rem;
    margin-bottom: 0.75rem;
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e1b4b;
}
.prose p { 
    margin-bottom: 1.5rem; 
    line-height: 1.8; 
    color: #475569; 
}
.prose ul, .prose ol {
    margin-bottom: 1.5rem;
    padding-left: 1.5rem;
}
.prose li {
    margin-bottom: 0.5rem;
    color: #475569;
}
.prose a {
    color: #4f46e5;
    text-decoration: underline;
}
.prose a:hover {
    color: #4338ca;
}
.prose strong {
    font-weight: 700;
    color: #1e1b4b;
}
.prose blockquote {
    border-left: 4px solid #4f46e5;
    padding-left: 1.5rem;
    margin: 2rem 0;
    font-style: italic;
    color: #64748b;
}
.prose img {
    border-radius: 1rem;
    margin: 2rem 0;
}

/* Pre and Code Blocks */
.prose pre {
    background: #1e293b;
    color: #e2e8f0;
    padding: 1.5rem;
    border-radius: 1rem;
    overflow-x: auto;
    margin: 2rem 0;
    font-family: 'Courier New', Courier, monospace;
    font-size: 0.875rem;
    line-height: 1.7;
    border: 1px solid #334155;
}

.prose pre code {
    background: transparent;
    padding: 0;
    color: inherit;
    font-size: inherit;
}

.prose code {
    background: #f1f5f9;
    color: #e11d48;
    padding: 0.2rem 0.4rem;
    border-radius: 0.375rem;
    font-family: 'Courier New', Courier, monospace;
    font-size: 0.875em;
    font-weight: 600;
}

/* Quill Editor Specific Styles */
.prose .ql-syntax {
    background: #1e293b;
    color: #e2e8f0;
    padding: 1.5rem;
    border-radius: 1rem;
    overflow-x: auto;
    margin: 2rem 0;
    font-family: 'Courier New', Courier, monospace;
    font-size: 0.875rem;
    line-height: 1.7;
    border: 1px solid #334155;
    white-space: pre-wrap;
    word-wrap: break-word;
}

.prose .ql-align-justify {
    text-align: justify;
}

.prose .ql-align-center {
    text-align: center;
}

.prose .ql-align-right {
    text-align: right;
}

.prose .ql-align-left {
    text-align: left;
}

/* Quill Font Sizes */
.prose .ql-size-small {
    font-size: 0.75em;
}

.prose .ql-size-large {
    font-size: 1.5em;
}

.prose .ql-size-huge {
    font-size: 2.5em;
}

/* Quill Indent */
.prose .ql-indent-1 {
    padding-left: 3em;
}

.prose .ql-indent-2 {
    padding-left: 6em;
}

.prose .ql-indent-3 {
    padding-left: 9em;
}

.prose .ql-indent-4 {
    padding-left: 12em;
}

.prose .ql-indent-5 {
    padding-left: 15em;
}

.prose .ql-indent-6 {
    padding-left: 18em;
}

.prose .ql-indent-7 {
    padding-left: 21em;
}

.prose .ql-indent-8 {
    padding-left: 24em;
}

/* Quill Video */
.prose .ql-video {
    width: 100%;
    height: 400px;
    border-radius: 1rem;
    margin: 2rem 0;
}

/* Tables */
.prose table {
    width: 100%;
    border-collapse: collapse;
    margin: 2rem 0;
    font-size: 0.875rem;
}

.prose table th {
    background: #f8fafc;
    padding: 0.75rem 1rem;
    text-align: left;
    font-weight: 700;
    color: #1e1b4b;
    border: 1px solid #e2e8f0;
}

.prose table td {
    padding: 0.75rem 1rem;
    border: 1px solid #e2e8f0;
    color: #475569;
}

.prose table tr:hover {
    background: #f8fafc;
}

/* Horizontal Rule */
.prose hr {
    border: none;
    border-top: 2px solid #e2e8f0;
    margin: 3rem 0;
}
</style>
@endpush

@section('content')
<main class="pt-32 pb-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col lg:flex-row gap-12">
        <!-- Main Content -->
        <div class="lg:w-2/3">
            <!-- Breadcrumb -->
            <nav class="flex text-sm text-slate-400 mb-6 font-medium">
                <a href="{{ route('blog.index') }}" class="hover:text-brand-600 transition">Blog</a>
                <span class="mx-2">/</span>
                @if($post->category)
                <span class="text-slate-600">{{ $post->category->name }}</span>
                @else
                <span class="text-slate-600">Artikel</span>
                @endif
            </nav>

            <!-- Title -->
            <h1 class="text-3xl md:text-5xl font-extrabold text-slate-900 leading-tight mb-8">
                {{ $post->title }}
            </h1>

            <!-- Author & Meta -->
            <div class="flex items-center gap-4 mb-8">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&bg=4f46e5&color=fff" 
                     class="w-11 h-11 rounded-full border-2 border-brand-50 shadow-sm" 
                     alt="{{ $post->user->name }}">
                <div>
                    <p class="text-sm font-bold text-slate-900">{{ $post->user->name }}</p>
                    <p class="text-xs text-slate-400">
                        {{ $post->published_at->format('d M Y') }} • 
                        {{ ceil(str_word_count(strip_tags($post->content)) / 200) }} Menit Baca
                    </p>
                </div>
            </div>

            <!-- Ad: Content Top -->
            @if(isset($ads['content_top']) && $ads['content_top']->count() > 0)
                <div class="space-y-6">
                    @foreach($ads['content_top'] as $ad)
                        <div class="mb-8 rounded-2xl overflow-hidden border border-slate-100 bg-slate-50/50">
                            {!! $ad->render() !!}
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Featured Image -->
            @if($post->featured_image)
            <div class="relative rounded-[2.5rem] overflow-hidden shadow-2xl mb-12 border border-slate-100">
                <img src="{{ $post->featured_image }}" 
                     class="w-full h-auto object-cover" 
                     alt="{{ $post->title }}">
            </div>
            @endif

            <!-- Article Content -->
            <article class="prose prose-slate max-w-none mb-16">
                {!! App\Models\Ad::injectIntoContent($post->content, ['page' => 'blog_detail', 'post' => $post->id]) !!}
            </article>

            <!-- Ad: Content Bottom -->
            @if(isset($ads['content_bottom']) && $ads['content_bottom']->count() > 0)
                <div class="space-y-6">
                    @foreach($ads['content_bottom'] as $ad)
                        <div class="mb-8 rounded-2xl overflow-hidden border border-slate-100 bg-slate-50/50">
                            {!! $ad->render() !!}
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Tags & Share Section -->
            <div class="mt-16 pt-10 border-t border-slate-100">
                <!-- Tags -->
                @if($post->tags->count() > 0)
                <div class="flex flex-wrap items-center gap-2 mb-8">
                    <div class="flex items-center text-slate-400 mr-2">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <span class="text-xs font-bold uppercase tracking-wider">Topik:</span>
                    </div>
                    @foreach($post->tags as $tag)
                    <a href="{{ route('blog.tag', $tag->slug) }}" 
                       class="px-4 py-1.5 bg-slate-50 text-slate-600 text-xs font-bold rounded-full hover:bg-brand-600 hover:text-white transition-all">
                        {{ $tag->name }}
                    </a>
                    @endforeach
                </div>
                @endif

                <!-- Share Section -->
                <div class="bg-slate-50 border border-slate-100 p-8 rounded-[2.5rem] text-center md:text-left">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div>
                            <h4 class="text-slate-900 font-extrabold text-lg">Bagikan Artikel</h4>
                            <p class="text-slate-500 text-sm">Pilih platform favorit untuk membagikan wawasan ini.</p>
                        </div>
                        <div class="flex flex-wrap justify-center md:justify-end gap-3">
                            <!-- WhatsApp -->
                            <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . route('blog.show', $post->slug)) }}" 
                               target="_blank"
                               class="w-12 h-12 bg-white border border-slate-200 text-green-500 rounded-2xl flex items-center justify-center hover:bg-green-500 hover:text-white hover:shadow-lg hover:shadow-green-200 transition-all duration-300">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                            </a>

                            <!-- Facebook -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $post->slug)) }}" 
                               target="_blank"
                               class="w-12 h-12 bg-white border border-slate-200 text-blue-600 rounded-2xl flex items-center justify-center hover:bg-blue-600 hover:text-white hover:shadow-lg hover:shadow-blue-200 transition-all duration-300">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>

                            <!-- Instagram -->
                            <a href="#" 
                               class="w-12 h-12 bg-white border border-slate-200 text-pink-600 rounded-2xl flex items-center justify-center hover:bg-gradient-to-tr hover:from-orange-500 hover:via-pink-500 hover:to-purple-600 hover:text-white hover:shadow-lg transition-all duration-300">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12s.014 3.667.072 4.947c.2 4.358 2.618 6.78 6.98 6.981 1.281.058 1.689.072 4.948.072s3.667-.014 4.947-.072c4.358-.2 6.78-2.618 6.98-6.981.058-1.28.072-1.689.072-4.948s-.014-3.667-.072-4.947c-.2-4.358-2.618-6.78-6.98-6.98C15.667.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                                </svg>
                            </a>

                            <!-- Telegram -->
                            <a href="https://t.me/share/url?url={{ urlencode(route('blog.show', $post->slug)) }}&text={{ urlencode($post->title) }}" 
                               target="_blank"
                               class="w-12 h-12 bg-white border border-slate-200 text-sky-500 rounded-2xl flex items-center justify-center hover:bg-sky-500 hover:text-white hover:shadow-lg hover:shadow-sky-200 transition-all duration-300">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.562 8.161c-.18 1.897-.962 6.502-1.359 8.627-.168.9-.499 1.201-.82 1.23-.698.064-1.226-.462-1.901-.905-1.057-.695-1.653-1.13-2.678-1.805-1.185-.78-.417-1.207.258-1.908.177-.184 3.247-2.977 3.307-3.232.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.479.329-.912.489-1.301.481-.428-.008-1.252-.241-1.865-.44-.751-.244-1.348-.372-1.296-.786.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635.099-.002.321.023.465.14.12.098.153.23.167.323.014.093.023.233.013.361z"/>
                                </svg>
                            </a>

                            <!-- Twitter/X -->
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $post->slug)) }}&text={{ urlencode($post->title) }}" 
                               target="_blank"
                               class="w-12 h-12 bg-white border border-slate-200 text-slate-900 rounded-2xl flex items-center justify-center hover:bg-slate-900 hover:text-white hover:shadow-lg transition-all duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar - Popular Posts -->
        <aside class="lg:w-1/3">
            <div class="sticky top-28 space-y-10">
                <!-- Ad: Sidebar -->
                @if(isset($ads['sidebar']) && $ads['sidebar']->count() > 0)
                    <div class="space-y-6">
                        @foreach($ads['sidebar'] as $ad)
                            <div class="rounded-2xl overflow-hidden border border-slate-100 bg-slate-50/50">
                                {!! $ad->render() !!}
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="bg-white border border-slate-100 rounded-[2rem] p-8 shadow-sm">
                    <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <span class="w-8 h-1 bg-brand-600 rounded-full"></span>
                        Artikel Populer
                    </h3>
                    <div class="space-y-6">
                        @forelse($popularPosts as $popular)
                        <a href="{{ route('blog.show', $popular->slug) }}" class="flex gap-4 group">
                            <div class="w-20 h-20 rounded-2xl overflow-hidden flex-shrink-0 border border-slate-100 shadow-sm">
                                @if($popular->featured_image)
                                <img src="{{ $popular->featured_image }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition duration-500" 
                                     alt="{{ $popular->title }}">
                                @else
                                <div class="w-full h-full bg-gradient-to-br from-brand-400 to-indigo-500 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-bold text-slate-900 group-hover:text-brand-600 transition leading-snug line-clamp-2">
                                    {{ $popular->title }}
                                </h4>
                                <p class="text-[10px] text-slate-400 mt-2 font-bold uppercase tracking-wider">
                                    @if($popular->category)
                                        {{ $popular->category->name }}
                                    @else
                                        Artikel
                                    @endif
                                </p>
                            </div>
                        </a>
                        @empty
                        <p class="text-sm text-slate-500 text-center py-4">Belum ada artikel populer</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </aside>
    </div>
</main>

@push('scripts')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endpush
@endsection
