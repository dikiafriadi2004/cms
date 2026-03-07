@extends('errors::layout')

@section('title', '500 - Terjadi Kesalahan Server')

@section('content')
    <div class="error-code">500</div>
    <h1 class="error-title">Terjadi Kesalahan Server</h1>
    <p class="error-message">
        Maaf, terjadi kesalahan pada server kami. 
        Tim kami telah diberitahu dan sedang bekerja untuk memperbaikinya.
    </p>
    
    <a href="{{ route('home') }}" class="btn-home">
        <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
        </svg>
        Kembali ke Beranda
    </a>
    
    <div class="error-links">
        <p style="color: #718096; margin-bottom: 0.5rem;">Jika masalah berlanjut, silakan hubungi:</p>
        <a href="{{ route('contact.show') }}">Tim Support</a>
    </div>
@endsection
