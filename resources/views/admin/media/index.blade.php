@extends('layouts.admin')

@section('title', 'Media Library')
@section('page-title', 'Media Library')

@section('content')
<div id="mediaManager" class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center gap-3">
            <button onclick="mediaManager.openUploadModal()" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all font-medium shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                Upload Files
            </button>
            
            <button onclick="mediaManager.createFolder()" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                </svg>
                New Folder
            </button>
        </div>

        <div class="flex items-center gap-3 w-full sm:w-auto">
            <!-- Search -->
            <div class="relative flex-1 sm:flex-initial">
                <input type="text" id="searchInput" placeholder="Search files..." 
                    class="w-full sm:w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <!-- View Toggle -->
            <div class="flex bg-gray-100 rounded-lg p-1">
                <button onclick="mediaManager.setViewMode('grid')" id="gridViewBtn" class="p-2 rounded transition-all bg-white shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                </button>
                <button onclick="mediaManager.setViewMode('list')" id="listViewBtn" class="p-2 rounded transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="flex gap-2 overflow-x-auto pb-2">
        <button onclick="mediaManager.setFilter('all')" data-filter="all" class="filter-btn px-4 py-2 rounded-lg font-medium transition-all whitespace-nowrap bg-blue-600 text-white">
            All Files
        </button>
        <button onclick="mediaManager.setFilter('image')" data-filter="image" class="filter-btn px-4 py-2 rounded-lg font-medium transition-all whitespace-nowrap bg-white text-gray-700 hover:bg-gray-50">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Images
        </button>
        <button onclick="mediaManager.setFilter('video')" data-filter="video" class="filter-btn px-4 py-2 rounded-lg font-medium transition-all whitespace-nowrap bg-white text-gray-700 hover:bg-gray-50">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
            </svg>
            Videos
        </button>
        <button onclick="mediaManager.setFilter('document')" data-filter="document" class="filter-btn px-4 py-2 rounded-lg font-medium transition-all whitespace-nowrap bg-white text-gray-700 hover:bg-gray-50">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Documents
        </button>
    </div>

    <!-- Files Grid/List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Grid View -->
        <div id="gridView" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 p-6">
            @forelse($files as $file)
            <div class="group relative bg-gray-50 rounded-lg overflow-hidden hover:shadow-lg transition-all cursor-pointer border-2 border-transparent hover:border-blue-500 flex flex-col"
                onclick="mediaManager.selectFile({{ $file->id }}, '{{ $file->url }}', '{{ $file->name }}')">
                
                <!-- Preview - Fixed aspect ratio -->
                <div class="relative w-full" style="padding-bottom: 100%;">
                    <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                        @if($file->file_type === 'image')
                            <img src="{{ $file->thumbnail_url }}" alt="{{ $file->name }}" class="absolute inset-0 w-full h-full object-cover">
                        @else
                            <div class="text-center p-4">
                                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($file->file_type === 'video')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    @endif
                                </svg>
                                <p class="text-xs text-gray-500 mt-2 uppercase">{{ pathinfo($file->original_name, PATHINFO_EXTENSION) }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Info -->
                <div class="p-3 bg-white border-t border-gray-200">
                    <p class="text-sm font-medium text-gray-900 truncate" title="{{ $file->name }}">{{ $file->name }}</p>
                    <p class="text-xs text-gray-500">{{ $file->formatted_size }}</p>
                </div>

                <!-- Actions -->
                <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                    <button onclick="event.stopPropagation(); mediaManager.deleteFile({{ $file->id }})" class="p-1.5 bg-white rounded-lg shadow-lg hover:bg-red-50 transition-all">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                <p class="mt-4 text-gray-500">No files found</p>
                <button onclick="mediaManager.openUploadModal()" class="mt-4 text-blue-600 hover:text-blue-700 font-medium">
                    Upload your first file
                </button>
            </div>
            @endforelse
        </div>

        <!-- List View -->
        <div id="listView" class="overflow-x-auto" style="display: none;">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preview</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($files as $file)
                    <tr class="hover:bg-gray-50 cursor-pointer" onclick="mediaManager.selectFile({{ $file->id }}, '{{ $file->url }}', '{{ $file->name }}')">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-100 flex items-center justify-center flex-shrink-0">
                                @if($file->file_type === 'image')
                                    <img src="{{ $file->thumbnail_url }}" alt="{{ $file->name }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $file->name }}</div>
                            <div class="text-sm text-gray-500">{{ $file->original_name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $file->type_badge_class }}">
                                {{ ucfirst($file->file_type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $file->formatted_size }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $file->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button onclick="event.stopPropagation(); mediaManager.deleteFile({{ $file->id }})" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            No files found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($files->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $files->links() }}
        </div>
        @endif
    </div>

    <!-- Upload Modal -->
    <div id="uploadModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black opacity-50" onclick="mediaManager.closeUploadModal()"></div>
            
            <div class="relative bg-white rounded-xl shadow-2xl max-w-2xl w-full p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Upload Files</h3>
                    <button onclick="mediaManager.closeUploadModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form id="uploadForm" onsubmit="return mediaManager.uploadFiles(event)">
                    @csrf
                    <div id="dropZone" class="border-2 border-dashed border-gray-300 rounded-lg p-12 text-center hover:border-blue-500 transition-all cursor-pointer"
                        onclick="document.getElementById('fileInput').click()">
                        
                        <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        
                        <p class="mt-4 text-lg font-medium text-gray-700">Drop files here or click to browse</p>
                        <p class="mt-2 text-sm text-gray-500">Maximum file size: 10MB</p>
                        
                        <input type="file" id="fileInput" name="files[]" multiple class="hidden" onchange="mediaManager.handleFileSelect(event)">
                    </div>

                    <!-- Selected Files -->
                    <div id="selectedFilesContainer" class="mt-4 space-y-2" style="display: none;">
                        <p class="text-sm font-medium text-gray-700">Selected Files:</p>
                        <div id="selectedFilesList"></div>
                    </div>

                    <!-- Upload Progress -->
                    <div id="uploadProgress" class="mt-4" style="display: none;">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div id="progressBar" class="bg-blue-600 h-2 rounded-full transition-all" style="width: 0%"></div>
                        </div>
                        <p id="progressText" class="text-sm text-gray-600 mt-2 text-center">Uploading... 0%</p>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit" id="uploadBtn"
                            class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all font-medium">
                            Upload Files
                        </button>
                        <button type="button" onclick="mediaManager.closeUploadModal()" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all font-medium">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Vanilla JavaScript Media Manager - NO Alpine.js
const mediaManager = {
    selectedFiles: [],
    viewMode: 'grid',
    filterType: 'all',

    init() {
        // Setup drag and drop
        const dropZone = document.getElementById('dropZone');
        if (dropZone) {
            dropZone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropZone.classList.add('border-blue-500', 'bg-blue-50');
            });
            
            dropZone.addEventListener('dragleave', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-blue-500', 'bg-blue-50');
            });
            
            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-blue-500', 'bg-blue-50');
                this.handleDrop(e);
            });
        }

        // Setup search
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', () => {
                clearTimeout(this.searchTimeout);
                this.searchTimeout = setTimeout(() => this.filterFiles(), 500);
            });
        }

        console.log('Media Manager initialized');
    },

    openUploadModal() {
        document.getElementById('uploadModal').style.display = 'block';
        this.selectedFiles = [];
        this.updateSelectedFilesList();
    },

    closeUploadModal() {
        document.getElementById('uploadModal').style.display = 'none';
        this.selectedFiles = [];
        document.getElementById('fileInput').value = '';
        this.updateSelectedFilesList();
    },

    handleFileSelect(event) {
        this.selectedFiles = Array.from(event.target.files);
        this.updateSelectedFilesList();
    },

    handleDrop(event) {
        this.selectedFiles = Array.from(event.dataTransfer.files);
        document.getElementById('fileInput').files = event.dataTransfer.files;
        this.updateSelectedFilesList();
    },

    updateSelectedFilesList() {
        const container = document.getElementById('selectedFilesContainer');
        const list = document.getElementById('selectedFilesList');
        
        if (this.selectedFiles.length === 0) {
            container.style.display = 'none';
            return;
        }

        container.style.display = 'block';
        list.innerHTML = this.selectedFiles.map((file, index) => `
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="text-sm text-gray-700">${file.name}</span>
                    <span class="text-xs text-gray-500">${this.formatFileSize(file.size)}</span>
                </div>
                <button type="button" onclick="mediaManager.removeFile(${index})" class="text-red-600 hover:text-red-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        `).join('');
    },

    removeFile(index) {
        this.selectedFiles.splice(index, 1);
        this.updateSelectedFilesList();
    },

    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    },

    async uploadFiles(event) {
        event.preventDefault();
        
        if (this.selectedFiles.length === 0) {
            window.showToast('error', 'Please select files to upload');
            return false;
        }

        const uploadBtn = document.getElementById('uploadBtn');
        const progressDiv = document.getElementById('uploadProgress');
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');

        uploadBtn.disabled = true;
        uploadBtn.textContent = 'Uploading...';
        progressDiv.style.display = 'block';

        const formData = new FormData();
        this.selectedFiles.forEach(file => {
            formData.append('files[]', file);
        });

        try {
            const response = await fetch('{{ route("admin.media.upload") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            });

            if (!response.ok) {
                const text = await response.text();
                console.error('Server response:', text);
                throw new Error(`Server error: ${response.status}`);
            }

            const data = await response.json();

            if (data.success) {
                this.closeUploadModal();
                window.showToast('success', data.message || 'Files uploaded successfully!');
                setTimeout(() => window.location.reload(), 1000);
            } else {
                window.showToast('error', data.message || 'Upload failed. Please try again.');
            }
        } catch (error) {
            console.error('Upload error:', error);
            window.showToast('error', 'Upload failed: ' + error.message);
        } finally {
            uploadBtn.disabled = false;
            uploadBtn.textContent = 'Upload Files';
            progressDiv.style.display = 'none';
            progressBar.style.width = '0%';
        }

        return false;
    },

    setViewMode(mode) {
        this.viewMode = mode;
        const gridView = document.getElementById('gridView');
        const listView = document.getElementById('listView');
        const gridBtn = document.getElementById('gridViewBtn');
        const listBtn = document.getElementById('listViewBtn');

        if (mode === 'grid') {
            gridView.style.display = 'grid';
            listView.style.display = 'none';
            gridBtn.classList.add('bg-white', 'shadow-sm');
            listBtn.classList.remove('bg-white', 'shadow-sm');
        } else {
            gridView.style.display = 'none';
            listView.style.display = 'block';
            listBtn.classList.add('bg-white', 'shadow-sm');
            gridBtn.classList.remove('bg-white', 'shadow-sm');
        }
    },

    setFilter(type) {
        this.filterType = type;
        
        // Update button styles
        document.querySelectorAll('.filter-btn').forEach(btn => {
            if (btn.dataset.filter === type) {
                btn.classList.remove('bg-white', 'text-gray-700', 'hover:bg-gray-50');
                btn.classList.add('bg-blue-600', 'text-white');
            } else {
                btn.classList.remove('bg-blue-600', 'text-white');
                btn.classList.add('bg-white', 'text-gray-700', 'hover:bg-gray-50');
            }
        });

        this.filterFiles();
    },

    filterFiles() {
        const params = new URLSearchParams();
        if (this.filterType !== 'all') params.append('type', this.filterType);
        
        const search = document.getElementById('searchInput')?.value;
        if (search) params.append('search', search);
        
        window.location.href = '{{ route("admin.media.index") }}?' + params.toString();
    },

    selectFile(id, url, name) {
        if (window.opener && window.opener.selectMediaFile) {
            window.opener.selectMediaFile(url, name);
            window.close();
        }
    },

    async deleteFile(id) {
        if (!await window.confirmDelete('Delete File', 'Are you sure you want to delete this file? This action cannot be undone.')) {
            return;
        }

        try {
            const response = await fetch(`{{ url('admin/media') }}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error(`Server error: ${response.status}`);
            }

            const data = await response.json();

            if (data.success) {
                window.showToast('success', data.message || 'File deleted successfully!');
                setTimeout(() => window.location.reload(), 1000);
            } else {
                window.showToast('error', data.message || 'Delete failed.');
            }
        } catch (error) {
            console.error('Delete error:', error);
            window.showToast('error', 'Delete failed: ' + error.message);
        }
    },

    createFolder() {
        const name = prompt('Enter folder name:');
        if (!name) return;

        fetch('{{ route("admin.media.create-folder") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ name })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.showToast('success', 'Folder created successfully!');
                setTimeout(() => window.location.reload(), 1000);
            }
        })
        .catch(error => {
            window.showToast('error', 'Failed to create folder');
        });
    }
};

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    mediaManager.init();
});
</script>
@endpush
@endsection
