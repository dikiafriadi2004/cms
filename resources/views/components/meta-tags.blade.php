@props(['post' => null, 'page' => null])

@php
    $item = $post ?? $page;
    $openGraph = $item->open_graph ?? [];
    $twitterCard = $item->twitter_card ?? [];
@endphp

{{-- Open Graph Meta Tags --}}
@foreach($openGraph as $property => $content)
    @if(is_array($content))
        @foreach($content as $value)
            <meta property="{{ $property }}" content="{{ $value }}">
        @endforeach
    @else
        <meta property="{{ $property }}" content="{{ $content }}">
    @endif
@endforeach

{{-- Twitter Card Meta Tags --}}
@foreach($twitterCard as $name => $content)
    <meta name="{{ $name }}" content="{{ $content }}">
@endforeach
