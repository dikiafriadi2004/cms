<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Primary Meta Tags -->
    <title>@yield('title', $settings['site_name'] ?? 'Konter Digital CMS')</title>
    <meta name="title" content="@yield('title', $settings['site_name'] ?? 'Konter Digital CMS')">
    <meta name="description" content="@yield('description', $settings['site_description'] ?? '')">
    <meta name="keywords" content="@yield('keywords', $settings['meta_keywords'] ?? '')">
    <meta name="author" content="{{ $settings['site_name'] ?? 'Konter Digital' }}">
    <meta name="robots" content="@yield('robots', 'index, follow')">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', $settings['site_name'] ?? 'Konter Digital CMS')">
    <meta property="og:description" content="@yield('og_description', $settings['site_description'] ?? '')">
    <meta property="og:image" content="@yield('og_image', isset($settings['og_image']) ? storage_url($settings['og_image']) : storage_url(($settings['logo'] ?? 'default-og-image.jpg')))">
    <meta property="og:site_name" content="{{ $settings['site_name'] ?? 'Konter Digital' }}">
    <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('twitter_title', $settings['site_name'] ?? 'Konter Digital CMS')">
    <meta property="twitter:description" content="@yield('twitter_description', $settings['site_description'] ?? '')">
    <meta property="twitter:image" content="@yield('twitter_image', isset($settings['og_image']) ? storage_url($settings['og_image']) : storage_url(($settings['logo'] ?? 'default-og-image.jpg')))">
    @if(isset($settings['twitter_username']) && $settings['twitter_username'])
    <meta property="twitter:site" content="{{ $settings['twitter_username'] }}">
    @endif
    
    <link rel="icon" type="image/png" href="{{ favicon_url() }}">
    <link rel="shortcut icon" type="image/png" href="{{ favicon_url() }}">
    <link rel="apple-touch-icon" href="{{ favicon_url() }}">
    
    @if(isset($settings['google_site_verification']) && $settings['google_site_verification'])
    <meta name="google-site-verification" content="{{ $settings['google_site_verification'] }}" />
    @endif
    
    <!-- Structured Data -->
    @stack('structured-data')
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        brand: {
                            50: '#f5f7ff',
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            900: '#1e1b4b',
                        }
                    }
                }
            }
        }
    </script>
    
    @if(isset($settings['google_analytics_id']) && $settings['google_analytics_id'])
    <!-- Google Analytics (GA4) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings['google_analytics_id'] }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $settings['google_analytics_id'] }}', {
            'send_page_view': true,
            'cookie_flags': 'SameSite=None;Secure'
        });
    </script>
    @endif
    
    <!-- Animations CSS & JS (No Vite) -->
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    
    @stack('styles')
</head>
<body class="bg-white text-slate-900 antialiased">
    @include('frontend.partials.navbar')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    @include('frontend.partials.footer')

    <script>
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
    </script>
    
    <!-- Animations JS (No Vite) -->
    <script src="{{ asset('js/landing-animations.js') }}"></script>
    <script src="{{ asset('js/ad-tracker.js') }}"></script>
    
    @stack('scripts')
</body>
</html>
