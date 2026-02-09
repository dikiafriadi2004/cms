@extends('layouts.admin')

@section('title', 'Create Post')
@section('page-title', 'Create New Post')

@section('content')
<form method="POST" action="{{ route('admin.posts.store') }}" id="post-form" class="space-y-6">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content - 2 columns -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Post Content Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                    <h3 class="text-lg font-semibold text-gray-900">Post Content</h3>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" id="title" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('title') border-red-500 @enderror" 
                            value="{{ old('title') }}"
                            placeholder="Enter an engaging post title...">
                        @error('title')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                            Slug
                        </label>
                        <div class="relative">
                            <input type="text" name="slug" id="slug"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('slug') border-red-500 @enderror" 
                                value="{{ old('slug') }}"
                                placeholder="auto-generated-from-title">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Leave empty to auto-generate from title</p>
                        @error('slug')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Excerpt -->
                    <div>
                        <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
                            Excerpt
                        </label>
                        <textarea name="excerpt" id="excerpt" rows="3" maxlength="160"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none @error('excerpt') border-red-500 @enderror"
                            placeholder="Brief description of your post...">{{ old('excerpt') }}</textarea>
                        <div class="mt-1 flex items-center justify-between">
                            <p class="text-xs text-gray-500">Optimal: 150-160 characters for SEO</p>
                            <span class="text-xs font-medium" id="excerpt-count-display">
                                <span id="excerpt-count">0</span>/160
                            </span>
                        </div>
                        @error('excerpt')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                            Content <span class="text-red-500">*</span>
                        </label>
                        <div id="content" class="bg-white border border-gray-300 rounded-lg"></div>
                        <textarea name="content" style="display:none;">{{ old('content') }}</textarea>
                        @error('content')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- SEO Settings Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50 flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900">SEO Optimization</h3>
                    </div>
                    <div class="flex items-center">
                        <span class="text-sm text-gray-600 mr-2">Score:</span>
                        <div class="flex items-center">
                            <span id="seo-score" class="text-2xl font-bold text-gray-400">0%</span>
                        </div>
                    </div>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Focus Keyword -->
                    <div>
                        <label for="focus_keyword" class="block text-sm font-medium text-gray-700 mb-2">
                            Focus Keyword
                        </label>
                        <input type="text" name="focus_keyword" id="focus_keyword"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                            value="{{ old('focus_keyword') }}"
                            placeholder="e.g., web development">
                        <p class="mt-1 text-xs text-gray-500">Main keyword you want to rank for</p>
                    </div>

                    <!-- Meta Title -->
                    <div>
                        <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-2">
                            Meta Title
                        </label>
                        <input type="text" name="meta_title" id="meta_title" maxlength="60"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                            value="{{ old('meta_title') }}"
                            placeholder="SEO-friendly title for search engines">
                        <div class="mt-1 flex items-center justify-between">
                            <p class="text-xs text-gray-500">Optimal: 50-60 characters</p>
                            <span class="text-xs font-medium" id="meta-title-count-display">
                                <span id="meta-title-count">0</span>/60
                            </span>
                        </div>
                    </div>

                    <!-- Meta Description -->
                    <div>
                        <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">
                            Meta Description
                        </label>
                        <textarea name="meta_description" id="meta_description" rows="3" maxlength="160"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none"
                            placeholder="Compelling description for search results...">{{ old('meta_description') }}</textarea>
                        <div class="mt-1 flex items-center justify-between">
                            <p class="text-xs text-gray-500">Optimal: 120-160 characters</p>
                            <span class="text-xs font-medium" id="meta-desc-count-display">
                                <span id="meta-desc-count">0</span>/160
                            </span>
                        </div>
                    </div>

                    <!-- Meta Keywords -->
                    <div>
                        <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-2">
                            Meta Keywords
                        </label>
                        <input type="text" name="meta_keywords" id="meta_keywords"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                            value="{{ old('meta_keywords') }}"
                            placeholder="keyword1, keyword2, keyword3">
                        <p class="mt-1 text-xs text-gray-500">Comma-separated keywords</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar - 1 column -->
        <div class="space-y-6">
            <!-- Publish Settings -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-pink-50">
                    <h3 class="text-lg font-semibold text-gray-900">Publish Settings</h3>
                </div>
                <div class="p-6 space-y-4">
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" id="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>📝 Draft</option>
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>✅ Published</option>
                            <option value="scheduled" {{ old('status') === 'scheduled' ? 'selected' : '' }}>⏰ Scheduled</option>
                        </select>
                    </div>

                    <!-- Published At -->
                    <div id="published-at-group" style="display: none;">
                        <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">Publish Date</label>
                        <input type="datetime-local" name="published_at" id="published_at" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                            value="{{ old('published_at') }}">
                    </div>

                    <!-- Actions -->
                    <div class="pt-4 space-y-3">
                        <button type="submit" class="w-full flex items-center justify-center px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Create Post
                        </button>
                        <a href="{{ route('admin.posts.index') }}" class="w-full flex items-center justify-center px-4 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Posts
                        </a>
                    </div>
                </div>
            </div>

            <!-- Featured Image -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Featured Image</h3>
                </div>
                <div class="p-6">
                    <div id="featured-image-preview" class="mb-4 hidden">
                        <div class="relative group">
                            <img id="featured-image-img" src="" alt="Featured Image" class="w-full h-48 object-cover rounded-lg">
                            <button type="button" onclick="removeFeaturedImage()" 
                                class="absolute top-2 right-2 p-2 bg-red-500 text-white rounded-lg opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <button type="button" onclick="selectFeaturedImage()" 
                        class="w-full flex items-center justify-center px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all text-gray-600 hover:text-blue-600">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Select Featured Image
                    </button>
                    <input type="hidden" name="featured_image" id="featured_image" value="{{ old('featured_image') }}">
                </div>
            </div>

            <!-- Category -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Category</h3>
                </div>
                <div class="p-6">
                    <select name="category_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Tags -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Tags</h3>
                </div>
                <div class="p-6">
                    <select name="tags[]" id="tags" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" multiple>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-2 text-xs text-gray-500">Hold Ctrl/Cmd to select multiple tags</p>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .ql-container {
        min-height: 400px;
        font-size: 16px;
    }
    .ql-editor {
        min-height: 400px;
    }
    /* Image resize styles */
    .ql-editor img {
        cursor: pointer;
        max-width: 100%;
        height: auto;
    }
    .ql-editor img.ql-image-small {
        max-width: 300px;
    }
    .ql-editor img.ql-image-medium {
        max-width: 600px;
    }
    .ql-editor img.ql-image-large {
        max-width: 100%;
    }
    /* Image resize handles */
    .image-resizer {
        position: absolute;
        border: 2px dashed #4299e1;
        box-sizing: border-box;
        display: none;
    }
    .image-resizer.active {
        display: block;
    }
    .image-resizer .handle {
        position: absolute;
        width: 12px;
        height: 12px;
        background: #4299e1;
        border: 2px solid white;
        border-radius: 50%;
        cursor: nwse-resize;
    }
    .image-resizer .handle-nw { top: -6px; left: -6px; cursor: nw-resize; }
    .image-resizer .handle-ne { top: -6px; right: -6px; cursor: ne-resize; }
    .image-resizer .handle-sw { bottom: -6px; left: -6px; cursor: sw-resize; }
    .image-resizer .handle-se { bottom: -6px; right: -6px; cursor: se-resize; }
    .image-toolbar {
        position: absolute;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 4px;
        display: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        z-index: 1000;
    }
    .image-toolbar.active {
        display: flex;
        gap: 4px;
    }
    .image-toolbar button {
        padding: 6px 12px;
        border: none;
        background: #f7fafc;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
        transition: all 0.2s;
    }
    .image-toolbar button:hover {
        background: #4299e1;
        color: white;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('js/quill-image-resize.js') }}"></script>

