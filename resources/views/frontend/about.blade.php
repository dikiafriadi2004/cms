@extends('frontend.layouts.standalone')

@section('title', 'Tentang Kami - ' . ($settings['site_name'] ?? 'Konter Digital'))
@section('description', 'Pelajari lebih lanjut tentang ' . ($settings['site_name'] ?? 'Konter Digital') . ' - Server Pulsa Terpercaya di Indonesia')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-8 py-16">
        <!-- Company Overview -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-10 mb-12">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="p-6">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Siapa Kami</h2>
                    <p class="text-gray-600 text-lg leading-relaxed mb-4">
                        {{ $settings['site_name'] ?? 'Konter Digital' }} adalah server pulsa dan PPOB (Payment Point Online Bank) terpercaya yang telah melayani ribuan mitra di seluruh Indonesia sejak tahun 2015.
                    </p>
                    <p class="text-gray-600 text-lg leading-relaxed mb-4">
                        Kami menyediakan layanan pengisian pulsa all operator, paket data internet, token listrik PLN, voucher game, pembayaran BPJS, tagihan listrik, PDAM, dan berbagai produk digital lainnya dengan harga termurah dan proses transaksi yang cepat.
                    </p>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Dengan sistem yang stabil, customer service yang responsif 24/7, dan deposit yang mudah, kami berkomitmen untuk menjadi mitra terbaik dalam mengembangkan bisnis pulsa dan PPOB Anda.
                    </p>
                </div>
                <div class="relative p-6">
                    <div class="aspect-square rounded-2xl bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center p-8">
                        @if(!empty($settings['logo']))
                            <img src="{{ asset('storage/' . $settings['logo']) }}" alt="{{ $settings['site_name'] ?? 'Logo' }}" class="max-w-full max-h-full object-contain">
                        @else
                            <div class="text-center">
                                <svg class="w-32 h-32 mx-auto text-blue-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-2xl font-bold text-gray-900">{{ $settings['site_name'] ?? 'Konter Digital' }}</p>
                                <p class="text-sm text-gray-600 mt-2">Server Pulsa Terpercaya</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Keunggulan Kami -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-10 mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Keunggulan Kami</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Harga Termurah -->
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Harga Termurah</h4>
                    <p class="text-gray-600">Kami menjamin harga produk paling kompetitif di pasaran dengan margin keuntungan yang menguntungkan untuk mitra.</p>
                </div>

                <!-- Transaksi Cepat -->
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Transaksi Cepat</h4>
                    <p class="text-gray-600">Proses transaksi rata-rata hanya 5-10 detik dengan sistem otomatis yang handal dan stabil 24 jam non-stop.</p>
                </div>

                <!-- CS 24 Jam -->
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">CS 24 Jam</h4>
                    <p class="text-gray-600">Customer service kami siap membantu Anda kapan saja melalui WhatsApp, Telegram, dan Live Chat.</p>
                </div>

                <!-- Deposit Mudah -->
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Deposit Mudah</h4>
                    <p class="text-gray-600">Tersedia berbagai metode deposit via transfer bank, e-wallet, dan QRIS dengan proses otomatis yang cepat.</p>
                </div>

                <!-- Produk Lengkap -->
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Produk Lengkap</h4>
                    <p class="text-gray-600">Menyediakan pulsa all operator, paket data, token PLN, voucher game, BPJS, dan pembayaran tagihan lengkap.</p>
                </div>

                <!-- Sistem Stabil -->
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Sistem Stabil</h4>
                    <p class="text-gray-600">Server dengan uptime 99.9% dan sistem backup otomatis untuk menjamin kelancaran transaksi Anda.</p>
                </div>
            </div>
        </div>

        <!-- Mission & Vision -->
        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <!-- Mission -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Misi Kami</h3>
                <p class="text-gray-600 leading-relaxed">
                    Memberikan layanan server pulsa dan PPOB terbaik dengan harga termurah, transaksi tercepat, dan sistem yang stabil untuk membantu mitra mengembangkan bisnis mereka dengan maksimal.
                </p>
            </div>

            <!-- Vision -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                <div class="w-16 h-16 bg-indigo-100 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Visi Kami</h3>
                <p class="text-gray-600 leading-relaxed">
                    Menjadi server pulsa dan PPOB nomor 1 di Indonesia yang terpercaya, dengan jaringan mitra terbesar dan sistem teknologi paling canggih dalam industri distribusi produk digital.
                </p>
            </div>
        </div>

        <!-- Produk Kami -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-10 mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Produk & Layanan</h2>
            <div class="grid md:grid-cols-4 gap-6">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 text-center">
                    <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-2">Pulsa All Operator</h4>
                    <p class="text-sm text-gray-600">Telkomsel, Indosat, XL, Tri, Axis, Smartfren</p>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 text-center">
                    <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-2">Paket Data Internet</h4>
                    <p class="text-sm text-gray-600">Paket data murah semua operator</p>
                </div>

                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-6 text-center">
                    <div class="w-12 h-12 bg-yellow-600 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-2">Token Listrik PLN</h4>
                    <p class="text-sm text-gray-600">Token PLN prabayar instan</p>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 text-center">
                    <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-2">Voucher Game</h4>
                    <p class="text-sm text-gray-600">Mobile Legends, Free Fire, PUBG, dll</p>
                </div>

                <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-6 text-center">
                    <div class="w-12 h-12 bg-red-600 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-2">Pembayaran BPJS</h4>
                    <p class="text-sm text-gray-600">BPJS Kesehatan & Ketenagakerjaan</p>
                </div>

                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl p-6 text-center">
                    <div class="w-12 h-12 bg-indigo-600 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-2">Tagihan Listrik</h4>
                    <p class="text-sm text-gray-600">Bayar tagihan PLN pascabayar</p>
                </div>

                <div class="bg-gradient-to-br from-cyan-50 to-cyan-100 rounded-xl p-6 text-center">
                    <div class="w-12 h-12 bg-cyan-600 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-2">Tagihan PDAM</h4>
                    <p class="text-sm text-gray-600">Pembayaran air PDAM seluruh Indonesia</p>
                </div>

                <div class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-xl p-6 text-center">
                    <div class="w-12 h-12 bg-pink-600 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-2">E-Money & E-Wallet</h4>
                    <p class="text-sm text-gray-600">GoPay, OVO, DANA, ShopeePay, dll</p>
                </div>
            </div>
        </div>

        <!-- Contact CTA -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl shadow-xl p-12 text-center text-white">
            <h2 class="text-3xl font-bold mb-4">Bergabung Bersama Kami</h2>
            <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                Daftar sekarang dan dapatkan bonus saldo deposit pertama! Raih keuntungan maksimal dengan menjadi mitra server pulsa terpercaya.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('contact.show') }}" class="inline-flex items-center px-8 py-3 bg-white text-blue-600 rounded-full font-semibold hover:bg-gray-100 transition-colors shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    Hubungi Kami
                </a>
                <a href="{{ route('blog.index') }}" class="inline-flex items-center px-8 py-3 bg-transparent border-2 border-white text-white rounded-full font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    Baca Artikel
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
