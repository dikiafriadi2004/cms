<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('meta_title', $settings['seo_meta_title'] ?? 'Konter Digital CMS')</title>
    <meta name="description" content="@yield('meta_description', $settings['seo_meta_description'] ?? '')">
    <meta name="keywords" content="@yield('meta_keywords', $settings['seo_meta_keywords'] ?? '')">
    
    @if(isset($settings['site_favicon']) && $settings['site_favicon'])
        <link rel="icon" href="{{ $settings['site_favicon'] }}">
    @endif

    <!-- Open Graph -->
    <meta property="og:title" content="@yield('og_title', $settings['site_name'] ?? 'Konter Digital CMS')">
    <meta property="og:description" content="@yield('og_description', $settings['seo_meta_description'] ?? '')">
    <meta property="og:image" content="@yield('og_image', asset('images/default-og.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="@yield('og_type', 'website')">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', $settings['site_name'] ?? 'Konter Digital CMS')">
    <meta name="twitter:description" content="@yield('twitter_description', $settings['seo_meta_description'] ?? '')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/default-og.jpg'))">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')

    <!-- Google Analytics -->
    @if(isset($settings['analytics_google_id']) && $settings['analytics_google_id'])
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings['analytics_google_id'] }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $settings['analytics_google_id'] }}');
    </script>
    @endif

    <!-- Google Tag Manager -->
    @if(isset($settings['analytics_google_tag_manager']) && $settings['analytics_google_tag_manager'])
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','{{ $settings['analytics_google_tag_manager'] }}');</script>
    @endif

    <!-- Facebook Pixel -->
    @if(isset($settings['analytics_facebook_pixel']) && $settings['analytics_facebook_pixel'])
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{ $settings['analytics_facebook_pixel'] }}');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id={{ $settings['analytics_facebook_pixel'] }}&ev=PageView&noscript=1"
    /></noscript>
    @endif
</head>
<body>
    <!-- Header -->
    <header class="bg-white shadow-sm sticky-top">
        <nav class="navbar navbar-expand-lg navbar-light container">
            <a class="navbar-brand" href="{{ route('home') }}">
                @if(isset($settings['site_logo']) && $settings['site_logo'])
                    <img src="{{ $settings['site_logo'] }}" alt="{{ $settings['site_name'] ?? 'Logo' }}" height="40">
                @else
                    <strong>{{ $settings['site_name'] ?? 'Konter Digital CMS' }}</strong>
                @endif
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if($headerMenu && $headerMenu->items)
                        @foreach($headerMenu->items as $item)
                            @if($item->is_active)
                                @if($item->children->count() > 0)
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                            {{ $item->title }}
                                        </a>
                                        <ul class="dropdown-menu">
                                            @foreach($item->children as $child)
                                                @if($child->is_active)
                                                    <li>
                                                        <a class="dropdown-item" href="{{ $child->url }}" target="{{ $child->target }}">
                                                            {{ $child->title }}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ $item->url }}" target="{{ $item->target }}">
                                            {{ $item->title }}
                                        </a>
                                    </li>
                                @endif
                            @endif
                        @endforeach
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('blog.index') }}">Blog</a>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>
    </header>

    <!-- Ads: Header -->
    @php
        $headerAds = \App\Models\Ad::getByPosition('header', ['page' => request()->route()->getName()]);
    @endphp
    @foreach($headerAds as $ad)
        <div class="container my-3">
            {!! $ad->code !!}
        </div>
    @endforeach

    <!-- Main Content -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5>{{ $settings['site_name'] ?? 'Konter Digital CMS' }}</h5>
                    <p class="text-muted">{{ $settings['site_description'] ?? '' }}</p>
                    
                    <!-- Social Media -->
                    <div class="d-flex gap-3 mt-3">
                        @if(isset($settings['social_facebook']) && $settings['social_facebook'])
                            <a href="{{ $settings['social_facebook'] }}" target="_blank" class="text-white">
                                <i class="bi bi-facebook fs-4"></i>
                            </a>
                        @endif
                        @if(isset($settings['social_instagram']) && $settings['social_instagram'])
                            <a href="{{ $settings['social_instagram'] }}" target="_blank" class="text-white">
                                <i class="bi bi-instagram fs-4"></i>
                            </a>
                        @endif
                        @if(isset($settings['social_twitter']) && $settings['social_twitter'])
                            <a href="{{ $settings['social_twitter'] }}" target="_blank" class="text-white">
                                <i class="bi bi-twitter fs-4"></i>
                            </a>
                        @endif
                        @if(isset($settings['social_telegram']) && $settings['social_telegram'])
                            <a href="{{ $settings['social_telegram'] }}" target="_blank" class="text-white">
                                <i class="bi bi-telegram fs-4"></i>
                            </a>
                        @endif
                        @if(isset($settings['social_whatsapp']) && $settings['social_whatsapp'])
                            <a href="https://wa.me/{{ $settings['social_whatsapp'] }}" target="_blank" class="text-white">
                                <i class="bi bi-whatsapp fs-4"></i>
                            </a>
                        @endif
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        @if($footerMenu && $footerMenu->items)
                            @foreach($footerMenu->items as $item)
                                @if($item->is_active)
                                    <li class="mb-2">
                                        <a href="{{ $item->url }}" class="text-muted text-decoration-none" target="{{ $item->target }}">
                                            {{ $item->title }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    </ul>
                </div>
                
                <div class="col-md-4 mb-4">
                    <h5>Contact Us</h5>
                    @if(isset($settings['contact_email']) && $settings['contact_email'])
                        <p class="text-muted">
                            <i class="bi bi-envelope me-2"></i>
                            {{ $settings['contact_email'] }}
                        </p>
                    @endif
                    @if(isset($settings['contact_phone']) && $settings['contact_phone'])
                        <p class="text-muted">
                            <i class="bi bi-phone me-2"></i>
                            {{ $settings['contact_phone'] }}
                        </p>
                    @endif
                    @if(isset($settings['contact_address']) && $settings['contact_address'])
                        <p class="text-muted">
                            <i class="bi bi-geo-alt me-2"></i>
                            {{ $settings['contact_address'] }}
                        </p>
                    @endif
                </div>
            </div>
            
            <hr class="my-4 bg-secondary">
            
            <div class="row">
                <div class="col-md-6">
                    <p class="text-muted mb-0">
                        &copy; {{ date('Y') }} {{ $settings['site_name'] ?? 'Konter Digital CMS' }}. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-muted mb-0">
                        Powered by <strong>Konter Digital CMS</strong>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Ads: Footer -->
    @php
        $footerAds = \App\Models\Ad::getByPosition('footer', ['page' => request()->route()->getName()]);
    @endphp
    @foreach($footerAds as $ad)
        <div class="container my-3">
            {!! $ad->code !!}
        </div>
    @endforeach

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>