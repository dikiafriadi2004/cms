@extends('layouts.admin')

@section('title', 'Settings')
@section('page-title', 'Site Settings')

@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Site Settings</h2>
        <p class="mt-1 text-sm text-gray-600">Configure your website settings and preferences</p>
    </div>

    <!-- General Settings -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
            <h3 class="text-lg font-semibold text-gray-900">General Settings</h3>
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

    <!-- Branding -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-pink-50">
            <h3 class="text-lg font-semibold text-gray-900">Branding</h3>
        </div>
        <div class="p-6 space-y-6">
            <!-- Logo -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
                @if($getSetting('branding', 'logo'))
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $getSetting('branding', 'logo')) }}" 
                        alt="Logo" class="h-16 object-contain">
                </div>
                @endif
                <input type="file" name="settings[logo]" accept="image/*"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <p class="mt-1 text-xs text-gray-500">Recommended: PNG or SVG, max 2MB</p>
            </div>

            <!-- Favicon -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Favicon</label>
                @if($getSetting('branding', 'favicon'))
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $getSetting('branding', 'favicon')) }}" 
                        alt="Favicon" class="h-8 w-8 object-contain">
                </div>
                @endif
                <input type="file" name="settings[favicon]" accept="image/*"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <p class="mt-1 text-xs text-gray-500">Recommended: ICO or PNG, 32x32px</p>
            </div>
        </div>
    </div>

    <!-- SEO Settings -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
            <h3 class="text-lg font-semibold text-gray-900">SEO Settings</h3>
        </div>
        <div class="p-6 space-y-6">
            <!-- Meta Title -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Default Meta Title</label>
                <input type="text" name="settings[meta_title]" 
                    value="{{ $getSetting('seo', 'meta_title') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Your Site - Tagline">
            </div>

            <!-- Meta Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Default Meta Description</label>
                <textarea name="settings[meta_description]" rows="3"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Default description for your website">{{ $getSetting('seo', 'meta_description') }}</textarea>
            </div>

            <!-- Meta Keywords -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Default Meta Keywords</label>
                <input type="text" name="settings[meta_keywords]" 
                    value="{{ $getSetting('seo', 'meta_keywords') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="keyword1, keyword2, keyword3">
            </div>
        </div>
    </div>

    <!-- Analytics -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-yellow-50 to-orange-50">
            <h3 class="text-lg font-semibold text-gray-900">Analytics & Tracking</h3>
        </div>
        <div class="p-6 space-y-6">
            <!-- Google Analytics -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Google Analytics ID</label>
                <input type="text" name="settings[google_analytics_id]" 
                    value="{{ $getSetting('analytics', 'google_analytics_id') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="G-XXXXXXXXXX or UA-XXXXXXXXX-X">
            </div>

            <!-- Google Tag Manager -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Google Tag Manager ID</label>
                <input type="text" name="settings[google_tag_manager_id]" 
                    value="{{ $getSetting('analytics', 'google_tag_manager_id') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="GTM-XXXXXXX">
            </div>

            <!-- Facebook Pixel -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Facebook Pixel ID</label>
                <input type="text" name="settings[facebook_pixel_id]" 
                    value="{{ $getSetting('analytics', 'facebook_pixel_id') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="XXXXXXXXXXXXXXX">
            </div>
        </div>
    </div>

    <!-- Social Media -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-pink-50 to-rose-50">
            <h3 class="text-lg font-semibold text-gray-900">Social Media Links</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Facebook -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    Facebook
                </label>
                <input type="url" name="settings[facebook_url]" 
                    value="{{ $getSetting('social', 'facebook_url') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="https://facebook.com/yourpage">
            </div>

            <!-- Instagram -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    Instagram
                </label>
                <input type="url" name="settings[instagram_url]" 
                    value="{{ $getSetting('social', 'instagram_url') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="https://instagram.com/yourprofile">
            </div>

            <!-- Twitter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    Twitter/X
                </label>
                <input type="url" name="settings[twitter_url]" 
                    value="{{ $getSetting('social', 'twitter_url') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="https://twitter.com/yourhandle">
            </div>

            <!-- Telegram -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                    Telegram
                </label>
                <input type="url" name="settings[telegram_url]" 
                    value="{{ $getSetting('social', 'telegram_url') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="https://t.me/yourchannel">
            </div>

            <!-- WhatsApp -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                    WhatsApp
                </label>
                <input type="text" name="settings[whatsapp_number]" 
                    value="{{ $getSetting('social', 'whatsapp_number') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="+62812345678">
            </div>

            <!-- YouTube -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    YouTube
                </label>
                <input type="url" name="settings[youtube_url]" 
                    value="{{ $getSetting('social', 'youtube_url') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="https://youtube.com/@yourchannel">
            </div>
        </div>
    </div>

    <!-- Email Configuration -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-red-50 to-orange-50">
            <h3 class="text-lg font-semibold text-gray-900">Email Configuration</h3>
            <p class="text-sm text-gray-600 mt-1">Configure email settings for contact form and notifications</p>
        </div>
        <div class="p-6 space-y-6">
            <!-- Enable Contact Form -->
            <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg">
                <div>
                    <label class="block text-sm font-medium text-gray-900">Enable Contact Form</label>
                    <p class="text-xs text-gray-600 mt-1">Allow visitors to send messages through contact form</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="settings[contact_form_enabled]" value="1" 
                        {{ $getSetting('email', 'contact_form_enabled') == '1' ? 'checked' : '' }}
                        class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                </label>
            </div>

            <div class="border-t border-gray-200 pt-6">
                <h4 class="text-md font-semibold text-gray-900 mb-4">SMTP Configuration</h4>
                
                <!-- Mail Driver -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mail Driver</label>
                    <select name="settings[mail_driver]" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="smtp" {{ $getSetting('email', 'mail_driver') == 'smtp' ? 'selected' : '' }}>SMTP (Gmail, Outlook, etc.)</option>
                        <option value="sendmail" {{ $getSetting('email', 'mail_driver') == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                        <option value="mailgun" {{ $getSetting('email', 'mail_driver') == 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                        <option value="ses" {{ $getSetting('email', 'mail_driver') == 'ses' ? 'selected' : '' }}>Amazon SES</option>
                        <option value="postmark" {{ $getSetting('email', 'mail_driver') == 'postmark' ? 'selected' : '' }}>Postmark</option>
                        <option value="log" {{ $getSetting('email', 'mail_driver') == 'log' ? 'selected' : '' }}>Log (Testing Only)</option>
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Choose your email service provider</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Mail Host -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mail Host</label>
                        <input type="text" name="settings[mail_host]" 
                            value="{{ $getSetting('email', 'mail_host') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="smtp.gmail.com">
                        <p class="mt-1 text-xs text-gray-500">Gmail: smtp.gmail.com, Outlook: smtp.office365.com</p>
                    </div>

                    <!-- Mail Port -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mail Port</label>
                        <input type="number" name="settings[mail_port]" 
                            value="{{ $getSetting('email', 'mail_port') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="587">
                        <p class="mt-1 text-xs text-gray-500">TLS: 587, SSL: 465</p>
                    </div>
                </div>

                <!-- Mail Username -->
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mail Username</label>
                    <input type="text" name="settings[mail_username]" 
                        value="{{ $getSetting('email', 'mail_username') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="your-email@gmail.com">
                    <p class="mt-1 text-xs text-gray-500">Email untuk SMTP authentication dan penerima notifikasi contact form</p>
                </div>

                <!-- Mail Password -->
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mail Password</label>
                    <input type="password" name="settings[mail_password]" 
                        value="{{ $getSetting('email', 'mail_password') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="••••••••••••••••">
                    <p class="mt-1 text-xs text-gray-500">For Gmail, use App Password (not your regular password)</p>
                </div>

                <!-- Mail Encryption -->
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mail Encryption</label>
                    <select name="settings[mail_encryption]" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="tls" {{ $getSetting('email', 'mail_encryption') == 'tls' ? 'selected' : '' }}>TLS (Recommended)</option>
                        <option value="ssl" {{ $getSetting('email', 'mail_encryption') == 'ssl' ? 'selected' : '' }}>SSL</option>
                        <option value="none" {{ $getSetting('email', 'mail_encryption') == 'none' ? 'selected' : '' }}>None</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <!-- Mail From Address -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mail From Address</label>
                        <input type="email" name="settings[mail_from_address]" 
                            value="{{ $getSetting('email', 'mail_from_address') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="noreply@example.com">
                        <p class="mt-1 text-xs text-gray-500">Default sender email address</p>
                    </div>

                    <!-- Mail From Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mail From Name</label>
                        <input type="text" name="settings[mail_from_name]" 
                            value="{{ $getSetting('email', 'mail_from_name') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Your Company Name">
                        <p class="mt-1 text-xs text-gray-500">Default sender name</p>
                    </div>
                </div>
            </div>

            <!-- Gmail Setup Instructions -->
            <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <h5 class="text-sm font-semibold text-yellow-900 mb-2">📧 Gmail Setup Instructions:</h5>
                <ol class="text-xs text-yellow-800 space-y-1 list-decimal list-inside">
                    <li>Go to your Google Account settings</li>
                    <li>Enable 2-Step Verification</li>
                    <li>Go to Security → App passwords</li>
                    <li>Generate an App Password for "Mail"</li>
                    <li>Use that 16-character password in the Mail Password field above</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Hero Section Settings -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-cyan-50 to-blue-50">
            <h3 class="text-lg font-semibold text-gray-900">Hero Section</h3>
            <p class="text-sm text-gray-600 mt-1">Kelola konten hero section di halaman home</p>
        </div>
        <div class="p-6 space-y-6">
            <!-- Hero Title -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Hero Title</label>
                <input type="text" name="settings[hero_title]" 
                    value="{{ $getSetting('hero', 'hero_title') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Kelola Bisnis Pulsa Anda dengan Mudah">
                <p class="mt-1 text-xs text-gray-500">Judul utama di hero section</p>
            </div>

            <!-- Hero Subtitle -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Hero Subtitle</label>
                <textarea name="settings[hero_subtitle]" rows="3"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Deskripsi singkat tentang produk atau layanan Anda...">{{ $getSetting('hero', 'hero_subtitle') }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Deskripsi di bawah judul hero</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Hero Button Text -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hero Button Text</label>
                    <input type="text" name="settings[hero_button_text]" 
                        value="{{ $getSetting('hero', 'hero_button_text') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Download di Google Play">
                    <p class="mt-1 text-xs text-gray-500">Teks tombol utama</p>
                </div>

                <!-- Hero Button URL -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hero Button URL</label>
                    <input type="url" name="settings[hero_button_url]" 
                        value="{{ $getSetting('hero', 'hero_button_url') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="https://play.google.com/store">
                    <p class="mt-1 text-xs text-gray-500">Link tombol utama</p>
                </div>
            </div>

            <!-- Hero Badge Text -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Hero Badge Text</label>
                <input type="text" name="settings[hero_badge_text]" 
                    value="{{ $getSetting('hero', 'hero_badge_text') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Tersedia di Android & iOS">
                <p class="mt-1 text-xs text-gray-500">Text untuk badge di hero section</p>
            </div>

            <!-- Hero Secondary Button Text -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Hero Secondary Button Text</label>
                <input type="text" name="settings[hero_button_secondary_text]" 
                    value="{{ $getSetting('hero', 'hero_button_secondary_text') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Pelajari Fitur">
                <p class="mt-1 text-xs text-gray-500">Text untuk tombol sekunder di hero section</p>
            </div>

            <!-- Hero Image -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Hero Image (Screenshot App)</label>
                @if($getSetting('hero', 'hero_image'))
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $getSetting('hero', 'hero_image')) }}" 
                        alt="Hero Image" class="h-32 object-contain rounded-lg border border-gray-200">
                </div>
                @endif
                <input type="file" name="settings[hero_image]" accept="image/*"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <p class="mt-1 text-xs text-gray-500">Screenshot aplikasi di hero section (Ukuran ideal: 350x700px, format portrait)</p>
            </div>
        </div>
    </div>

    <!-- About Page Settings -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
            <h3 class="text-lg font-semibold text-gray-900">About Page Settings</h3>
        </div>
        <div class="p-6 space-y-6">
            <!-- About Statistics -->
            <div class="border-b border-gray-200 pb-6">
                <h4 class="text-md font-semibold text-gray-900 mb-4">Statistik About Page</h4>
                
                <!-- Statistik 1 -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Statistik 1 - Angka</label>
                        <input type="text" name="settings[about_stat_1_number]" 
                            value="{{ $getSetting('about', 'about_stat_1_number') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="50K+">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Statistik 1 - Label</label>
                        <input type="text" name="settings[about_stat_1_label]" 
                            value="{{ $getSetting('about', 'about_stat_1_label') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Agen Aktif">
                    </div>
                </div>

                <!-- Statistik 2 -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Statistik 2 - Angka</label>
                        <input type="text" name="settings[about_stat_2_number]" 
                            value="{{ $getSetting('about', 'about_stat_2_number') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="1M+">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Statistik 2 - Label</label>
                        <input type="text" name="settings[about_stat_2_label]" 
                            value="{{ $getSetting('about', 'about_stat_2_label') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Transaksi/Bulan">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Settings -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-slate-50">
            <h3 class="text-lg font-semibold text-gray-900">Footer Settings</h3>
        </div>
        <div class="p-6 space-y-6">
            <!-- Footer Text -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Footer Copyright Text</label>
                <input type="text" name="settings[footer_text]" 
                    value="{{ $getSetting('footer', 'footer_text') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="© 2026 Your Company. All rights reserved.">
            </div>

            <!-- Footer About -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Footer About Text</label>
                <textarea name="settings[footer_about]" rows="4"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Brief description about your company...">{{ $getSetting('footer', 'footer_about') }}</textarea>
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="flex gap-3">
        <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all font-medium shadow-sm">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Save All Settings
        </button>
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all font-medium">
            Cancel
        </a>
    </div>
</form>
@endsection
