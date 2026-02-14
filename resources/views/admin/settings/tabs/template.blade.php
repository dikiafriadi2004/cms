<div id="template-tab" class="tab-content">
    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-indigo-50 to-purple-50">
                <h3 class="text-lg font-semibold text-gray-900">Frontend Template</h3>
                <p class="text-sm text-gray-600 mt-1">Choose your website design template - Click to preview</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach($templates as $key => $template)
                    <label class="relative cursor-pointer group">
                        <input type="radio" name="settings[frontend_template]" value="{{ $key }}" 
                            {{ $currentTemplate === $key ? 'checked' : '' }}
                            class="peer sr-only">
                        
                        <div class="border-2 border-gray-200 rounded-2xl overflow-hidden transition-all peer-checked:border-blue-500 peer-checked:ring-4 peer-checked:ring-blue-100 hover:border-blue-400 hover:shadow-lg">
                            <!-- Preview Mockup -->
                            <div class="aspect-video bg-gray-100 relative overflow-hidden">
                                @if($key === 'default')
                                    <!-- Default Modern Preview -->
                                    <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-indigo-600 p-4">
                                        <div class="bg-white rounded-lg h-full p-3 space-y-2">
                                            <div class="h-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg"></div>
                                            <div class="grid grid-cols-3 gap-2 h-20">
                                                <div class="bg-gradient-to-br from-blue-100 to-indigo-100 rounded-lg"></div>
                                                <div class="bg-gradient-to-br from-blue-100 to-indigo-100 rounded-lg"></div>
                                                <div class="bg-gradient-to-br from-blue-100 to-indigo-100 rounded-lg"></div>
                                            </div>
                                            <div class="space-y-1">
                                                <div class="h-2 bg-blue-200 rounded w-3/4"></div>
                                                <div class="h-2 bg-blue-100 rounded w-1/2"></div>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($key === 'minimal')
                                    <!-- Minimal Clean Preview -->
                                    <div class="absolute inset-0 bg-white p-4">
                                        <div class="border-2 border-black h-full p-3 space-y-3">
                                            <div class="h-8 border-b-4 border-black"></div>
                                            <div class="grid grid-cols-3 gap-3 h-20">
                                                <div class="border-2 border-black"></div>
                                                <div class="border-2 border-black"></div>
                                                <div class="border-2 border-black"></div>
                                            </div>
                                            <div class="space-y-2">
                                                <div class="h-3 bg-black w-3/4"></div>
                                                <div class="h-2 bg-gray-400 w-1/2"></div>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($key === 'magazine')
                                    <!-- Magazine Bold Preview -->
                                    <div class="absolute inset-0 bg-white p-4">
                                        <div class="border-4 border-black h-full p-2 space-y-2">
                                            <div class="h-10 bg-gradient-to-r from-red-600 to-orange-500 border-l-8 border-black flex items-center px-2">
                                                <div class="w-2 h-6 bg-white"></div>
                                            </div>
                                            <div class="grid grid-cols-2 gap-2 h-16">
                                                <div class="border-4 border-black bg-red-100"></div>
                                                <div class="border-4 border-black bg-orange-100"></div>
                                            </div>
                                            <div class="space-y-1">
                                                <div class="h-3 bg-red-600 w-3/4"></div>
                                                <div class="h-2 bg-gray-800 w-1/2"></div>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($key === 'corporate')
                                    <!-- Corporate Professional Preview -->
                                    <div class="absolute inset-0 bg-gray-50 p-4">
                                        <div class="bg-white rounded-lg shadow-lg h-full p-3 space-y-2">
                                            <div class="h-8 bg-gradient-to-r from-blue-900 to-blue-700 rounded-lg"></div>
                                            <div class="grid grid-cols-3 gap-2 h-20">
                                                <div class="bg-blue-50 border border-blue-200 rounded-lg"></div>
                                                <div class="bg-blue-50 border border-blue-200 rounded-lg"></div>
                                                <div class="bg-blue-50 border border-blue-200 rounded-lg"></div>
                                            </div>
                                            <div class="space-y-1">
                                                <div class="h-2 bg-blue-600 rounded w-3/4"></div>
                                                <div class="h-2 bg-gray-300 rounded w-1/2"></div>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($key === 'elegant')
                                    <!-- Elegant Luxury Preview -->
                                    <div class="absolute inset-0 bg-gradient-to-b from-amber-50 to-white p-4">
                                        <div class="bg-white border-2 border-amber-200 h-full p-3 space-y-2">
                                            <div class="h-8 bg-gradient-to-r from-amber-400 to-amber-600 opacity-20 rounded"></div>
                                            <div class="flex justify-center">
                                                <div class="h-1 w-16 bg-gradient-to-r from-transparent via-amber-500 to-transparent"></div>
                                            </div>
                                            <div class="grid grid-cols-3 gap-2 h-16">
                                                <div class="border-2 border-amber-200 bg-amber-50"></div>
                                                <div class="border-2 border-amber-200 bg-amber-50"></div>
                                                <div class="border-2 border-amber-200 bg-amber-50"></div>
                                            </div>
                                            <div class="space-y-1">
                                                <div class="h-2 bg-amber-600 w-3/4 mx-auto"></div>
                                                <div class="h-1 bg-amber-300 w-1/2 mx-auto"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Selected Badge -->
                                <div class="absolute top-3 right-3 opacity-0 peer-checked:opacity-100 transition-opacity">
                                    <div class="bg-blue-500 text-white px-3 py-1.5 rounded-full text-xs font-bold flex items-center gap-1 shadow-lg">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Active
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Template Info -->
                            <div class="p-4 bg-white border-t border-gray-100">
                                <h4 class="font-bold text-gray-900 text-lg mb-1">{{ $template['name'] }}</h4>
                                <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $template['description'] }}</p>
                                
                                <!-- Features -->
                                <div class="flex flex-wrap gap-2 mb-3">
                                    @foreach($template['features'] as $feature)
                                    <span class="px-2.5 py-1 bg-gray-100 text-gray-700 text-xs rounded-full font-medium">{{ $feature }}</span>
                                    @endforeach
                                </div>

                                <!-- Preview Button -->
                                <button type="button"
                                   onclick="openPreviewModal('{{ $key }}', '{{ $template['name'] }}')"
                                   class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold text-sm transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Preview Template
                                </button>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>
                
                <!-- Template Comparison Table -->
                <div class="mt-8 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200">
                    <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        Template Comparison
                    </h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b-2 border-gray-300">
                                    <th class="text-left py-3 px-4 font-bold text-gray-900">Template</th>
                                    <th class="text-left py-3 px-4 font-bold text-gray-900">Color Scheme</th>
                                    <th class="text-left py-3 px-4 font-bold text-gray-900">Typography</th>
                                    <th class="text-left py-3 px-4 font-bold text-gray-900">Best For</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr class="hover:bg-white transition">
                                    <td class="py-3 px-4 font-semibold text-gray-900">Default Modern</td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-4 h-4 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600"></div>
                                            <span class="text-gray-700">Blue Gradient</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-gray-700">Sans-serif, Modern</td>
                                    <td class="py-3 px-4 text-gray-700">Tech, Startup, Modern Business</td>
                                </tr>
                                <tr class="hover:bg-white transition">
                                    <td class="py-3 px-4 font-semibold text-gray-900">Minimal Clean</td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-4 h-4 rounded-full bg-black"></div>
                                            <span class="text-gray-700">Black & White</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-gray-700">Sans-serif, Bold</td>
                                    <td class="py-3 px-4 text-gray-700">Portfolio, Agency, Minimalist</td>
                                </tr>
                                <tr class="hover:bg-white transition">
                                    <td class="py-3 px-4 font-semibold text-gray-900">Magazine Bold</td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-4 h-4 rounded-full bg-gradient-to-r from-red-600 to-orange-500"></div>
                                            <span class="text-gray-700">Red/Orange</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-gray-700">Sans-serif, Extra Bold</td>
                                    <td class="py-3 px-4 text-gray-700">News, Blog, Media</td>
                                </tr>
                                <tr class="hover:bg-white transition">
                                    <td class="py-3 px-4 font-semibold text-gray-900">Corporate Professional</td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-4 h-4 rounded-full bg-gradient-to-r from-blue-900 to-blue-700"></div>
                                            <span class="text-gray-700">Dark Blue</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-gray-700">Sans-serif, Professional</td>
                                    <td class="py-3 px-4 text-gray-700">Corporate, Finance, B2B</td>
                                </tr>
                                <tr class="hover:bg-white transition">
                                    <td class="py-3 px-4 font-semibold text-gray-900">Elegant Luxury</td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-4 h-4 rounded-full bg-gradient-to-r from-amber-500 to-amber-600"></div>
                                            <span class="text-gray-700">Gold/Amber</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-gray-700">Serif (Playfair), Elegant</td>
                                    <td class="py-3 px-4 text-gray-700">Luxury, Premium, Fashion</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-blue-900">Template Information</p>
                            <p class="text-xs text-blue-700 mt-1">Pilih template yang sesuai dengan brand dan target audience Anda. Perubahan akan langsung terlihat di frontend setelah save. Setiap template memiliki design custom untuk Home, Blog, Contact, dan Pages.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end gap-3">
            <a href="/" target="_blank" 
                class="px-8 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-colors shadow-sm flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Preview Current Template
            </a>
            <button type="submit" 
                class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Save Template Settings
            </button>
        </div>
    </form>

    <!-- Preview Modal -->
    <div id="previewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-7xl h-[90vh] flex flex-col">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900" id="previewTitle">Template Preview</h3>
                        <p class="text-sm text-gray-600">Live preview of template design</p>
                    </div>
                </div>
                <button onclick="closePreviewModal()" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body - iframe -->
            <div class="flex-1 overflow-hidden">
                <iframe id="previewIframe" class="w-full h-full border-0" src="about:blank"></iframe>
            </div>
            
            <!-- Modal Footer -->
            <div class="p-4 border-t border-gray-200 bg-gray-50 flex items-center justify-between">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>This is a live preview. Click "Save Template Settings" to apply.</span>
                </div>
                <button onclick="closePreviewModal()" class="px-6 py-2 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition">
                    Close Preview
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

<script>
function openPreviewModal(templateKey, templateName) {
    const modal = document.getElementById('previewModal');
    const iframe = document.getElementById('previewIframe');
    const title = document.getElementById('previewTitle');
    
    title.textContent = templateName + ' - Preview';
    iframe.src = '{{ url("/admin/settings/template-preview") }}/' + templateKey;
    modal.classList.remove('hidden');
    
    // Prevent body scroll
    document.body.style.overflow = 'hidden';
}

function closePreviewModal() {
    const modal = document.getElementById('previewModal');
    const iframe = document.getElementById('previewIframe');
    
    modal.classList.add('hidden');
    iframe.src = 'about:blank';
    
    // Restore body scroll
    document.body.style.overflow = '';
}

// Close modal on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closePreviewModal();
    }
});

// Close modal on backdrop click
document.getElementById('previewModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closePreviewModal();
    }
});
</script>
