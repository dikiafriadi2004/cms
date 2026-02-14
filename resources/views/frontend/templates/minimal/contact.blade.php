@extends('frontend.layouts.frontend')

@section('title', 'Hubungi Kami - ' . ($settings['site_name'] ?? 'Konter Digital'))
@section('description', 'Butuh bantuan teknis, tanya harga produk, atau sekadar ingin menyapa? Tim kami aktif setiap hari untuk melayani Anda.')

@section('content')
<!-- Minimal Header -->
<section class="pt-40 pb-16 bg-white border-b border-black">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-5xl md:text-7xl font-black text-black mb-6 tracking-tight">
            Contact
        </h1>
        <p class="text-xl text-gray-600 leading-relaxed max-w-2xl">
            Butuh bantuan teknis, tanya harga produk, atau sekadar ingin menyapa? Tim kami aktif setiap hari untuk melayani Anda.
        </p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="mb-12 p-6 bg-black text-white">
            <p class="font-bold">{{ session('success') }}</p>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-12 p-6 bg-red-600 text-white">
            <p class="font-bold">{{ session('error') }}</p>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-20">
            <!-- Contact Info -->
            <div class="md:col-span-1 space-y-8">
                @if(isset($settings['whatsapp_number']) && $settings['whatsapp_number'])
                <div>
                    <h3 class="text-sm font-black uppercase tracking-wider mb-3">WhatsApp</h3>
                    <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $settings['whatsapp_number']) }}" 
                       target="_blank"
                       class="text-lg hover:underline">
                        {{ $settings['whatsapp_number'] }}
                    </a>
                </div>
                @endif

                @if(isset($settings['telegram_url']) && $settings['telegram_url'])
                <div>
                    <h3 class="text-sm font-black uppercase tracking-wider mb-3">Telegram</h3>
                    <a href="{{ $settings['telegram_url'] }}" 
                       target="_blank"
                       class="text-lg hover:underline">
                        Join Channel
                    </a>
                </div>
                @endif
            </div>

            <!-- Contact Form -->
            <div class="md:col-span-2">
                <form method="POST" action="{{ route('contact.store') }}" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-black uppercase tracking-wider mb-2">Nama</label>
                            <input type="text" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   required
                                   class="w-full px-0 py-3 bg-transparent border-0 border-b-2 border-black focus:outline-none focus:border-gray-400 transition @error('name') border-red-600 @enderror">
                            @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-black uppercase tracking-wider mb-2">Telepon</label>
                            <input type="tel" 
                                   name="phone" 
                                   value="{{ old('phone') }}"
                                   class="w-full px-0 py-3 bg-transparent border-0 border-b-2 border-black focus:outline-none focus:border-gray-400 transition @error('phone') border-red-600 @enderror">
                            @error('phone')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-black uppercase tracking-wider mb-2">Email</label>
                        <input type="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               required
                               class="w-full px-0 py-3 bg-transparent border-0 border-b-2 border-black focus:outline-none focus:border-gray-400 transition @error('email') border-red-600 @enderror">
                        @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-black uppercase tracking-wider mb-2">Subjek</label>
                        <select name="subject" 
                                required
                                class="w-full px-0 py-3 bg-transparent border-0 border-b-2 border-black focus:outline-none focus:border-gray-400 transition appearance-none @error('subject') border-red-600 @enderror">
                            <option value="Tanya Pendaftaran Agen">Tanya Pendaftaran Agen</option>
                            <option value="Masalah Deposit / Saldo">Masalah Deposit / Saldo</option>
                            <option value="Laporan Transaksi Gagal">Laporan Transaksi Gagal</option>
                            <option value="Kerjasama Bisnis">Kerjasama Bisnis</option>
                        </select>
                        @error('subject')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-black uppercase tracking-wider mb-2">Pesan</label>
                        <textarea name="message" 
                                  rows="6" 
                                  required
                                  class="w-full px-0 py-3 bg-transparent border-0 border-b-2 border-black focus:outline-none focus:border-gray-400 transition resize-none @error('message') border-red-600 @enderror">{{ old('message') }}</textarea>
                        @error('message')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" 
                            class="w-full py-4 bg-black text-white font-black uppercase tracking-wider hover:bg-gray-800 transition">
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
