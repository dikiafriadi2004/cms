@extends('errors::layout')

@section('title', '404 - Halaman Tidak Ditemukan')

@section('content')
    <div class="error-code">404</div>
    <h1 class="error-title">Halaman Tidak Ditemukan</h1>
    <p class="error-message">
        Maaf, halaman yang Anda cari tidak dapat ditemukan. 
        Mungkin halaman telah dipindahkan atau URL yang Anda masukkan salah.
    </p>
    
    <a href="{{ route('home') }}" class="btn-home">
        <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
        </svg>
        Kembali ke Beranda
    </a>
    
    <div class="error-links">
        <p style="color: #718096; margin-bottom: 0.5rem;">Atau coba halaman lain:</p>
        <a href="{{ route('blog.index') }}">Blog</a>
        <a href="{{ route('contact.show') }}">Kontak</a>
        @auth
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        @endauth
    </div>
@endsection
