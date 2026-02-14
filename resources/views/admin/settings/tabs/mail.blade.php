<div id="mail-tab" class="tab-content">
    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-cyan-50 to-blue-50">
                <h3 class="text-lg font-semibold text-gray-900">Mail Settings</h3>
                <p class="text-sm text-gray-600 mt-1">Configure SMTP and email settings</p>
            </div>
            <div class="p-6 space-y-6">
                <!-- Mail Driver -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mail Driver</label>
                    <select name="settings[mail_driver]"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="smtp" {{ $getSetting('email', 'mail_driver') === 'smtp' ? 'selected' : '' }}>SMTP</option>
                        <option value="sendmail" {{ $getSetting('email', 'mail_driver') === 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                        <option value="mailgun" {{ $getSetting('email', 'mail_driver') === 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                        <option value="ses" {{ $getSetting('email', 'mail_driver') === 'ses' ? 'selected' : '' }}>Amazon SES</option>
                        <option value="log" {{ $getSetting('email', 'mail_driver') === 'log' ? 'selected' : '' }}>Log (Testing)</option>
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Pilih mail driver yang akan digunakan</p>
                </div>

                <!-- SMTP Settings -->
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <h4 class="font-semibold text-blue-900 mb-3">SMTP Configuration</h4>
                    
                    <div class="space-y-4">
                        <!-- Mail Host -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Host</label>
                            <input type="text" name="settings[mail_host]" 
                                value="{{ $getSetting('email', 'mail_host') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="smtp.gmail.com">
                            <p class="mt-1 text-xs text-gray-500">SMTP server hostname</p>
                        </div>

                        <!-- Mail Port & Encryption -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Port</label>
                                <input type="number" name="settings[mail_port]" 
                                    value="{{ $getSetting('email', 'mail_port') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="587">
                                <p class="mt-1 text-xs text-gray-500">Common: 587 (TLS), 465 (SSL)</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Encryption</label>
                                <select name="settings[mail_encryption]"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="tls" {{ $getSetting('email', 'mail_encryption') === 'tls' ? 'selected' : '' }}>TLS</option>
                                    <option value="ssl" {{ $getSetting('email', 'mail_encryption') === 'ssl' ? 'selected' : '' }}>SSL</option>
                                    <option value="" {{ $getSetting('email', 'mail_encryption') === '' ? 'selected' : '' }}>None</option>
                                </select>
                            </div>
                        </div>

                        <!-- Username & Password -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Username</label>
                            <input type="text" name="settings[mail_username]" 
                                value="{{ $getSetting('email', 'mail_username') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="your-email@gmail.com">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Password</label>
                            <input type="password" name="settings[mail_password]" 
                                value="{{ $getSetting('email', 'mail_password') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="••••••••">
                            <p class="mt-1 text-xs text-gray-500">For Gmail, use App Password instead of regular password</p>
                        </div>
                    </div>
                </div>

                <!-- From Address -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">From Email Address</label>
                        <input type="email" name="settings[mail_from_address]" 
                            value="{{ $getSetting('email', 'mail_from_address') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="noreply@example.com">
                        <p class="mt-1 text-xs text-gray-500">Email address yang muncul sebagai pengirim</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">From Name</label>
                        <input type="text" name="settings[mail_from_name]" 
                            value="{{ $getSetting('email', 'mail_from_name') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Your Site Name">
                        <p class="mt-1 text-xs text-gray-500">Nama yang muncul sebagai pengirim (selalu berfungsi)</p>
                    </div>
                </div>

                <!-- Important Note about From Address -->
                <div class="p-4 bg-amber-50 border border-amber-200 rounded-lg">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div class="text-sm text-amber-800">
                            <p class="font-semibold mb-2">Kapan From Email Address Bisa Digunakan?</p>
                            
                            <div class="space-y-2">
                                <div>
                                    <p class="font-medium text-green-700 mb-1">✓ BISA digunakan dengan:</p>
                                    <ul class="list-disc list-inside ml-2 space-y-0.5">
                                        <li>SMTP Provider Profesional (SendGrid, Mailgun, Amazon SES, Postmark)</li>
                                        <li>Google Workspace / Microsoft 365 dengan domain sendiri</li>
                                        <li>SMTP Server sendiri dengan SPF/DKIM configured</li>
                                    </ul>
                                </div>
                                
                                <div>
                                    <p class="font-medium text-red-700 mb-1">✗ TIDAK bisa dengan:</p>
                                    <ul class="list-disc list-inside ml-2 space-y-0.5">
                                        <li>Gmail personal (gmail.com) - akan selalu gunakan SMTP Username</li>
                                        <li>Outlook/Hotmail personal - akan selalu gunakan SMTP Username</li>
                                        <li>Yahoo Mail - akan selalu gunakan SMTP Username</li>
                                    </ul>
                                </div>
                                
                                <div class="mt-2 p-2 bg-blue-50 border border-blue-200 rounded">
                                    <p class="font-medium text-blue-900">💡 Tips:</p>
                                    <p class="text-blue-800">From Name akan selalu berfungsi terlepas dari provider yang digunakan. Jadi minimal nama pengirim bisa dikustomisasi.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Help Text -->
                <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div class="text-sm text-yellow-800">
                            <p class="font-semibold mb-1">Gmail Users:</p>
                            <p>Jika menggunakan Gmail, aktifkan 2-Step Verification dan buat App Password di <a href="https://myaccount.google.com/apppasswords" target="_blank" class="underline">Google Account Settings</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button type="submit" 
                class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                Save Mail Settings
            </button>
        </div>
    </form>
</div>
