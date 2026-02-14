<div id="branding-tab" class="tab-content">
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <!-- Hidden input to satisfy validation -->
        <input type="hidden" name="settings[_branding]" value="1">
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-pink-50">
                <h3 class="text-lg font-semibold text-gray-900">Branding</h3>
                <p class="text-sm text-gray-600 mt-1">Logo, favicon, and brand assets</p>
            </div>
            <div class="p-6 space-y-6">
                <!-- Logo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
                    @if($getSetting('branding', 'logo'))
                    <div class="mb-3 p-4 bg-gray-50 rounded-lg inline-block">
                        <img src="{{ storage_url($getSetting('branding', 'logo')) }}" 
                            alt="Logo" class="h-16 object-contain">
                    </div>
                    @endif
                    <input type="file" name="logo" accept="image/*"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="mt-1 text-xs text-gray-500">Recommended: PNG or SVG, max 2MB</p>
                </div>

                <!-- Favicon -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Favicon</label>
                    @if($getSetting('branding', 'favicon'))
                    <div class="mb-3 p-4 bg-gray-50 rounded-lg inline-block">
                        <img src="{{ storage_url($getSetting('branding', 'favicon')) }}" 
                            alt="Favicon" class="h-8 w-8 object-contain">
                    </div>
                    @endif
                    <input type="file" name="favicon" accept="image/*"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="mt-1 text-xs text-gray-500">Recommended: ICO or PNG, 32x32px, max 1MB</p>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button type="submit" 
                class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                Save Branding Settings
            </button>
        </div>
    </form>
</div>
