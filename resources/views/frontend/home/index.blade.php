@extends('frontend.layouts.app')

@section('title')
    {{ $page->title }}
@endsection

@push('css')
<div>{!! $page->style_code !!}</div>
@endpush

@section('content')
<x-render-html :html="$page->html_code" :data="$data" />
@endsection

@push('js')
<div>{!! $page->js_code !!}</div>
@endpush
