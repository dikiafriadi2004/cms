<div id="footer-tab" class="tab-content">
    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-slate-50 to-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Footer Settings</h3>
                <p class="text-sm text-gray-600 mt-1">Configure footer content and copyright text</p>
            </div>
            <div class="p-6 space-y-6">
                <!-- Footer Copyright Text -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Footer Copyright Text</label>
                    <input type="text" name="settings[footer_text]" 
                        value="{{ $getSetting('footer', 'footer_text') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="© 2026 Your Company. All rights reserved.">
                    <p class="mt-1 text-xs text-gray-500">Teks copyright yang muncul di footer</p>
                </div>

                <!-- Footer About Text -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Footer About Text</label>
                    <textarea name="settings[footer_about]" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Brief description about your company or website...">{{ $getSetting('footer', 'footer_about') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Deskripsi singkat tentang perusahaan/website di footer</p>
                </div>

                <!-- Preview -->
                <div class="p-4 bg-slate-50 border border-slate-200 rounded-lg">
                    <p class="text-xs font-semibold text-slate-700 mb-2">Preview:</p>
                    <div class="bg-slate-800 text-white p-6 rounded-lg">
                        <div class="max-w-4xl mx-auto">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                                <div>
                                    <h4 class="font-bold mb-3">{{ $getSetting('general', 'site_name') ?: 'Your Site' }}</h4>
                                    <p class="text-sm text-slate-300">{{ $getSetting('footer', 'footer_about') ?: 'Footer about text will appear here...' }}</p>
                                </div>
                                <div>
                                    <h4 class="font-bold mb-3">Quick Links</h4>
                                    <p class="text-sm text-slate-400">Menu items...</p>
                                </div>
                                <div>
                                    <h4 class="font-bold mb-3">Contact</h4>
                                    <p class="text-sm text-slate-400">Contact info...</p>
                                </div>
                            </div>
                            <div class="border-t border-slate-700 pt-6 text-center">
                                <p class="text-sm text-slate-400">{{ $getSetting('footer', 'footer_text') ?: '© 2026 Your Company. All rights reserved.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div class="text-sm text-blue-800">
                            <p class="font-semibold mb-1">Footer Information:</p>
                            <ul class="list-disc list-inside space-y-0.5">
                                <li>Footer muncul di semua halaman website</li>
                                <li>Copyright text biasanya berisi tahun dan nama perusahaan</li>
                                <li>About text menjelaskan singkat tentang bisnis Anda</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button type="submit" 
                class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                Save Footer Settings
            </button>
        </div>
    </form>
</div>
