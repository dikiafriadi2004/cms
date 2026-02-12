<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503 - Maintenance Mode</title>
    
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
                            500: '#8b5cf6',
                            600: '#7c3aed',
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
            <h1 class="text-[120px] sm:text-[180px] font-black text-slate-100 leading-none select-none">503</h1>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="animate-float">
                    <svg class="w-32 h-32 sm:w-48 sm:h-48 text-brand-500 opacity-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight">Sedang Maintenance</h2>
            <p class="text-slate-500 text-lg max-w-md mx-auto leading-relaxed">Kami sedang melakukan pemeliharaan sistem. Mohon kembali lagi dalam beberapa saat.</p>
        </div>

        <div class="mt-10">
            <button onclick="window.location.reload()" class="px-8 py-3.5 bg-brand-500 text-white font-semibold rounded-xl shadow-lg shadow-brand-500/25 hover:bg-brand-600 transition-all duration-200 active:scale-95">
                Coba Lagi
            </button>
        </div>

        <div class="mt-12 pt-12 border-t border-slate-100">
            <p class="text-slate-400 text-sm">Terima kasih atas kesabaran Anda</p>
        </div>
    </div>
</body>
</html>
