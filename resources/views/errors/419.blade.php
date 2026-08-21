<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>419 - Sesi Berakhir | JUKUNG BULIK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0a0a0c] text-slate-100 min-h-screen flex items-center justify-center p-4 antialiased selection:bg-amber-500 selection:text-black">

    <div class="w-full max-w-md mx-auto text-center">
        
        <!-- Brand Logo / Name -->
        <div class="mb-8 flex justify-center items-center gap-3">
            <div class="w-10 h-10 rounded-full border border-amber-500/40 bg-amber-500/10 flex items-center justify-center text-amber-400 font-serif font-bold text-sm shadow-lg shadow-amber-500/10">
                JB
            </div>
            <span class="font-serif text-xl font-bold tracking-wider text-amber-400">JUKUNG BULIK</span>
        </div>

        <!-- Main Minimal Error Card -->
        <div class="rounded-2xl border border-amber-500/20 bg-slate-900/60 backdrop-blur-xl p-8 shadow-2xl shadow-black/80">
            <span class="block font-mono text-6xl font-extrabold text-amber-400 mb-2 tracking-tight">419</span>
            <h1 class="font-serif text-2xl font-bold text-slate-100 mb-3">Sesi Berakhir</h1>
            
            <p class="text-sm text-slate-400 leading-relaxed mb-8">
                Halaman telah lama tidak aktif sehingga sesi keamanan Anda telah kadaluarsa. Silakan muat ulang halaman untuk melanjutkan.
            </p>

            <button onclick="window.location.reload()" 
                    class="w-full inline-flex h-11 items-center justify-center rounded-xl bg-amber-500 text-black font-semibold text-sm hover:bg-amber-400 transition-all duration-200 shadow-lg shadow-amber-500/20 active:scale-[0.98] mb-8">
                Muat Ulang Halaman
            </button>

            <!-- Social Media / Contact Committee Options -->
            <div class="pt-6 border-t border-slate-800">
                <p class="text-xs text-slate-500 font-medium mb-3 uppercase tracking-wider">Hubungi Panitia Jika Membutuhkan Bantuan</p>
                <div class="flex items-center justify-center gap-3">
                    <a href="https://wa.me/6281234567890" 
                       target="_blank" 
                       rel="noopener" 
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-slate-800 bg-slate-950/80 text-xs font-medium text-slate-300 hover:text-amber-400 hover:border-amber-500/40 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
                        <span>WhatsApp</span>
                    </a>
                    <a href="https://instagram.com/jukungbulik" 
                       target="_blank" 
                       rel="noopener" 
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-slate-800 bg-slate-950/80 text-xs font-medium text-slate-300 hover:text-amber-400 hover:border-amber-500/40 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                        <span>Instagram</span>
                    </a>
                </div>
            </div>
        </div>

        <p class="mt-8 text-xs text-slate-600">&copy; 2026 Jukung Bulik. Seluruh hak cipta dilindungi.</p>
    </div>

</body>
</html>
