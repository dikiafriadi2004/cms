<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
    <!-- BEGIN: Head -->
    <head>
        <meta charset="utf-8">
        <link href="{{ asset('backend/assets/images/logo.svg') }}" rel="shortcut icon">
        <meta name="viewport" content="width=device-width, initial-scale=1"><meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} @yield('title')</title>
        <!-- BEGIN: CSS Assets-->
        <link rel="stylesheet" href="{{ asset('backend/assets/css/app.css') }}" />
        <!-- END: CSS Assets-->
    </head>
    <!-- END: Head -->
    <body class="login">
        <div class="container sm:px-10">
            <div class="block xl:grid grid-cols-2 gap-4">
                <!-- BEGIN: Register Info -->
                <div class="hidden xl:flex flex-col min-h-screen">
                    <a href="" class="-intro-x flex items-center pt-5">
                        <img alt="Midone - HTML Admin Template" class="w-6" src="{{ asset('backend/assets/images/logo.svg') }}">
                        <span class="text-white text-lg ml-3"> Rubick </span> 
                    </a>
                    <div class="my-auto">
                        <img alt="Midone - HTML Admin Template" class="-intro-x w-1/2 -mt-16" src="{{ asset('backend/assets/images/illustration.svg') }}">
                        <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                            A few more clicks to 
                            <br>
                            sign up to your account.
                        </div>
                        <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400">Manage all your e-commerce accounts in one place</div>
                    </div>
                </div>
                <!-- END: Register Info -->
                <!-- BEGIN: Register Form -->
                @yield('content')
                <!-- END: Register Form -->
            </div>
        </div>
        
        <!-- BEGIN: JS Assets-->
        <script src="{{ asset('backend/assets/js/app.js') }}"></script>
        <!-- END: JS Assets-->
    </body>
</html>