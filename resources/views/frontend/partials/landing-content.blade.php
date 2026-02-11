<!-- Header Ads -->
@if(isset($ads['header']) && $ads['header']->count() > 0)
    @foreach($ads['header'] as $ad)
        <div class="w-full">
            {!! $ad->render() !!}
        </div>
    @endforeach
@endif

<!-- Hero Section -->
<section class="relative pt-44 pb-32 overflow-hidden bg-white">
    <div class="absolute top-0 right-0 w-1/3 h-full bg-brand-50/50 rounded-l-[5rem] -z-10 hidden lg:block"></div>
    <div class="absolute top-20 left-10 w-64 h-64 bg-brand-600/5 rounded-full blur-3xl -z-10"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-16">
            <!-- Left Content -->
            <div class="lg:w-1/2 space-y-8 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-brand-50 text-brand-600 rounded-full">
                    <span class="w-2 h-2 bg-brand-600 rounded-full animate-pulse"></span>
                    <span class="text-xs font-bold uppercase tracking-wider">
                        {{ $settings['hero_badge_text'] ?? 'Tersedia di Android & iOS' }}
                    </span>
                </div>
                
                <h1 class="text-5xl md:text-7xl font-extrabold text-brand-900 leading-[1.1]">
                    @php
                        $heroTitle = $settings['hero_title'] ?? 'Kelola Bisnis Digital dalam Satu Genggaman';
                        // Split by line breaks
                        $lines = preg_split('/\r\n|\r|\n/', $heroTitle);
                        $totalLines = count($lines);
                    @endphp
                    @foreach($lines as $index => $line)
                        @if($index === $totalLines - 1)
                            <span class="text-brand-600">{{ $line }}</span>
                        @else
                            {{ $line }}<br>
                        @endif
                    @endforeach
                </h1>
                
                <p class="text-slate-500 text-lg md:text-xl leading-relaxed max-w-xl mx-auto lg:mx-0">
                    {{ $settings['hero_subtitle'] ?? 'Aplikasi Konter Digital dirancang khusus untuk memudahkan Anda bertransaksi pulsa, paket data, hingga PPOB dengan interface yang sangat user-friendly.' }}
                </p>
                
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                    <a href="{{ $settings['hero_button_url'] ?? '#' }}" 
                       class="group px-8 py-5 bg-brand-900 text-white font-bold rounded-2xl hover:bg-brand-800 transition shadow-xl shadow-brand-900/20 flex items-center gap-3">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 20.5V3.5C3 2.9 3.4 2.5 4 2.5C4.2 2.5 4.4 2.6 4.6 2.7L19.3 11.2C19.7 11.4 19.9 11.7 19.9 12.1C19.9 12.5 19.7 12.8 19.3 13L4.6 21.5C4.4 21.6 4.2 21.7 4 21.7C3.4 21.7 3 21.3 3 20.7V20.5Z"/>
                        </svg>
                        {{ $settings['hero_button_text'] ?? 'Download Play Store' }}
                    </a>
                    <a href="#layanan" 
                       class="px-8 py-5 bg-white text-slate-700 font-bold rounded-2xl border border-slate-200 hover:bg-slate-50 transition">
                        {{ $settings['hero_button_secondary_text'] ?? 'Pelajari Fitur' }}
                    </a>
                </div>
            </div>
            
            <!-- Right Content - App Screenshot -->
            <div class="lg:w-1/2 relative flex justify-center items-center">
                <div class="absolute w-[80%] h-[80%] bg-brand-600 rounded-[3rem] rotate-6 opacity-10"></div>
                <div class="absolute w-[80%] h-[80%] border-2 border-brand-600/20 rounded-[3rem] -rotate-3"></div>
                
                <div class="relative z-10 drop-shadow-[0_35px_35px_rgba(79,70,229,0.2)]">
                    @if(isset($settings['hero_image']) && $settings['hero_image'])
                        <img src="{{ asset('storage/' . $settings['hero_image']) }}" 
                             alt="App Screenshot" 
                             class="max-w-[280px] md:max-w-[350px] h-auto rounded-[2.5rem] border-[8px] border-slate-900 shadow-2xl">
                    @else
                        <img src="https://via.placeholder.com/350x700/4f46e5/ffffff?text=App+Screenshot" 
                             alt="App Screenshot" 
                             class="max-w-[280px] md:max-w-[350px] h-auto rounded-[2.5rem] border-[8px] border-slate-900 shadow-2xl">
                    @endif
                    
                    <!-- Floating Card 1 - Transaction Success -->
                    <div class="absolute -left-10 top-1/4 bg-white p-4 rounded-2xl shadow-xl border border-slate-100 animate-bounce transition-all duration-1000 hidden md:block">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-400 font-bold uppercase">Status</p>
                                <p class="text-sm font-bold text-slate-900">Transaksi Sukses</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Floating Card 2 - Daily Profit -->
                    <div class="absolute -right-10 bottom-1/4 bg-white p-4 rounded-2xl shadow-xl border border-slate-100 animate-pulse hidden md:block">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-brand-100 text-brand-600 rounded-full flex items-center justify-center font-bold">
                                Rp
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-400 font-bold uppercase">Laba Hari Ini</p>
                                <p class="text-sm font-bold text-slate-900">+ Rp 250.000</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="fitur" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-16">Fitur Unggulan Kami</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="space-y-4">
                <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-3xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900">Kecepatan Transaksi</h3>
                <p class="text-slate-500">Sistem terotomasi penuh yang memproses transaksi Anda kurang dari 5 detik.</p>
            </div>
            <div class="space-y-4">
                <div class="w-16 h-16 bg-green-100 text-green-600 rounded-3xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900">Keamanan Terjamin</h3>
                <p class="text-slate-500">Enkripsi data berlapis dan fitur PIN ganda untuk melindungi saldo Anda.</p>
            </div>
            <div class="space-y-4">
                <div class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-3xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900">Komisi Downline</h3>
                <p class="text-slate-500">Dapatkan pasif income dengan mengajak teman bergabung menjadi mitra.</p>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section id="produk" class="py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-4 text-center md:text-left">
            <div>
                <h2 class="text-3xl font-bold mb-4">Layanan Produk Digital</h2>
                <p class="text-slate-500">Produk terlengkap untuk menunjang kebutuhan konter Anda.</p>
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-3xl text-center shadow-sm border border-slate-100">
                <span class="text-4xl mb-4 block">📱</span>
                <h4 class="font-bold">Pulsa All Operator</h4>
            </div>
            <div class="bg-white p-6 rounded-3xl text-center shadow-sm border border-slate-100">
                <span class="text-4xl mb-4 block">🌐</span>
                <h4 class="font-bold">Paket Internet</h4>
            </div>
            <div class="bg-white p-6 rounded-3xl text-center shadow-sm border border-slate-100">
                <span class="text-4xl mb-4 block">⚡</span>
                <h4 class="font-bold">Token PLN</h4>
            </div>
            <div class="bg-white p-6 rounded-3xl text-center shadow-sm border border-slate-100">
                <span class="text-4xl mb-4 block">🎮</span>
                <h4 class="font-bold">Voucher Game</h4>
            </div>
            <div class="bg-white p-6 rounded-3xl text-center shadow-sm border border-slate-100">
                <span class="text-4xl mb-4 block">💳</span>
                <h4 class="font-bold">Top Up E-Wallet</h4>
            </div>
            <div class="bg-white p-6 rounded-3xl text-center shadow-sm border border-slate-100">
                <span class="text-4xl mb-4 block">📡</span>
                <h4 class="font-bold">TV Berbayar</h4>
            </div>
            <div class="bg-white p-6 rounded-3xl text-center shadow-sm border border-slate-100">
                <span class="text-4xl mb-4 block">💸</span>
                <h4 class="font-bold">Transfer Bank</h4>
            </div>
            <div class="bg-white p-6 rounded-3xl text-center shadow-sm border border-slate-100">
                <span class="text-4xl mb-4 block">🧾</span>
                <h4 class="font-bold">Tagihan BPJS</h4>
            </div>
        </div>
    </div>