<script>
// Initialize Quill Editor
var quill = new Quill('#content', {
    theme: 'snow',
    modules: {
        toolbar: {
            container: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                [{ 'font': [] }],
                [{ 'size': ['small', false, 'large', 'huge'] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'script': 'sub'}, { 'script': 'super' }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'align': [] }],
                ['blockquote', 'code-block'],
                ['link', 'image', 'video'],
                ['clean']
            ],
            handlers: {
                image: imageHandler
            }
        }
    }
});

// Custom image handler to open media browser
function imageHandler() {
    const width = 1000;
    const height = 700;
    const left = (screen.width - width) / 2;
    const top = (screen.height - height) / 2;
    
    window.open(
        '{{ route("admin.media.browse") }}?type=image&mode=editor',
        'MediaBrowser',
        `width=${width},height=${height},left=${left},top=${top},resizable=yes,scrollbars=yes`
    );
}

// Function to insert media from browser popup
window.insertMediaToEditor = function(url, name) {
    const range = quill.getSelection(true) || { index: 0 };
    quill.insertEmbed(range.index, 'image', url);
    quill.setSelection(range.index + 1);
};

// Sync Quill content to textarea on form submit
document.getElementById('post-form').addEventListener('submit', function() {
    document.querySelector('textarea[name="content"]').value = quill.root.innerHTML;
});

