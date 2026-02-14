@extends('frontend.layouts.frontend')

@section('title', 'Hubungi Kami - ' . ($settings['site_name'] ?? 'Konter Digital'))
@section('description', 'Butuh bantuan teknis, tanya harga produk, atau sekadar ingin menyapa? Tim kami aktif setiap hari untuk melayani Anda.')

@section('content')
<!-- Header Section -->
<section class="pt-40 pb-20 bg-brand-50/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="px-4 py-2 bg-brand-600/10 text-brand-600 text-xs font-extrabold uppercase tracking-widest rounded-full">Contact Support</span>
        <h1 class="text-4xl md:text-6xl font-extrabold text-brand-900 mt-6 mb-4">
            Ada Pertanyaan? Kami <br class="hidden md:block"> Siap Membantu
        </h1>
        <p class="text-slate-500 text-lg max-w-2xl mx-auto">
            Butuh bantuan teknis, tanya harga produk, atau sekadar ingin menyapa? Tim kami aktif setiap hari untuk melayani Anda.
        </p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="mb-8 max-w-4xl mx-auto">
        <div class="bg-green-50 border-l-4 border-green-500 p-6 rounded-r-2xl shadow-sm">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h3 class="text-green-900 font-semibold text-lg mb-1">Berhasil!</h3>
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-8 max-w-4xl mx-auto">
        <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-r-2xl shadow-sm">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h3 class="text-red-900 font-semibold text-lg mb-1">Error!</h3>
                    <p class="text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Contact Cards -->
        <div class="lg:col-span-1 space-y-6">
            <!-- WhatsApp Card -->
            @if(isset($settings['whatsapp_number']) && $settings['whatsapp_number'])
            <div class="p-8 bg-white border border-slate-100 rounded-[2.5rem] shadow-sm hover:shadow-xl hover:shadow-brand-600/5 transition duration-300">
                <div class="w-14 h-14 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-brand-900 mb-2">Layanan WhatsApp</h3>
                <p class="text-slate-500 text-sm mb-6">Respon cepat via Chat mulai 08.00 - 22.00 WIB.</p>
                <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $settings['whatsapp_number']) }}" 
                   target="_blank"
                   class="inline-flex items-center text-green-600 font-bold hover:gap-2 transition-all">
                    Chat Sekarang 
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
            @endif

            <!-- Telegram Card -->
            @if(isset($settings['telegram_url']) && $settings['telegram_url'])
            <div class="p-8 bg-white border border-slate-100 rounded-[2.5rem] shadow-sm hover:shadow-xl hover:shadow-brand-600/5 transition duration-300">
                <div class="w-14 h-14 bg-sky-100 text-sky-600 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.562 8.161c-.18 1.897-.962 6.502-1.359 8.627-.168.9-.499 1.201-.82 1.23-.698.064-1.226-.462-1.901-.905-1.057-.695-1.653-1.13-2.678-1.805-1.185-.78-.417-1.207.258-1.908.177-.184 3.247-2.977 3.307-3.232.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.479.329-.912.489-1.301.481-.428-.008-1.252-.241-1.865-.44-.751-.244-1.348-.372-1.296-.786.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635.099-.002.321.023.465.14.12.098.153.23.167.323.014.093.023.233.013.361z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-brand-900 mb-2">Telegram Center</h3>
                <p class="text-slate-500 text-sm mb-6">Update info gangguan & stok via channel Telegram.</p>
                <a href="{{ $settings['telegram_url'] }}" 
                   target="_blank"
                   class="inline-flex items-center text-sky-600 font-bold hover:gap-2 transition-all">
                    Gabung Grup 
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
            @endif
        </div>

        <!-- Contact Form -->
        <div class="lg:col-span-2">
            <div class="bg-white border border-slate-100 p-10 rounded-[3rem] shadow-2xl shadow-brand-900/5">
                <form method="POST" action="{{ route('contact.store') }}" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                            <input type="text" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   placeholder="Contoh: Budi Santoso" 
                                   required
                                   class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-brand-600 focus:bg-white transition @error('name') border-red-500 @enderror">
                            @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nomor HP / WhatsApp</label>
                            <input type="tel" 
                                   name="phone" 
                                   value="{{ old('phone') }}"
                                   placeholder="0812xxxx" 
                                   class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-brand-600 focus:bg-white transition @error('phone') border-red-500 @enderror">
                            @error('phone')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Email</label>
                        <input type="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               placeholder="email@example.com" 
                               required
                               class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-brand-600 focus:bg-white transition @error('email') border-red-500 @enderror">
                        @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Subjek Pesan</label>
                        <select name="subject" 
                                required
                                class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-brand-600 focus:bg-white transition appearance-none @error('subject') border-red-500 @enderror">
                            <option value="Tanya Pendaftaran Agen" {{ old('subject') == 'Tanya Pendaftaran Agen' ? 'selected' : '' }}>Tanya Pendaftaran Agen</option>
                            <option value="Masalah Deposit / Saldo" {{ old('subject') == 'Masalah Deposit / Saldo' ? 'selected' : '' }}>Masalah Deposit / Saldo</option>
                            <option value="Laporan Transaksi Gagal" {{ old('subject') == 'Laporan Transaksi Gagal' ? 'selected' : '' }}>Laporan Transaksi Gagal</option>
                            <option value="Kerjasama Bisnis" {{ old('subject') == 'Kerjasama Bisnis' ? 'selected' : '' }}>Kerjasama Bisnis</option>
                        </select>
                        @error('subject')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Pesan Anda</label>
                        <textarea name="message" 
                                  rows="5" 
                                  required
                                  placeholder="Tuliskan pesan Anda secara detail di sini..." 
                                  class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-brand-600 focus:bg-white transition @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                        @error('message')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" 
                            class="w-full py-5 bg-brand-600 text-white font-bold rounded-2xl shadow-lg shadow-brand-600/30 hover:bg-brand-700 hover:-translate-y-1 transition duration-300">
                        Kirim Pesan Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
