@extends('frontend.layouts.frontend')

@section('title', 'Hubungi Kami - ' . ($settings['site_name'] ?? 'Konter Digital'))
@section('description', 'Butuh bantuan teknis, tanya harga produk, atau sekadar ingin menyapa? Tim kami aktif setiap hari untuk melayani Anda.')

@section('content')
<!-- Magazine Bold Header -->
<section class="pt-40 pb-16 bg-gradient-to-r from-red-600 to-orange-500 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-2 h-16 bg-white"></div>
            <h1 class="text-5xl md:text-7xl font-black uppercase tracking-tight">
                Contact Us
            </h1>
        </div>
        <p class="text-xl text-white/90 max-w-2xl font-bold">
            Butuh bantuan teknis, tanya harga produk, atau sekadar ingin menyapa? Tim kami aktif setiap hari untuk melayani Anda.
        </p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="mb-12 p-6 bg-green-50 border-l-8 border-green-600">
            <p class="text-green-900 font-bold text-lg">{{ session('success') }}</p>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-12 p-6 bg-red-50 border-l-8 border-red-600">
            <p class="text-red-900 font-bold text-lg">{{ session('error') }}</p>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Contact Cards -->
            <div class="lg:col-span-1 space-y-6">
                @if(isset($settings['whatsapp_number']) && $settings['whatsapp_number'])
                <div class="bg-gradient-to-br from-green-500 to-green-600 p-8 text-white">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-3 h-16 bg-white"></div>
                        <h3 class="text-2xl font-black uppercase">WhatsApp</h3>
                    </div>
                    <p class="mb-6 font-bold">Respon cepat via Chat mulai 08.00 - 22.00 WIB.</p>
                    <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $settings['whatsapp_number']) }}" 
                       target="_blank"
                       class="inline-block px-8 py-3 bg-white text-green-600 font-black uppercase hover:bg-green-50 transition">
                        Chat Now →
                    </a>
                </div>
                @endif

                @if(isset($settings['telegram_url']) && $settings['telegram_url'])
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-8 text-white">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-3 h-16 bg-white"></div>
                        <h3 class="text-2xl font-black uppercase">Telegram</h3>
                    </div>
                    <p class="mb-6 font-bold">Update info gangguan & stok via channel Telegram.</p>
                    <a href="{{ $settings['telegram_url'] }}" 
                       target="_blank"
                       class="inline-block px-8 py-3 bg-white text-blue-600 font-black uppercase hover:bg-blue-50 transition">
                        Join Group →
                    </a>
                </div>
                @endif
            </div>

            <!-- Contact Form -->
            <div class="lg:col-span-2">
                <div class="bg-gray-50 p-10 border-4 border-black">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-2 h-12 bg-red-600"></div>
                        <h2 class="text-3xl font-black uppercase">Send Message</h2>
                    </div>

                    <form method="POST" action="{{ route('contact.store') }}" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-black uppercase tracking-wider mb-2">Nama Lengkap</label>
                                <input type="text" 
                                       name="name" 
                                       value="{{ old('name') }}"
                                       required
                                       class="w-full px-6 py-4 bg-white border-2 border-black focus:outline-none focus:border-red-600 transition @error('name') border-red-600 @enderror">
                                @error('name')
                                <p class="mt-2 text-sm text-red-600 font-bold">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-black uppercase tracking-wider mb-2">Nomor HP</label>
                                <input type="tel" 
                                       name="phone" 
                                       value="{{ old('phone') }}"
                                       class="w-full px-6 py-4 bg-white border-2 border-black focus:outline-none focus:border-red-600 transition @error('phone') border-red-600 @enderror">
                                @error('phone')
                                <p class="mt-2 text-sm text-red-600 font-bold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-black uppercase tracking-wider mb-2">Email</label>
                            <input type="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   required
                                   class="w-full px-6 py-4 bg-white border-2 border-black focus:outline-none focus:border-red-600 transition @error('email') border-red-600 @enderror">
                            @error('email')
                            <p class="mt-2 text-sm text-red-600 font-bold">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-black uppercase tracking-wider mb-2">Subjek Pesan</label>
                            <select name="subject" 
                                    required
                                    class="w-full px-6 py-4 bg-white border-2 border-black focus:outline-none focus:border-red-600 transition appearance-none @error('subject') border-red-600 @enderror">
                                <option value="Tanya Pendaftaran Agen">Tanya Pendaftaran Agen</option>
                                <option value="Masalah Deposit / Saldo">Masalah Deposit / Saldo</option>
                                <option value="Laporan Transaksi Gagal">Laporan Transaksi Gagal</option>
                                <option value="Kerjasama Bisnis">Kerjasama Bisnis</option>
                            </select>
                            @error('subject')
                            <p class="mt-2 text-sm text-red-600 font-bold">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-black uppercase tracking-wider mb-2">Pesan Anda</label>
                            <textarea name="message" 
                                      rows="6" 
                                      required
                                      class="w-full px-6 py-4 bg-white border-2 border-black focus:outline-none focus:border-red-600 transition @error('message') border-red-600 @enderror">{{ old('message') }}</textarea>
                            @error('message')
                            <p class="mt-2 text-sm text-red-600 font-bold">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <button type="submit" 
                                class="w-full py-5 bg-gradient-to-r from-red-600 to-orange-500 text-white font-black uppercase tracking-wider hover:from-red-700 hover:to-orange-600 transition">
                            Kirim Pesan Sekarang →
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
