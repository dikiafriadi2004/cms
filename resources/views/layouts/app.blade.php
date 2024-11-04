<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
    <!-- BEGIN: Head -->
    <head>
        <meta charset="utf-8">
        <link href="{{ asset('backend/dist/images/logo.svg') }}" rel="shortcut icon">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} @yield('title')</title>
        <!-- BEGIN: CSS Assets-->
        <link rel="stylesheet" href="{{ asset('backend/dist/css/app.css') }}" />
        @stack('css')
        <!-- END: CSS Assets-->
    </head>
    <!-- END: Head -->
    <body class="main">
        <!-- BEGIN: Mobile Menu -->
        @include('layouts.mobile-menu')
        <!-- END: Mobile Menu -->
        <!-- BEGIN: Top Bar -->
        @include('layouts.navbar')
        
        <!-- END: Top Bar -->
        <div class="wrapper">
            <div class="wrapper-box">
                <!-- BEGIN: Side Menu -->
                @include('layouts.sidebar')
                <!-- END: Side Menu -->
                <!-- BEGIN: Content -->
                @yield('content')
                <!-- END: Content -->
            </div>
        </div>
        
        <!-- BEGIN: JS Assets-->
        <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=["api"]&libraries=places"></script>
        <script src="backend/dist/js/app.js"></script>
        @stack('js')
        <!-- END: JS Assets-->
    </body>
</html>