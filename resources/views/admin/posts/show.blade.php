@extends('layouts.admin')

@section('title', 'View Post')
@section('page-title', 'Post Preview')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Top Navigation Bar -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-10">
        <div class="mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.posts.index') }}" class="text-gray-600 hover:text-gray-900 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                    <div class="h-6 w-px bg-gray-300"></div>
                    <span class="text-sm font-medium text-gray-900">Post Preview</span>
                </div>
                
                <div class="flex items-center space-x-3">
                    @if($post->status === 'published')
                    <a href="{{ route('blog.show', $post->slug) }}" target="_blank" 
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        View Live
                    </a>
                    @endif
                    
                    <a href="{{ route('admin.posts.edit', $post) }}" 
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </a>
                    
                    <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return handleDelete(event, 'Delete Post', 'Are you sure you want to delete this post? This action cannot be undone.')" class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-700 bg-white border border-red-300 rounded-lg hover:bg-red-50 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="mx-auto px-6 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Article Content -->
            <div class="lg:col-span-8">
                <article class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <!-- Article Header -->
                    <div class="px-8 pt-8 pb-6">
                        <!-- Meta Tags -->
                        <div class="flex flex-wrap items-center gap-2 mb-4">
                            @if($post->category)
                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold text-indigo-700 bg-indigo-50 rounded-full">
                                {{ $post->category->name }}
                            </span>
                            @endif
                            
                            <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium rounded-full {{ $post->status === 'published' ? 'bg-green-50 text-green-700' : ($post->status === 'scheduled' ? 'bg-blue-50 text-blue-700' : 'bg-yellow-50 text-yellow-700') }}">
                                {{ ucfirst($post->status) }}
                            </span>
                            
                            @if($post->tags->count() > 0)
                                @foreach($post->tags->take(2) as $tag)
                                <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium text-gray-600 bg-gray-100 rounded-full">
                                    {{ $tag->name }}
                                </span>
                                @endforeach
                            @endif
                        </div>
                        
                        <!-- Title -->
                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 leading-tight mb-4">
                            {{ $post->title }}
                        </h1>
                        
                        <!-- Author & Date -->
                        <div class="flex items-center text-sm text-gray-600">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm">
                                    {{ strtoupper(substr($post->user->name, 0, 2)) }}
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium text-gray-900">{{ $post->user->name }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }} · {{ $post->reading_time ?? 0 }} min read
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    @if($post->featured_image)
                    <div class="px-8 pb-8">
                        <div class="relative rounded-xl overflow-hidden bg-gray-100">
                            <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-auto object-cover" style="max-height: 500px;">
                        </div>
                    </div>
                    @endif

                    <!-- Article Body -->
                    <div class="px-8 pb-8">
                        <div class="prose prose-lg max-w-none">
                            {!! $post->content !!}
                        </div>
                    </div>

                    <!-- Article Footer -->
                    <div class="px-8 py-4 bg-gray-50 border-t border-gray-100">
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <span>Published {{ $post->published_at ? $post->published_at->format('M d, Y \a\t H:i') : 'Not published' }}</span>
                            <span>Updated {{ $post->updated_at->format('M d, Y \a\t H:i') }}</span>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-4 space-y-6">
                <!-- SEO Information -->
                @if($post->meta_title || $post->meta_description || $post->focus_keyword)
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">SEO Information</h3>
                    <div class="space-y-4">
                        @if($post->focus_keyword)
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Focus Keyword</label>
                            <p class="text-sm font-semibold text-indigo-600">{{ $post->focus_keyword }}</p>
                        </div>
                        @endif

                        @if($post->meta_title)
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Meta Title</label>
                            <p class="text-sm text-gray-900 mb-2">{{ $post->meta_title }}</p>
                            <div class="flex items-center gap-2">
                                <div class="flex-1 bg-gray-200 rounded-full h-1.5">
                                    <div class="h-1.5 rounded-full {{ strlen($post->meta_title) <= 60 ? 'bg-green-500' : (strlen($post->meta_title) <= 70 ? 'bg-yellow-500' : 'bg-red-500') }}" style="width: {{ min(100, (strlen($post->meta_title) / 70) * 100) }}%"></div>
                                </div>
                                <span class="text-xs text-gray-500 whitespace-nowrap">{{ strlen($post->meta_title) }}/60</span>
                            </div>
                        </div>
                        @endif

                        @if($post->meta_description)
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Meta Description</label>
                            <p class="text-sm text-gray-900 mb-2">{{ $post->meta_description }}</p>
                            <div class="flex items-center gap-2">
                                <div class="flex-1 bg-gray-200 rounded-full h-1.5">
                                    <div class="h-1.5 rounded-full {{ strlen($post->meta_description) <= 160 ? 'bg-green-500' : (strlen($post->meta_description) <= 180 ? 'bg-yellow-500' : 'bg-red-500') }}" style="width: {{ min(100, (strlen($post->meta_description) / 180) * 100) }}%"></div>
                                </div>
                                <span class="text-xs text-gray-500 whitespace-nowrap">{{ strlen($post->meta_description) }}/160</span>
                            </div>
                        </div>
                        @endif

                        @if($post->meta_keywords)
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase mb-2">Keywords</label>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach(explode(',', $post->meta_keywords) as $keyword)
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded">
                                    {{ trim($keyword) }}
                                </span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Post Information -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Post Information</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase">Status</dt>
                            <dd class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium rounded-full {{ $post->status === 'published' ? 'bg-green-50 text-green-700' : ($post->status === 'scheduled' ? 'bg-blue-50 text-blue-700' : 'bg-yellow-50 text-yellow-700') }}">
                                    {{ ucfirst($post->status) }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase">Author</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-medium">{{ $post->user->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase">Views</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ number_format($post->views_count ?? 0) }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase">Reading Time</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $post->reading_time ?? 0 }} minutes</dd>
                        </div>
                        @if($post->seo_score)
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase">SEO Score</dt>
                            <dd class="mt-1">
                                <span class="text-sm font-semibold {{ ($post->seo_score ?? 0) >= 80 ? 'text-green-600' : (($post->seo_score ?? 0) >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ $post->seo_score }}%
                                </span>
                            </dd>
                        </div>
                        @endif
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase">Created</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $post->created_at->format('M d, Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase">Last Modified</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $post->updated_at->format('M d, Y H:i') }}</dd>
                        </div>
                        @if($post->published_at)
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase">Published</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $post->published_at->format('M d, Y H:i') }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .prose {
        color: #374151;
        font-size: 1.125rem;
        line-height: 1.75;
    }
    
    .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
        color: #111827;
        font-weight: 700;
        margin-top: 2em;
        margin-bottom: 0.75em;
        line-height: 1.3;
    }
    
    .prose h1 { font-size: 2.25em; }
    .prose h2 { font-size: 1.875em; padding-bottom: 0.3em; border-bottom: 1px solid #e5e7eb; margin-top: 1.5em; }
    .prose h3 { font-size: 1.5em; }
    .prose h4 { font-size: 1.25em; }
    
    .prose p {
        margin-bottom: 1.25em;
        line-height: 1.75;
    }
    
    .prose a {
        color: #4f46e5;
        text-decoration: none;
        font-weight: 500;
        border-bottom: 1px solid transparent;
        transition: border-color 0.2s;
    }
    
    .prose a:hover {
        border-bottom-color: #4f46e5;
    }
    
    .prose strong {
        color: #111827;
        font-weight: 600;
    }
    
    .prose em {
        font-style: italic;
    }
    
    .prose ul, .prose ol {
        margin: 1.5em 0;
        padding-left: 1.625em;
    }
    
    .prose li {
        margin: 0.5em 0;
        line-height: 1.75;
    }
    
    .prose blockquote {
        border-left: 4px solid #e5e7eb;
        padding-left: 1.5em;
        margin: 1.5em 0;
        font-style: italic;
        color: #6b7280;
    }
    
    .prose code {
        background: #f3f4f6;
        color: #dc2626;
        padding: 0.2em 0.4em;
        border-radius: 0.25rem;
        font-size: 0.875em;
        font-family: 'Courier New', monospace;
        font-weight: 500;
    }
    
    .prose pre {
        background: #1f2937;
        color: #f9fafb;
        padding: 1.5em;
        border-radius: 0.5rem;
        overflow-x: auto;
        margin: 1.5em 0;
    }
    
    .prose pre code {
        background: transparent;
        color: inherit;
        padding: 0;
        font-weight: 400;
    }
    
    .prose img {
        border-radius: 0.5rem;
        margin: 2em 0;
        max-width: 100%;
        height: auto;
    }
    
    .prose table {
        width: 100%;
        border-collapse: collapse;
        margin: 1.5em 0;
        font-size: 0.875em;
    }
    
    .prose th {
        background: #f9fafb;
        color: #111827;
        font-weight: 600;
        padding: 0.75em 1em;
        text-align: left;
        border: 1px solid #e5e7eb;
    }
    
    .prose td {
        padding: 0.75em 1em;
        border: 1px solid #e5e7eb;
    }
    
    .prose hr {
        border: none;
        border-top: 1px solid #e5e7eb;
        margin: 2.5em 0;
    }
</style>
@endpush
