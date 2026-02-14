<div id="seo-tab" class="tab-content">
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                <h3 class="text-lg font-semibold text-gray-900">SEO Settings</h3>
                <p class="text-sm text-gray-600 mt-1">Optimize your website for search engines</p>
            </div>
            <div class="p-6 space-y-6">
                <!-- Meta Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Default Meta Title</label>
                    <input type="text" name="settings[meta_title]" 
                        value="{{ $getSetting('seo', 'meta_title') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Your Site - Tagline">
                    <p class="mt-1 text-xs text-gray-500">Digunakan sebagai default title untuk homepage</p>
                </div>

                <!-- Meta Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Default Meta Description</label>
                    <textarea name="settings[meta_description]" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Default description for your website">{{ $getSetting('seo', 'meta_description') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Optimal: 120-160 karakter</p>
                </div>

                <!-- Meta Keywords -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Default Meta Keywords</label>
                    <input type="text" name="settings[meta_keywords]" 
                        value="{{ $getSetting('seo', 'meta_keywords') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="keyword1, keyword2, keyword3">
                    <p class="mt-1 text-xs text-gray-500">Pisahkan dengan koma</p>
                </div>

                <!-- OG Image -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Open Graph Image</label>
                    @if($getSetting('seo', 'og_image'))
                    <div class="mb-3 p-4 bg-gray-50 rounded-lg inline-block">
                        <img src="{{ storage_url($getSetting('seo', 'og_image')) }}" 
                            alt="OG Image" class="h-32 object-contain">
                    </div>
                    @endif
                    <input type="file" name="og_image" accept="image/*"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="mt-1 text-xs text-gray-500">Recommended: 1200x630px, max 2MB</p>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button type="submit" 
                class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                Save SEO Settings
            </button>
        </div>
    </form>
</div>
