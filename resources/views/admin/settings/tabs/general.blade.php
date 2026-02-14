<div id="general-tab" class="tab-content">
    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                <h3 class="text-lg font-semibold text-gray-900">General Settings</h3>
                <p class="text-sm text-gray-600 mt-1">Basic site information and contact details</p>
            </div>
            <div class="p-6 space-y-6">
                <!-- Site Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Site Name</label>
                    <input type="text" name="settings[site_name]" 
                        value="{{ $getSetting('general', 'site_name') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Your Site Name">
                </div>

                <!-- Site Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Site Description</label>
                    <textarea name="settings[site_description]" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Brief description of your website">{{ $getSetting('general', 'site_description') }}</textarea>
                </div>

                <!-- Site URL -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Site URL</label>
                    <input type="url" name="settings[site_url]" 
                        value="{{ $getSetting('general', 'site_url') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="https://example.com">
                </div>

                <!-- Admin Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Admin Email</label>
                    <input type="email" name="settings[admin_email]" 
                        value="{{ $getSetting('general', 'admin_email') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="admin@example.com">
                </div>

                <!-- Contact Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contact Email</label>
                    <input type="email" name="settings[contact_email]" 
                        value="{{ $getSetting('general', 'contact_email') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="contact@example.com">
                    <p class="mt-1 text-xs text-gray-500">Email untuk kontak publik dan penerima pesan contact form</p>
                </div>

                <!-- Contact Phone -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contact Phone</label>
                    <input type="text" name="settings[contact_phone]" 
                        value="{{ $getSetting('general', 'contact_phone') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="+62 812-3456-7890">
                    <p class="mt-1 text-xs text-gray-500">Nomor telepon untuk kontak publik</p>
                </div>

                <!-- Contact Address -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contact Address</label>
                    <textarea name="settings[contact_address]" rows="2"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Jl. Contoh No. 123, Jakarta">{{ $getSetting('general', 'contact_address') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Alamat lengkap untuk kontak publik</p>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button type="submit" 
                class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                Save General Settings
            </button>
        </div>
    </form>
</div>
