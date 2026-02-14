<div id="social-tab" class="tab-content">
    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-pink-50 to-rose-50">
                <h3 class="text-lg font-semibold text-gray-900">Social Media Settings</h3>
                <p class="text-sm text-gray-600 mt-1">Configure social media links and WhatsApp</p>
            </div>
            <div class="p-6 space-y-6">
                <!-- WhatsApp Number -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        WhatsApp Number
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 ml-2">
                            Featured
                        </span>
                    </label>
                    <input type="text" name="settings[whatsapp_number]" 
                        value="{{ $getSetting('social', 'whatsapp_number') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="+628123456789">
                    <p class="mt-1 text-xs text-gray-500">Format: +628123456789 (tanpa spasi untuk link WhatsApp)</p>
                </div>

                <!-- Facebook URL -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Facebook URL</label>
                    <input type="url" name="settings[facebook_url]" 
                        value="{{ $getSetting('social', 'facebook_url') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="https://facebook.com/yourpage">
                    <p class="mt-1 text-xs text-gray-500">Link ke halaman Facebook Anda</p>
                </div>

                <!-- Instagram URL -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Instagram URL</label>
                    <input type="url" name="settings[instagram_url]" 
                        value="{{ $getSetting('social', 'instagram_url') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="https://instagram.com/yourusername">
                    <p class="mt-1 text-xs text-gray-500">Link ke profil Instagram Anda</p>
                </div>

                <!-- Twitter URL -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Twitter / X URL</label>
                    <input type="url" name="settings[twitter_url]" 
                        value="{{ $getSetting('social', 'twitter_url') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="https://twitter.com/yourusername">
                    <p class="mt-1 text-xs text-gray-500">Link ke profil Twitter/X Anda</p>
                </div>

                <!-- YouTube URL -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">YouTube URL</label>
                    <input type="url" name="settings[youtube_url]" 
                        value="{{ $getSetting('social', 'youtube_url') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="https://youtube.com/@yourchannel">
                    <p class="mt-1 text-xs text-gray-500">Link ke channel YouTube Anda</p>
                </div>

                <!-- Telegram URL -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Telegram URL</label>
                    <input type="url" name="settings[telegram_url]" 
                        value="{{ $getSetting('social', 'telegram_url') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="https://t.me/yourchannel">
                    <p class="mt-1 text-xs text-gray-500">Link ke channel/group Telegram Anda</p>
                </div>

                <!-- Info Box -->
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div class="text-sm text-blue-800">
                            <p class="font-semibold mb-1">Dimana Social Media Links Muncul?</p>
                            <ul class="list-disc list-inside space-y-0.5">
                                <li>Footer di semua halaman website</li>
                                <li>Contact page (jika diisi)</li>
                                <li>WhatsApp: Tombol chat di homepage & contact page</li>
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
                Save Social Media Settings
            </button>
        </div>
    </form>
</div>
