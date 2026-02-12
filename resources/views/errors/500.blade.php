<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Server Error</title>
    
    <link rel="icon" type="image/png" href="{{ favicon_url() }}">
    
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
                            500: '#f59e0b',
                            600: '#d97706',
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
            <h1 class="text-[120px] sm:text-[180px] font-black text-slate-100 leading-none select-none">500</h1>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="animate-float">
                    <svg class="w-32 h-32 sm:w-48 sm:h-48 text-brand-500 opacity-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight">Terjadi Kesalahan Server</h2>
            <p class="text-slate-500 text-lg max-w-md mx-auto leading-relaxed">Maaf, terjadi kesalahan pada server kami. Tim kami sedang bekerja untuk memperbaikinya.</p>
        </div>

        <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('home') }}" class="w-full sm:w-auto px-8 py-3.5 bg-brand-500 text-white font-semibold rounded-xl shadow-lg shadow-brand-500/25 hover:bg-brand-600 transition-all duration-200 active:scale-95">
                Kembali ke Beranda
            </a>
            <button onclick="window.location.reload()" class="w-full sm:w-auto px-8 py-3.5 bg-white text-slate-700 font-semibold rounded-xl border border-slate-200 hover:bg-slate-50 transition-all duration-200">
                Muat Ulang
            </button>
        </div>

        @php
            $contactEmail = \App\Models\Setting::where('key', 'contact_email')->value('value');
        @endphp
        @if($contactEmail)
        <div class="mt-12 pt-12 border-t border-slate-100">
            <p class="text-slate-400 text-sm">
                Jika masalah berlanjut, silakan hubungi kami di 
                <a href="mailto:{{ $contactEmail }}" class="text-brand-500 hover:underline">{{ $contactEmail }}</a>
            </p>
        </div>
        @endif
    </div>
</body>
</html>
