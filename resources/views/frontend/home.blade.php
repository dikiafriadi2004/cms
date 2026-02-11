@extends('frontend.layouts.frontend')

@section('title', $settings['meta_title'] ?? $settings['site_name'] ?? 'Konter Digital CMS')
@section('description', $settings['meta_description'] ?? $settings['site_description'] ?? '')

@section('content')
@if(isset($homepage))
    <div class="pt-32 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-6">{{ $homepage->title }}</h1>
        <div class="prose max-w-none">{!! $homepage->content !!}</div>
    </div>
@else
    @include('frontend.partials.landing-content')
@endif
@endsection
