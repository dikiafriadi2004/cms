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
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings['google_analytics_id'] }}"></script>
    <script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','{{ $settings['google_analytics_id'] }}');</script>
    @endif
    
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
    
    @stack('scripts')
</body>
</html>