// Initialize image resize functionality
if (typeof QuillImageResize !== 'undefined') {
    QuillImageResize.init(quill);
}

// Initialize Select2 for tags with create new tag feature
$('#tags').select2({
    placeholder: 'Select tags or type to create new',
    allowClear: true,
    width: '100%',
    tags: true,
    tokenSeparators: [','],
    createTag: function (params) {
        var term = $.trim(params.term);
        
        if (term === '') {
            return null;
        }
        
        return {
            id: 'new:' + term,
            text: term,
            newTag: true
        }
    },
    templateResult: function(data) {
        if (data.newTag) {
            return $('<span><i class="fas fa-plus-circle"></i> Create: <strong>' + data.text + '</strong></span>');
        }
        return data.text;
    }
});

// Auto-generate slug from title
$('#title').on('input', function() {
    const title = $(this).val();
    const slug = title.toLowerCase()
        .replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim('-');
    $('#slug').val(slug);
    updateSEOScore();
});

// Show/hide published date based on status
$('#status').on('change', function() {
    if ($(this).val() === 'scheduled') {
        $('#published-at-group').show();
    } else {
        $('#published-at-group').hide();
    }
});

// Character counters
$('#meta_title').on('input', function() {
    const count = $(this).val().length;
    $('#meta-title-count').text(count);
    const display = $('#meta-title-count-display');
    if (count >= 50 && count <= 60) {
        display.removeClass('text-red-600 text-yellow-600').addClass('text-green-600');
    } else if (count > 60) {
        display.removeClass('text-green-600 text-yellow-600').addClass('text-red-600');
    } else {
        display.removeClass('text-green-600 text-red-600').addClass('text-yellow-600');
    }
    updateSEOScore();
});

$('#meta_description').on('input', function() {
    const count = $(this).val().length;
    $('#meta-desc-count').text(count);
    const display = $('#meta-desc-count-display');
    if (count >= 120 && count <= 160) {
        display.removeClass('text-red-600 text-yellow-600').addClass('text-green-600');
    } else if (count > 160) {
        display.removeClass('text-green-600 text-yellow-600').addClass('text-red-600');
    } else {
        display.removeClass('text-green-600 text-red-600').addClass('text-yellow-600');
    }
    updateSEOScore();
});

// Excerpt character counter
$('#excerpt').on('input', function() {
    const count = $(this).val().length;
    $('#excerpt-count').text(count);
    const display = $('#excerpt-count-display');
    if (count >= 150 && count <= 160) {
        display.removeClass('text-red-600 text-yellow-600').addClass('text-green-600');
    } else if (count > 160) {
        display.removeClass('text-green-600 text-yellow-600').addClass('text-red-600');
    } else if (count >= 100) {
        display.removeClass('text-green-600 text-red-600').addClass('text-yellow-600');
    } else {
        display.removeClass('text-green-600 text-yellow-600 text-red-600').addClass('text-gray-600');
    }
    updateSEOScore();
});

