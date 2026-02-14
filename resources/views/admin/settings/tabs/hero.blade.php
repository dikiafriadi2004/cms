<div id="hero-tab" class="tab-content">
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-orange-50 to-amber-50">
                <h3 class="text-lg font-semibold text-gray-900">Hero Section Settings</h3>
                <p class="text-sm text-gray-600 mt-1">Configure homepage hero section content</p>
            </div>
            <div class="p-6 space-y-6">
                <!-- Hero Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hero Title</label>
                    <textarea name="settings[hero_title]" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Your main headline">{{ $getSetting('hero', 'hero_title') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Main headline di hero section. Gunakan line break untuk membuat baris baru.</p>
                </div>

                <!-- Hero Subtitle -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hero Subtitle</label>
                    <textarea name="settings[hero_subtitle]" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Supporting text for your headline">{{ $getSetting('hero', 'hero_subtitle') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Deskripsi pendukung di bawah title</p>
                </div>

                <!-- Hero Badge Text -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Badge Text</label>
                    <input type="text" name="settings[hero_badge_text]" 
                        value="{{ $getSetting('hero', 'hero_badge_text') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="e.g., Tersedia di Android & iOS">
                    <p class="mt-1 text-xs text-gray-500">Badge kecil di atas title</p>
                </div>

                <!-- Hero Image -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hero Image</label>
                    @if($getSetting('hero', 'hero_image'))
                    <div class="mb-3 p-4 bg-gray-50 rounded-lg inline-block">
                        <img src="{{ storage_url($getSetting('hero', 'hero_image')) }}" 
                            alt="Hero Image" class="h-48 object-contain">
                    </div>
                    @endif
                    <input type="file" name="hero_image" accept="image/*"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="mt-1 text-xs text-gray-500">Recommended: 350x700px (portrait), max 5MB</p>
                </div>

                <!-- Primary Button -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Primary Button Text</label>
                        <input type="text" name="settings[hero_button_text]" 
                            value="{{ $getSetting('hero', 'hero_button_text') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="e.g., Get Started">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Primary Button URL</label>
                        <input type="url" name="settings[hero_button_url]" 
                            value="{{ $getSetting('hero', 'hero_button_url') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="https://example.com">
                    </div>
                </div>

                <!-- Secondary Button -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Secondary Button Text</label>
                    <input type="text" name="settings[hero_button_secondary_text]" 
                        value="{{ $getSetting('hero', 'hero_button_secondary_text') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="e.g., Learn More">
                    <p class="mt-1 text-xs text-gray-500">Optional secondary button</p>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button type="submit" 
                class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                Save Hero Settings
            </button>
        </div>
    </form>
</div>
