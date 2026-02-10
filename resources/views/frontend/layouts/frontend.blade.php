<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $settings['site_name'] ?? 'Konter Digital CMS')</title>
    <meta name="description" content="@yield('description', $settings['site_description'] ?? '')">
    @if(!empty($settings['favicon']))
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $settings['favicon']) }}">
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-white">
    <!-- Navbar -->
    <nav class="fixed w-full bg-white/95 backdrop-blur-sm shadow-sm z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center">
                        @if(!empty($settings['logo']))
                            <img src="{{ asset('storage/' . $settings['logo']) }}" alt="{{ $settings['site_name'] ?? 'Logo' }}" class="h-10 w-auto">
                        @else
                            <span class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">{{ $settings['site_name'] ?? 'Konter Digital' }}</span>
                        @endif
                    </a>
                </div>
                <div class="hidden md:flex md:items-center md:space-x-8">
                    @if($headerMenu && $headerMenu->items)
                        @foreach($headerMenu->items as $item)
                            @if($item->is_active)
                                @if($item->children->count() > 0)
                                    <div class="relative group">
                                        <button class="text-gray-700 hover:text-purple-600 px-3 py-2 text-sm font-medium transition-colors flex items-center">{{ $item->title }}<svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></button>
                                        <div class="absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                            @foreach($item->children as $child)
                                                @if($child->is_active)
                                                    <a href="{{ $child->url }}" target="{{ $child->target }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600 first:rounded-t-lg last:rounded-b-lg">{{ $child->title }}</a>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <a href="{{ $item->url }}" target="{{ $item->target }}" class="text-gray-700 hover:text-purple-600 px-3 py-2 text-sm font-medium transition-colors">{{ $item->title }}</a>
                                @endif
                            @endif
                        @endforeach
                    @else
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-purple-600 px-3 py-2 text-sm font-medium">Home</a>
                        <a href="{{ route('blog.index') }}" class="text-gray-700 hover:text-purple-600 px-3 py-2 text-sm font-medium">Blog</a>
                    @endif
                    <a href="https://play.google.com/store" target="_blank" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-6 py-2 rounded-full text-sm font-medium hover:shadow-lg transition-all duration-300">Download App</a>
                </div>
                <div class="md:hidden">
                    <button type="button" id="mobile-menu-button" class="text-gray-700 hover:text-purple-600 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
            <div class="px-2 pt-2 pb-3 space-y-1">
                @if($headerMenu && $headerMenu->items)
                    @foreach($headerMenu->items as $item)
                        @if($item->is_active)
                            <a href="{{ $item->url }}" target="{{ $item->target }}" class="block text-gray-700 hover:bg-purple-50 hover:text-purple-600 px-3 py-2 text-base font-medium rounded-md">{{ $item->title }}</a>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="mb-4">
                        @if(isset($settings['logo']) && $settings['logo'])
                            <img src="{{ asset('storage/' . $settings['logo']) }}" alt="{{ $settings['site_name'] ?? 'Logo' }}" class="h-10 w-auto">
                        @else
                            <span class="text-2xl font-bold">{{ $settings['site_name'] ?? 'Konter Digital' }}</span>
                        @endif
                    </div>
                    <p class="text-gray-400 mb-4">{{ $settings['footer_about'] ?? $settings['site_description'] ?? '' }}</p>
                    <div class="flex space-x-4">
                        @if(isset($settings['facebook_url']) && $settings['facebook_url'])
                            <a href="{{ $settings['facebook_url'] }}" target="_blank" class="text-gray-400 hover:text-white transition-colors"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                        @endif
                        @if(isset($settings['instagram_url']) && $settings['instagram_url'])
                            <a href="{{ $settings['instagram_url'] }}" target="_blank" class="text-gray-400 hover:text-white transition-colors"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                        @endif
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        @if($footerMenu && $footerMenu->items)
                            @foreach($footerMenu->items as $item)
                                @if($item->is_active)
                                    <li><a href="{{ $item->url }}" target="{{ $item->target }}" class="text-gray-400 hover:text-white transition-colors">{{ $item->title }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact Us</h3>
                    <ul class="space-y-2 text-gray-400">
                        @if(isset($settings['contact_email']) && $settings['contact_email'])
                            <li class="flex items-start"><svg class="w-5 h-5 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg><span>{{ $settings['contact_email'] }}</span></li>
                        @endif
                        @if(isset($settings['contact_phone']) && $settings['contact_phone'])
                            <li class="flex items-start"><svg class="w-5 h-5 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg><span>{{ $settings['contact_phone'] }}</span></li>
                        @endif
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Download App</h3>
                    <p class="text-gray-400 mb-4">Dapatkan aplikasi kami sekarang</p>
                    <a href="https://play.google.com/store" target="_blank" class="inline-flex items-center bg-white text-gray-900 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M3,20.5V3.5C3,2.91 3.34,2.39 3.84,2.15L13.69,12L3.84,21.85C3.34,21.6 3,21.09 3,20.5M16.81,15.12L6.05,21.34L14.54,12.85L16.81,15.12M20.16,10.81C20.5,11.08 20.75,11.5 20.75,12C20.75,12.5 20.5,12.92 20.16,13.19L17.89,14.5L15.39,12L17.89,9.5L20.16,10.81M6.05,2.66L16.81,8.88L14.54,11.15L6.05,2.66Z"/></svg>
                        Google Play
                    </a>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-sm mb-4 md:mb-0">&copy; {{ date('Y') }} {{ $settings['site_name'] ?? 'Konter Digital CMS' }}. All rights reserved.</p>
                    <p class="text-gray-400 text-sm">Powered by <span class="font-semibold text-white">Konter Digital CMS</span></p>
                </div>
            </div>
        </div>
    </footer>

    <script>
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
    </script>
</body>
</html>
