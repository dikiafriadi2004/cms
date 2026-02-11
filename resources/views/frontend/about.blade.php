@extends('frontend.layouts.frontend')

@section('title', 'Tentang Kami - ' . ($settings['site_name'] ?? 'Konter Digital'))
@section('description', 'Mendigitalkan Ekonomi Indonesia - Platform server pulsa terbaik untuk UMKM di Indonesia')

@section('content')
<!-- Hero Section -->
<section class="pt-44 pb-24 bg-gradient-to-b from-brand-50 to-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-16">
            <div class="lg:w-1/2 space-y-8">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-brand-100 rounded-full shadow-sm">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-brand-600"></span>
                    </span>
                    <span class="text-xs font-bold text-brand-900 uppercase tracking-widest">Masa Depan UMKM</span>
                </div>
                
                <h1 class="text-4xl md:text-6xl font-extrabold text-brand-900 leading-[1.1]">
                    Mendigitalkan <br> Ekonomi Indonesia
                </h1>
                
                <p class="text-slate-500 text-lg leading-relaxed">
                    {{ $settings['site_name'] ?? 'Konter Digital' }} lahir dari mimpi sederhana: Memberikan akses teknologi transaksi termudah bagi setiap pemilik konter dan UMKM di pelosok negeri.
                </p>
                
                <div class="flex items-center gap-10 pt-4 border-t border-slate-100">
                    <div>
                        <p class="text-3xl font-extrabold text-brand-600">{{ $settings['about_stat_1_number'] ?? '50K+' }}</p>
                        <p class="text-sm font-medium text-slate-400">{{ $settings['about_stat_1_label'] ?? 'Agen Aktif' }}</p>
                    </div>
                    <div>
                        <p class="text-3xl font-extrabold text-brand-600">{{ $settings['about_stat_2_number'] ?? '1M+' }}</p>
                        <p class="text-sm font-medium text-slate-400">{{ $settings['about_stat_2_label'] ?? 'Transaksi/Bulan' }}</p>
                    </div>
                </div>
            </div>
            
            <div class="lg:w-1/2 relative">
                <div class="absolute -top-10 -right-10 w-64 h-64 bg-brand-200/50 rounded-full blur-3xl opacity-50"></div>
                @if(isset($settings['about_image']) && $settings['about_image'])
                    <img src="{{ asset('storage/' . $settings['about_image']) }}" 
                         class="relative rounded-[3rem] shadow-2xl border-8 border-white" 
                         alt="Team Work">
                @else
                    <img src="https://images.unsplash.com/photo-1556742502-ec7c0e9f34b1?auto=format&fit=crop&q=80&w=800" 
                         class="relative rounded-[3rem] shadow-2xl border-8 border-white" 
                         alt="Team Work">
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="p-10 bg-slate-50 rounded-[2.5rem] border border-slate-100 group hover:bg-brand-600 transition-all duration-500">
                <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-sm mb-8 group-hover:scale-110 transition duration-500">
                    <svg class="w-8 h-8 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-brand-900 mb-4 group-hover:text-white transition">Kecepatan Tinggi</h3>
                <p class="text-slate-500 leading-relaxed group-hover:text-brand-50 transition">
                    Sistem kami dibangun di atas infrastruktur cloud terbaru untuk menjamin transaksi pulsa sukses dalam hitungan detik.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="p-10 bg-slate-50 rounded-[2.5rem] border border-slate-100 group hover:bg-brand-600 transition-all duration-500">
                <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-sm mb-8 group-hover:scale-110 transition duration-500">
                    <svg class="w-8 h-8 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-brand-900 mb-4 group-hover:text-white transition">Keamanan Berlapis</h3>
                <p class="text-slate-500 leading-relaxed group-hover:text-brand-50 transition">
                    Data dan saldo Anda adalah prioritas utama. Kami menggunakan enkripsi standar industri perbankan.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="p-10 bg-slate-50 rounded-[2.5rem] border border-slate-100 group hover:bg-brand-600 transition-all duration-500">
                <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-sm mb-8 group-hover:scale-110 transition duration-500">
                    <svg class="w-8 h-8 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-brand-900 mb-4 group-hover:text-white transition">Harga Transparan</h3>
                <p class="text-slate-500 leading-relaxed group-hover:text-brand-50 transition">
                    Tidak ada biaya tersembunyi. Apa yang Anda lihat di aplikasi adalah apa yang Anda bayar, tanpa potongan mendadak.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-brand-900 rounded-[3.5rem] p-12 md:p-20 text-center relative overflow-hidden shadow-2xl">
        <div class="absolute top-0 left-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        
        <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-8 relative z-10 leading-tight">
            Siap Tumbuh Bersama <br> {{ $settings['site_name'] ?? 'Konter Digital' }}?
        </h2>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center relative z-10">
            <a href="{{ $settings['hero_button_url'] ?? '#' }}" 
               class="px-10 py-5 bg-brand-600 text-white font-bold rounded-2xl hover:bg-brand-700 transition shadow-xl shadow-brand-600/20">
                Daftar Sekarang
            </a>
            <a href="{{ route('contact.show') }}" 
               class="px-10 py-5 bg-white/10 text-white font-bold rounded-2xl hover:bg-white/20 transition backdrop-blur-sm border border-white/10">
                Hubungi Sales
            </a>
        </div>
    </div>
</section>
@endsection
