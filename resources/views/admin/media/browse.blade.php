<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Select Media</title>
    
    <link rel="icon" type="image/png" href="{{ favicon_url() }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50">
    <div x-data="mediaBrowser()" x-init="init()" class="min-h-screen flex flex-col">
        <!-- Header with Tabs -->
        <div class="bg-white border-b border-gray-200 px-6 py-4">
            <h1 class="text-2xl font-bold text-gray-900 mb-4">Select Media</h1>
            
            <!-- Tabs -->
            <div class="flex gap-4 mb-4">
                <button @click="activeTab = 'library'" 
                    :class="activeTab === 'library' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600'"
                    class="px-4 py-2 border-b-2 font-medium transition-colors">
                    Media Library
                </button>
                <button @click="activeTab = 'upload'" 
                    :class="activeTab === 'upload' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600'"
                    class="px-4 py-2 border-b-2 font-medium transition-colors">
                    Upload Files
                </button>
            </div>
            
            <!-- Search and Filter (Library Tab) -->
            <div x-show="activeTab === 'library'" class="flex gap-3">
                <input type="text" x-model="search" @input="filterFiles()" placeholder="Search files..." 
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                
                <select x-model="filterType" @change="filterFiles()" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="all">All Types</option>
                    <option value="image">Images</option>
                    <option value="video">Videos</option>
                    <option value="document">Documents</option>
                </select>
            </div>
        </div>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-6">
            <!-- Library Tab -->
            <div x-show="activeTab === 'library'" class="grid grid-cols-4 gap-4">
                @foreach($files as $file)
                <div class="group relative bg-white rounded-lg overflow-hidden hover:shadow-lg transition-all cursor-pointer border-2 border-transparent hover:border-blue-500"
                    @click="selectFile('{{ $file->url }}', '{{ $file->name }}', {{ $file->id }})">
                    
                    <!-- Preview -->
                    <div class="aspect-square flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200 p-4">
                        @if($file->file_type === 'image')
                            <img src="{{ $file->thumbnail_url }}" alt="{{ $file->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="text-center">
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

                    <!-- Info -->
                    <div class="p-3">
                        <p class="text-sm font-medium text-gray-900 truncate" title="{{ $file->name }}">{{ $file->name }}</p>
                        <p class="text-xs text-gray-500">{{ $file->formatted_size }}</p>
                    </div>

                    <!-- Selected Indicator -->
                    <div x-show="selectedId === {{ $file->id }}" class="absolute inset-0 bg-blue-500 bg-opacity-20 flex items-center justify-center">
                        <svg class="w-16 h-16 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Upload Tab -->
            <div x-show="activeTab === 'upload'" class="max-w-2xl mx-auto">
                <form @submit.prevent="uploadFiles()" class="space-y-6">
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-12 text-center hover:border-blue-500 transition-all cursor-pointer"
                        @dragover.prevent="dragOver = true"
                        @dragleave.prevent="dragOver = false"
                        @drop.prevent="handleDrop($event)"
                        :class="dragOver ? 'border-blue-500 bg-blue-50' : ''"
                        @click="$refs.fileInput.click()">
                        
                        <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        
                        <p class="mt-4 text-lg font-medium text-gray-700">Drop files here or click to browse</p>
                        <p class="mt-2 text-sm text-gray-500">Maximum file size: 10MB</p>
                        
                        <input type="file" x-ref="fileInput" multiple class="hidden" @change="handleFileSelect($event)">
                    </div>

                    <!-- Selected Files -->
                    <div x-show="selectedFiles.length > 0" class="space-y-2">
                        <p class="text-sm font-medium text-gray-700">Selected Files:</p>
                        <template x-for="(file, index) in selectedFiles" :key="index">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span class="text-sm text-gray-700" x-text="file.name"></span>
                                    <span class="text-xs text-gray-500" x-text="formatFileSize(file.size)"></span>
                                </div>
                                <button type="button" @click="removeFile(index)" class="text-red-600 hover:text-red-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>

                    <!-- Upload Progress -->
                    <div x-show="uploading" class="space-y-2">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full transition-all" :style="`width: ${uploadProgress}%`"></div>
                        </div>
                        <p class="text-sm text-gray-600 text-center" x-text="`Uploading... ${uploadProgress}%`"></p>
                    </div>

                    <button type="submit" :disabled="selectedFiles.length === 0 || uploading" 
                        class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all font-medium">
                        <span x-show="!uploading">Upload Files</span>
                        <span x-show="uploading">Uploading...</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="bg-white border-t border-gray-200 p-4 flex justify-between items-center">
            <div class="text-sm text-gray-600">
                <span x-show="selectedUrl">Selected: <span class="font-medium" x-text="selectedName"></span></span>
                <span x-show="!selectedUrl">No file selected</span>
            </div>
            <div class="flex gap-3">
                <button @click="window.close()" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all font-medium">
                    Cancel
                </button>
                <button @click="insertFile()" :disabled="!selectedUrl" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all font-medium">
                    Insert File
                </button>
            </div>
        </div>
    </div>

    <script>
    function mediaBrowser() {
        return {
            activeTab: 'library',
            search: '',
            filterType: 'all',
            selectedUrl: null,
            selectedName: null,
            selectedId: null,
            selectedFiles: [],
            dragOver: false,
            uploading: false,
            uploadProgress: 0,

            init() {
                const params = new URLSearchParams(window.location.search);
                this.search = params.get('search') || '';
                this.filterType = params.get('type') || 'all';
            },

            selectFile(url, name, id) {
                this.selectedUrl = url;
                this.selectedName = name;
                this.selectedId = id;
            },

            insertFile() {
                if (!this.selectedUrl) return;

                const urlParams = new URLSearchParams(window.location.search);
                const mode = urlParams.get('mode');

                if (mode === 'featured') {
                    if (window.opener && window.opener.setFeaturedImage) {
                        window.opener.setFeaturedImage(this.selectedUrl, this.selectedName);
                        window.close();
                    }
                } else {
                    if (window.opener && window.opener.insertMediaToEditor) {
                        window.opener.insertMediaToEditor(this.selectedUrl, this.selectedName);
                        window.close();
                    }
                }
            },

            handleFileSelect(event) {
                this.selectedFiles = Array.from(event.target.files);
            },

            handleDrop(event) {
                this.dragOver = false;
                this.selectedFiles = Array.from(event.dataTransfer.files);
            },

            removeFile(index) {
                this.selectedFiles.splice(index, 1);
            },

            formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
            },

            async uploadFiles() {
                if (this.selectedFiles.length === 0) return;

                this.uploading = true;
                this.uploadProgress = 0;

                const formData = new FormData();
                this.selectedFiles.forEach(file => {
                    formData.append('files[]', file);
                });

                try {
                    const response = await fetch('{{ route("admin.media.upload") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    });

                    // Check content type before parsing
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        throw new Error('Server returned non-JSON response. Please check your permissions.');
                    }

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || 'Upload failed');
                    }

                    if (data.success) {
                        alert(data.message || 'Files uploaded successfully!');
                        // Switch to library tab and reload
                        this.activeTab = 'library';
                        this.selectedFiles = [];
                        window.location.reload();
                    } else {
                        throw new Error(data.message || 'Upload failed');
                    }
                } catch (error) {
                    console.error('Upload error:', error);
                    alert('Upload failed: ' + error.message);
                } finally {
                    this.uploading = false;
                    this.uploadProgress = 0;
                }
            },

            filterFiles() {
                const params = new URLSearchParams();
                if (this.filterType !== 'all') params.append('type', this.filterType);
                if (this.search) params.append('search', this.search);
                
                window.location.href = '{{ route("admin.media.browse") }}?' + params.toString();
            }
        }
    }
    </script>
</body>
</html>
