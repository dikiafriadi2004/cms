<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    
    @php
        $favicon = \App\Models\Setting::where('key', 'favicon')->value('value');
        $siteName = \App\Models\Setting::where('key', 'site_name')->value('value') ?? config('app.name', 'Konter Digital CMS');
    @endphp
    @if($favicon)
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $favicon) }}">
    @endif
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            500: '#ef4444',
                            600: '#dc2626',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .animate-float { 
            animation: float 6s ease-in-out infinite; 
        }
    </style>
</head>
<body class="bg-white h-screen flex items-center justify-center p-6 antialiased">
    <div class="max-w-2xl w-full text-center">
        <div class="relative inline-block mb-8">
            <h1 class="text-[120px] sm:text-[180px] font-black text-slate-100 leading-none select-none">403</h1>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="animate-float">
                    <svg class="w-32 h-32 sm:w-48 sm:h-48 text-brand-500 opacity-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight">Akses Ditolak</h2>
            <p class="text-slate-500 text-lg max-w-md mx-auto leading-relaxed">{{ $exception->getMessage() ?: 'Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.' }}</p>
        </div>

        <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('home') }}" class="w-full sm:w-auto px-8 py-3.5 bg-brand-500 text-white font-semibold rounded-xl shadow-lg shadow-brand-500/25 hover:bg-brand-600 transition-all duration-200 active:scale-95">
                Kembali ke Beranda
            </a>
            <button onclick="window.history.back()" class="w-full sm:w-auto px-8 py-3.5 bg-white text-slate-700 font-semibold rounded-xl border border-slate-200 hover:bg-slate-50 transition-all duration-200">
                Kembali
            </button>
        </div>
    </div>
</body>
</html>
