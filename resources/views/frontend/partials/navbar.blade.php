<!-- Navbar -->
<nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                @if(!empty($settings['logo']))
                    <img src="{{ asset('storage/' . $settings['logo']) }}" alt="{{ $settings['site_name'] ?? 'Logo' }}" class="h-10 w-auto">
                @else
                    <div class="w-10 h-10 bg-brand-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-brand-600/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-brand-900">{{ $settings['site_name'] ?? 'Konter' }}<span class="text-brand-600">Digital</span></span>
                @endif
            </a>
            
            <div class="hidden md:flex items-center gap-8">
                @if($headerMenu && $headerMenu->items)
                    @foreach($headerMenu->items as $item)
                        @if($item->is_active)
                            @php
                                $isActive = false;
                                $itemUrl = $item->url;
                                
                                // Normalize URLs for comparison
                                $normalizedItemUrl = str_starts_with($itemUrl, 'http') ? $itemUrl : url($itemUrl);
                                $homeUrl = route('home');
                                
                                // Check for exact home page match
                                if ($normalizedItemUrl === $homeUrl || $itemUrl === '/' || $itemUrl === '') {
                                    $isActive = request()->is('/');
                                }
                                // Check for blog routes
                                elseif (str_contains($itemUrl, '/blog') || str_contains($itemUrl, 'blog')) {
                                    $isActive = request()->is('blog') || request()->is('blog/*');
                                }
                                // Check for about route
                                elseif (str_contains($itemUrl, '/about') || str_contains($itemUrl, 'about')) {
                                    $isActive = request()->is('about');
                                }
                                // Check for contact route
                                elseif (str_contains($itemUrl, '/contact') || str_contains($itemUrl, 'contact')) {
                                    $isActive = request()->is('contact');
                                }
                                // Check for other exact matches by comparing normalized URLs
                                else {
                                    $isActive = rtrim($normalizedItemUrl, '/') === rtrim(url()->current(), '/');
                                }
                            @endphp
                            <a href="{{ $item->url }}" 
                               target="{{ $item->target }}" 
                               class="text-sm font-semibold transition {{ $isActive ? 'text-brand-600 border-b-2 border-brand-600' : 'text-slate-600 hover:text-brand-600' }}">
                                {{ $item->title }}
                            </a>
                        @endif
                    @endforeach
                @else
                    <a href="{{ route('home') }}" 
                       class="text-sm font-semibold transition {{ request()->is('/') ? 'text-brand-600 border-b-2 border-brand-600' : 'text-slate-600 hover:text-brand-600' }}">
                        Beranda
                    </a>
                    <a href="{{ route('home') }}#fitur" 
                       class="text-sm font-semibold text-slate-600 hover:text-brand-600 transition">
                        Fitur
                    </a>
                    <a href="{{ route('home') }}#produk" 
                       class="text-sm font-semibold text-slate-600 hover:text-brand-600 transition">
                        Produk
                    </a>
                    <a href="{{ route('blog.index') }}" 
                       class="text-sm font-semibold transition {{ request()->is('blog') || request()->is('blog/*') ? 'text-brand-600 border-b-2 border-brand-600' : 'text-slate-600 hover:text-brand-600' }}">
                        Blog
                    </a>
                @endif
                <a href="{{ $settings['hero_button_url'] ?? '#' }}" 
                   class="px-6 py-2.5 bg-brand-600 text-white text-sm font-bold rounded-full hover:bg-brand-700 transition shadow-lg shadow-brand-600/20">
                    {{ $settings['hero_button_text'] ?? 'Daftar Sekarang' }}
                </a>
            </div>
            
            <div class="md:hidden">
                <button type="button" id="mobile-menu-button" class="text-slate-700 hover:text-brand-600 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
        <div class="px-2 pt-2 pb-3 space-y-1">
            @if($headerMenu && $headerMenu->items)
                @foreach($headerMenu->items as $item)
                    @if($item->is_active)
                        @php
                            $isActive = false;
                            $itemUrl = $item->url;
                            
                            // Normalize URLs for comparison
                            $normalizedItemUrl = str_starts_with($itemUrl, 'http') ? $itemUrl : url($itemUrl);
                            $homeUrl = route('home');
                            
                            // Check for exact home page match
                            if ($normalizedItemUrl === $homeUrl || $itemUrl === '/' || $itemUrl === '') {
                                $isActive = request()->is('/');
                            }
                            // Check for blog routes
                            elseif (str_contains($itemUrl, '/blog') || str_contains($itemUrl, 'blog')) {
                                $isActive = request()->is('blog') || request()->is('blog/*');
                            }
                            // Check for about route
                            elseif (str_contains($itemUrl, '/about') || str_contains($itemUrl, 'about')) {
                                $isActive = request()->is('about');
                            }
                            // Check for contact route
                            elseif (str_contains($itemUrl, '/contact') || str_contains($itemUrl, 'contact')) {
                                $isActive = request()->is('contact');
                            }
                            // Check for other exact matches by comparing normalized URLs
                            else {
                                $isActive = rtrim($normalizedItemUrl, '/') === rtrim(url()->current(), '/');
                            }
                        @endphp
                        <a href="{{ $item->url }}" 
                           target="{{ $item->target }}" 
                           class="block px-3 py-2 text-base font-medium rounded-md transition {{ $isActive ? 'bg-brand-50 text-brand-600' : 'text-slate-700 hover:bg-brand-50 hover:text-brand-600' }}">
                            {{ $item->title }}
                        </a>
                    @endif
                @endforeach
            @else
                <a href="{{ route('home') }}" 
                   class="block px-3 py-2 text-base font-medium rounded-md transition {{ request()->is('/') ? 'bg-brand-50 text-brand-600' : 'text-slate-700 hover:bg-brand-50 hover:text-brand-600' }}">
                    Beranda
                </a>
                <a href="{{ route('home') }}#fitur" 
                   class="block text-slate-700 hover:bg-brand-50 hover:text-brand-600 px-3 py-2 text-base font-medium rounded-md">
                    Fitur
                </a>
                <a href="{{ route('home') }}#produk" 
                   class="block text-slate-700 hover:bg-brand-50 hover:text-brand-600 px-3 py-2 text-base font-medium rounded-md">
                    Produk
                </a>
                <a href="{{ route('blog.index') }}" 
                   class="block px-3 py-2 text-base font-medium rounded-md transition {{ request()->is('blog') || request()->is('blog/*') ? 'bg-brand-50 text-brand-600' : 'text-slate-700 hover:bg-brand-50 hover:text-brand-600' }}">
                    Blog
                </a>
            @endif
            <a href="{{ $settings['hero_button_url'] ?? '#' }}" 
               class="block bg-brand-600 text-white px-3 py-2 text-base font-medium rounded-md text-center">
                {{ $settings['hero_button_text'] ?? 'Daftar Sekarang' }}
            </a>
        </div>
    </div>
</nav>