// SEO Score calculation
function updateSEOScore() {
    let score = 0;
    
    // Title optimization (20 points)
    const title = $('#title').val();
    if (title.length >= 30 && title.length <= 60) {
        score += 20;
    } else if (title.length >= 20) {
        score += 10;
    }
    
    // Meta description (20 points)
    const metaDesc = $('#meta_description').val();
    if (metaDesc.length >= 120 && metaDesc.length <= 160) {
        score += 20;
    } else if (metaDesc.length >= 100) {
        score += 10;
    }
    
    // Focus keyword in title (15 points)
    const focusKeyword = $('#focus_keyword').val();
    if (focusKeyword && title.toLowerCase().includes(focusKeyword.toLowerCase())) {
        score += 15;
    }
    
    // Meta title (10 points)
    const metaTitle = $('#meta_title').val();
    if (metaTitle.length >= 50 && metaTitle.length <= 60) {
        score += 10;
    } else if (metaTitle.length >= 40) {
        score += 5;
    }
    
    // Featured image (10 points)
    if ($('#featured_image').val()) {
        score += 10;
    }
    
    // Category (10 points)
    if ($('select[name="category_id"]').val()) {
        score += 10;
    }
    
    // Tags (10 points)
    if ($('#tags').val() && $('#tags').val().length > 0) {
        score += 10;
    }
    
    // Excerpt (10 points)
    const excerpt = $('#excerpt').val();
    if (excerpt.length >= 150 && excerpt.length <= 160) {
        score += 10;
    } else if (excerpt.length >= 100) {
        score += 5;
    }
    
    // Update score display
    const scoreElement = $('#seo-score');
    scoreElement.text(score + '%');
    
    if (score >= 80) {
        scoreElement.removeClass('text-gray-400 text-yellow-500 text-red-500').addClass('text-green-500');
    } else if (score >= 60) {
        scoreElement.removeClass('text-gray-400 text-green-500 text-red-500').addClass('text-yellow-500');
    } else if (score >= 40) {
        scoreElement.removeClass('text-gray-400 text-green-500 text-yellow-500').addClass('text-orange-500');
    } else {
        scoreElement.removeClass('text-gray-400 text-green-500 text-yellow-500 text-orange-500').addClass('text-red-500');
    }
}

// Featured image functions
function selectFeaturedImage() {
    const width = 1000;
    const height = 700;
    const left = (screen.width - width) / 2;
    const top = (screen.height - height) / 2;
    
    window.open(
        '{{ route("admin.media.browse") }}?type=image&mode=featured',
        'MediaBrowser',
        `width=${width},height=${height},left=${left},top=${top},resizable=yes,scrollbars=yes`
    );
}

// Function to set featured image from media browser
window.setFeaturedImage = function(url, name) {
    $('#featured_image').val(url);
    $('#featured-image-img').attr('src', url);
    $('#featured-image-preview').removeClass('hidden');
    updateSEOScore();
    
    console.log('Featured image set:', url);
};

function removeFeaturedImage() {
    $('#featured_image').val('');
    $('#featured-image-preview').addClass('hidden');
    updateSEOScore();
}

// Update SEO score on input changes
$('#focus_keyword, select[name="category_id"], #tags').on('change input', updateSEOScore);

// Initial SEO score calculation
$(document).ready(function() {
    updateSEOScore();
    
    // Initialize excerpt counter
    if ($('#excerpt').val()) {
        $('#excerpt').trigger('input');
    }
    
    // Trigger status change to show/hide published date
    $('#status').trigger('change');
    
    // Show featured image preview if exists
    if ($('#featured_image').val()) {
        $('#featured-image-img').attr('src', $('#featured_image').val());
        $('#featured-image-preview').removeClass('hidden');
    }
});
</script>
@endpush
