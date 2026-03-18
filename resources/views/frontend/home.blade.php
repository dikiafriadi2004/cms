@extends('frontend.layouts.frontend')

@section('title', $settings['meta_title'] ?? (($settings['site_name'] ?? config('app.name')) . ($settings['site_description'] ? ' - ' . $settings['site_description'] : '')))
@section('description', $settings['meta_description'] ?? $settings['site_description'] ?? '')

@push('structured-data')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebSite",
    "name": "{{ addslashes($settings['site_name'] ?? config('app.name')) }}",
    "description": "{{ addslashes($settings['site_description'] ?? '') }}",
    "url": "{{ url('/') }}",
    "potentialAction": {
        "@type": "SearchAction",
        "target": {
            "@type": "EntryPoint",
            "urlTemplate": "{{ route('blog.index') }}?search={search_term_string}"
        },
        "query-input": "required name=search_term_string"
    }
    @if(isset($settings['logo']) && $settings['logo'])
    ,"logo": {
        "@type": "ImageObject",
        "url": "{{ storage_url($settings['logo']) }}"
    }
    @endif
}
</script>
@if(isset($settings['contact_email']) || isset($settings['contact_phone']))
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "{{ addslashes($settings['site_name'] ?? config('app.name')) }}",
    "url": "{{ url('/') }}"
    @if(isset($settings['contact_email']) && $settings['contact_email'])
    ,"email": "{{ $settings['contact_email'] }}"
    @endif
    @if(isset($settings['contact_phone']) && $settings['contact_phone'])
    ,"telephone": "{{ $settings['contact_phone'] }}"
    @endif
    @if(isset($settings['contact_address']) && $settings['contact_address'])
    ,"address": {
        "@type": "PostalAddress",
        "streetAddress": "{{ addslashes($settings['contact_address']) }}"
    }
    @endif
    @if(isset($settings['logo']) && $settings['logo'])
    ,"logo": "{{ storage_url($settings['logo']) }}"
    @endif
}
</script>
@endif
@endpush

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
