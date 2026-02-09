@extends('layouts.admin')

@section('title', 'Edit Page')
@section('page-title', 'Edit Page: ' . $page->title)

@section('content')
<form method="POST" action="{{ route('admin.pages.update', $page) }}" id="page-form" class="space-y-6">
    @csrf
    @method('PUT')
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content - 2 columns -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Page Content Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                    <h3 class="text-lg font-semibold text-gray-900">Page Content</h3>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" id="title" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('title') border-red-500 @enderror" 
                            value="{{ old('title', $page->title) }}"
                            placeholder="Enter page title...">
                        @error('title')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                        <input type="text" name="slug" id="slug"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('slug') border-red-500 @enderror" 
                            value="{{ old('slug', $page->slug) }}"
                            placeholder="auto-generated-from-title">
                        <p class="mt-1 text-xs text-gray-500">Leave empty to auto-generate from title</p>
                        @error('slug')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                            Content <span class="text-red-500">*</span>
                        </label>
                        <div id="content" class="bg-white border border-gray-300 rounded-lg"></div>
                        <textarea name="content" style="display:none;">{{ old('content', $page->content) }}</textarea>
                        @error('content')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- SEO Settings Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                    <h3 class="text-lg font-semibold text-gray-900">SEO Settings</h3>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Meta Title -->
                    <div>
                        <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-2">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title" maxlength="60"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                            value="{{ old('meta_title', $page->meta_title) }}"
                            placeholder="SEO-friendly title">
                        <div class="mt-1 flex items-center justify-between">
                            <p class="text-xs text-gray-500">Optimal: 50-60 characters</p>
                            <span class="text-xs font-medium"><span id="meta-title-count">0</span>/60</span>
                        </div>
                    </div>

                    <!-- Meta Description -->
                    <div>
                        <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" rows="3" maxlength="160"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none"
                            placeholder="Compelling description...">{{ old('meta_description', $page->meta_description) }}</textarea>
                        <div class="mt-1 flex items-center justify-between">
                            <p class="text-xs text-gray-500">Optimal: 120-160 characters</p>
                            <span class="text-xs font-medium"><span id="meta-desc-count">0</span>/160</span>
                        </div>
                    </div>

                    <!-- Meta Keywords -->
                    <div>
                        <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-2">Meta Keywords</label>
                        <input type="text" name="meta_keywords" id="meta_keywords"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                            value="{{ old('meta_keywords', $page->meta_keywords) }}"
                            placeholder="keyword1, keyword2, keyword3">
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
                            <option value="draft" {{ old('status', $page->status) === 'draft' ? 'selected' : '' }}>📝 Draft</option>
                            <option value="published" {{ old('status', $page->status) === 'published' ? 'selected' : '' }}>✅ Published</option>
                        </select>
                    </div>

                    <!-- Template -->
                    <div>
                        <label for="template" class="block text-sm font-medium text-gray-700 mb-2">Template</label>
                        <select name="template" id="template" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            <option value="default" {{ old('template', $page->template) === 'default' ? 'selected' : '' }}>Default</option>
                            <option value="full-width" {{ old('template', $page->template) === 'full-width' ? 'selected' : '' }}>Full Width</option>
                            <option value="sidebar" {{ old('template', $page->template) === 'sidebar' ? 'selected' : '' }}>With Sidebar</option>
                        </select>
                    </div>

                    <!-- Show in Menu -->
                    <div class="flex items-center">
                        <input type="checkbox" name="show_in_menu" id="show_in_menu" value="1" {{ old('show_in_menu', $page->show_in_menu) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <label for="show_in_menu" class="ml-2 text-sm text-gray-700">Show in menu</label>
                    </div>

                    <!-- Actions -->
                    <div class="pt-4 space-y-3">
                        <button type="submit" class="w-full flex items-center justify-center px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-200 transition-all font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Update Page
                        </button>
                        <a href="{{ route('admin.pages.index') }}" class="w-full flex items-center justify-center px-4 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Pages
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
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
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'align': [] }],
                ['blockquote', 'code-block'],
                ['link', 'image'],
                ['clean']
            ],
            handlers: {
                image: imageHandler
            }
        }
    }
});

// Load existing content
var existingContent = document.querySelector('textarea[name="content"]').value;
if (existingContent) {
    quill.root.innerHTML = existingContent;
}

// Initialize image resize functionality
if (typeof QuillImageResize !== 'undefined') {
    QuillImageResize.init(quill);
}

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
document.getElementById('page-form').addEventListener('submit', function() {
    document.querySelector('textarea[name="content"]').value = quill.root.innerHTML;
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
});

// Character counters
$('#meta_title').on('input', function() {
    $('#meta-title-count').text($(this).val().length);
});

$('#meta_description').on('input', function() {
    $('#meta-desc-count').text($(this).val().length);
});
</script>
@endpush