</section>

@if(isset($posts) && $posts->count() > 0)
<!-- Blog Section -->
<section id="blog" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold mb-4">Tips & Berita Bisnis</h2>
            <p class="text-slate-500">Pelajari cara mengembangkan bisnis konter Anda lebih sukses.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($posts->take(3) as $post)
            <div class="group cursor-pointer">
                <div class="overflow-hidden rounded-3xl mb-6">
                    @if($post->featured_image)
                        <img src="{{ $post->featured_image }}" class="w-full h-56 object-cover group-hover:scale-110 transition duration-500" alt="{{ $post->title }}">
                    @else
                        <div class="w-full h-56 bg-gradient-to-br from-brand-400 to-indigo-500 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                </div>
                @if($post->category)
                    <span class="text-brand-600 text-sm font-bold">{{ $post->category->name }}</span>
                @endif
                <h3 class="text-xl font-bold mt-2 group-hover:text-brand-600 transition">
                    <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                </h3>
                <p class="text-slate-500 mt-3 text-sm">{{ Str::limit($post->excerpt ?: strip_tags($post->content), 100) }}</p>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-12">
            <a href="{{ route('blog.index') }}" class="inline-flex items-center px-8 py-3 border-2 border-brand-600 text-brand-600 rounded-full font-semibold hover:bg-brand-600 hover:text-white transition-all duration-300">
                Lihat Semua Artikel
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-20 bg-brand-600">
    <div class="max-w-4xl mx-auto px-4 text-center text-white">
        <h2 class="text-4xl font-bold mb-6">Siap Memulai Bisnis Server Pulsa?</h2>
        <p class="text-indigo-100 text-lg mb-10 leading-relaxed">
            Bergabunglah dengan ribuan mitra lainnya. Pendaftaran gratis, tanpa biaya admin bulanan. Langsung jualan hari ini!
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ $settings['hero_button_url'] ?? '#' }}" class="px-10 py-4 bg-white text-brand-600 font-bold rounded-2xl shadow-xl hover:bg-brand-50 transition active:scale-95">
                Daftar Akun Sekarang
            </a>
            @if(isset($settings['whatsapp_number']) && $settings['whatsapp_number'])
            <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $settings['whatsapp_number']) }}" target="_blank" class="px-10 py-4 bg-brand-700 text-white font-bold rounded-2xl hover:bg-brand-900 transition border border-brand-500">
                Tanya Admin WA
            </a>
            @endif
        </div>
    </div>
</section>

<!-- Footer Ads -->
@if(isset($ads['footer']) && $ads['footer']->count() > 0)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @foreach($ads['footer'] as $ad)
            <div class="mb-4">
                {!! $ad->render() !!}
            </div>
        @endforeach
    </div>
@endif
