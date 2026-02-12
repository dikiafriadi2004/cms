<!-- Footer -->
<footer class="bg-slate-900 text-slate-400 pt-20 pb-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
            <!-- About Column -->
            <div>
                <div class="flex items-center gap-2 mb-6">
                    @if(!empty($settings['logo']))
                        <img src="{{ storage_url($settings['logo']) }}" alt="{{ $settings['site_name'] ?? 'Logo' }}" class="h-8 w-auto">
                    @else
                        <div class="w-8 h-8 bg-brand-600 rounded-lg flex items-center justify-center text-white font-bold">
                            {{ substr($settings['site_name'] ?? 'K', 0, 1) }}
                        </div>
                        <span class="text-xl font-bold text-white tracking-tight">{{ $settings['site_name'] ?? 'KonterDigital' }}</span>
                    @endif
                </div>
                <p class="text-sm leading-relaxed">{{ $settings['footer_about'] ?? $settings['site_description'] ?? 'Platform server pulsa terbaik untuk UMKM di Indonesia. Cepat, Murah, dan Aman.' }}</p>
            </div>
            
            <!-- Quick Links Column -->
            <div>
                <h4 class="text-white font-bold mb-6">Tautan Cepat</h4>
                <ul class="space-y-4 text-sm">
                    @if($footerMenu && $footerMenu->items)
                        @foreach($footerMenu->items as $item)
                            @if($item->is_active)
                                <li><a href="{{ $item->url }}" target="{{ $item->target }}" class="hover:text-white transition">{{ $item->title }}</a></li>
                            @endif
                        @endforeach
                    @else
                        <li><a href="{{ route('home') }}#fitur" class="hover:text-white transition">Fitur Unggulan</a></li>
                        <li><a href="{{ route('home') }}#produk" class="hover:text-white transition">Daftar Produk</a></li>
                        <li><a href="{{ route('blog.index') }}" class="hover:text-white transition">Blog</a></li>
                    @endif
                </ul>
            </div>
            
            <!-- Contact Column -->
            <div>
                <h4 class="text-white font-bold mb-6">Hubungi Kami</h4>
                <div class="space-y-4">
                    @if(isset($settings['whatsapp_number']) && $settings['whatsapp_number'])
                    <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $settings['whatsapp_number']) }}" target="_blank" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 bg-slate-800 rounded-xl flex items-center justify-center group-hover:bg-green-600 transition text-white">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </div>
                        <span class="text-sm">WhatsApp CS</span>
                    </a>
                    @endif
                    
                    @if(isset($settings['telegram_url']) && $settings['telegram_url'])
                    <a href="{{ $settings['telegram_url'] }}" target="_blank" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 bg-slate-800 rounded-xl flex items-center justify-center group-hover:bg-sky-500 transition text-white">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.562 8.161c-.18 1.897-.962 6.502-1.359 8.627-.168.9-.499 1.201-.82 1.23-.698.064-1.226-.462-1.901-.905-1.057-.695-1.653-1.13-2.678-1.805-1.185-.78-.417-1.207.258-1.908.177-.184 3.247-2.977 3.307-3.232.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.479.329-.912.489-1.301.481-.428-.008-1.252-.241-1.865-.44-.751-.244-1.348-.372-1.296-.786.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635.099-.002.321.023.465.14.12.098.153.23.167.323.014.093.023.233.013.361z"/></svg>
                        </div>
                        <span class="text-sm">Telegram Center</span>
                    </a>
                    @endif
                    
                    @if(isset($settings['contact_email']) && $settings['contact_email'])
                    <a href="mailto:{{ $settings['contact_email'] }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 bg-slate-800 rounded-xl flex items-center justify-center group-hover:bg-blue-500 transition text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="text-sm">{{ $settings['contact_email'] }}</span>
                    </a>
                    @endif
                </div>
            </div>
            
            <!-- Location Column -->
            <div>
                <h4 class="text-white font-bold mb-6">Lokasi Kami</h4>
                <p class="text-sm leading-relaxed">{{ $settings['contact_address'] ?? 'Jl. Digital No. 123, Jakarta Selatan, Indonesia' }}</p>
                
                @if(isset($settings['facebook_url']) || isset($settings['instagram_url']) || isset($settings['twitter_url']))
                <div class="flex gap-3 mt-6">
                    @if(isset($settings['facebook_url']) && $settings['facebook_url'])
                    <a href="{{ $settings['facebook_url'] }}" target="_blank" class="w-10 h-10 bg-slate-800 rounded-xl flex items-center justify-center hover:bg-blue-600 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    @endif
                    
                    @if(isset($settings['instagram_url']) && $settings['instagram_url'])
                    <a href="{{ $settings['instagram_url'] }}" target="_blank" class="w-10 h-10 bg-slate-800 rounded-xl flex items-center justify-center hover:bg-pink-600 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    @endif
                    
                    @if(isset($settings['twitter_url']) && $settings['twitter_url'])
                    <a href="{{ $settings['twitter_url'] }}" target="_blank" class="w-10 h-10 bg-slate-800 rounded-xl flex items-center justify-center hover:bg-sky-500 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    </a>
                    @endif
                </div>
                @endif
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="border-t border-slate-800 pt-8 text-center text-xs">
            {{ $settings['footer_text'] ?? '© ' . date('Y') . ' Konter Digital Indonesia. Seluruh hak cipta dilindungi.' }}
        </div>
    </div>
</footer>
