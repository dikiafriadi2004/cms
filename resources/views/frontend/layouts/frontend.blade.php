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

    @if(isset($settings['google_tag_manager_id']) && $settings['google_tag_manager_id'])
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','{{ $settings['google_tag_manager_id'] }}');</script>
    @endif

    @if(isset($settings['facebook_pixel_id']) && $settings['facebook_pixel_id'])
    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '{{ $settings['facebook_pixel_id'] }}');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id={{ $settings['facebook_pixel_id'] }}&ev=PageView&noscript=1"
    /></noscript>
    @endif
    
    <!-- Animations CSS & JS (No Vite) -->
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    
    @stack('styles')
</head>
<body class="bg-white text-slate-900 antialiased">
    @if(isset($settings['google_tag_manager_id']) && $settings['google_tag_manager_id'])
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $settings['google_tag_manager_id'] }}"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif

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
