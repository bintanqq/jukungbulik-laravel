@extends('layouts.app')

@section('title', 'Streaming Live')

@section('content')
<div class="pt-32 pb-8 md:pt-40 md:pb-12 text-center relative bg-background border-b border-border/30">
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('hero-bg.jpg') }}')">
        <div class="absolute inset-0 bg-background/60"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-background/30 via-transparent to-background"></div>
    </div>

    <!-- Hero Particles Background -->
    <div class="absolute inset-0 pointer-events-none" x-data="particles()">
        <template x-for="particle in items" :key="particle.id">
            <div class="absolute rounded-full particle"
                 :style="`left: ${particle.x}%; bottom: -${particle.y}px; width: ${particle.size}px; height: ${particle.size}px; background-color: var(--color-primary); opacity: 0.6; animation-duration: ${particle.duration}s; animation-delay: ${particle.delay}s; box-shadow: 0 0 ${particle.size * 2}px var(--color-primary);`">
            </div>
        </template>
    </div>
    
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 opacity-0 translate-y-8 transition-all duration-1000 ease-out" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 100)" :class="shown && '!opacity-100 !translate-y-0'">
        <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-primary/30 bg-primary/10 px-4 py-1.5 text-sm text-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><polygon points="23 7 16 12 23 17 23 7"/><rect width="15" height="14" x="1" y="5" rx="2" ry="2"/></svg>
            <span class="font-medium tracking-wide">STREAMING LIVE</span>
        </div>
        
        <h1 class="font-serif text-4xl font-bold tracking-wide sm:text-5xl md:text-6xl gold-gradient-text mb-6">
            Nonton <span class="text-foreground">Streaming</span>
        </h1>
        
        <div class="text-center text-sm text-foreground/50 opacity-0 transition-opacity duration-1000 delay-700" :class="shown && '!opacity-100'">
            <p>Masukkan kode tiket streaming Anda untuk mengakses pertunjukan secara langsung.</p>
        </div>
    </div>
</div>

<div class="py-12 sm:py-20 relative">
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, var(--color-primary) 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>
    
    <div class="relative mx-auto max-w-xl px-4 sm:px-6 lg:px-8">
        <div class="opacity-0 translate-y-8 transition-all duration-1000 ease-out delay-200" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 300)" :class="shown && '!opacity-100 !translate-y-0'">
            
            <div class="rounded-2xl border border-border/50 bg-card/30 backdrop-blur-sm p-8 shadow-xl">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-16 h-16 rounded-full bg-primary/10 border border-primary/30 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8 text-primary"><polygon points="23 7 16 12 23 17 23 7"/><rect width="15" height="14" x="1" y="5" rx="2" ry="2"/></svg>
                    </div>
                </div>
                
                <h2 class="text-center font-serif text-2xl font-bold text-foreground mb-2">Akses Streaming</h2>
                <p class="text-center text-sm text-foreground/60 mb-8">Masukkan kode tiket streaming untuk mulai menonton</p>

                @if ($errors->any())
                    <div class="mb-6 rounded-lg border border-red-500/30 bg-red-500/10 p-4 text-sm text-red-400">
                        <div class="flex items-center gap-2 mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><circle cx="12" cy="12" r="10"/><line x1="15" x2="9" y1="9" y2="15"/><line x1="9" x2="15" y1="9" y2="15"/></svg>
                            <span class="font-semibold">Gagal</span>
                        </div>
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('streaming.authenticate') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="ticket_code" class="block text-sm font-medium text-foreground/80 mb-2">Kode Tiket Streaming</label>
                        <input type="text" 
                               name="ticket_code" 
                               id="ticket_code" 
                               value="{{ old('ticket_code') }}"
                               placeholder="Contoh: JB2026-ABCDEFGHIJKL"
                               class="w-full rounded-lg border border-border/50 bg-background/50 px-4 py-3 text-foreground placeholder-foreground/30 focus:border-primary/50 focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all uppercase tracking-wider font-mono"
                               required>
                        <p class="mt-1 text-xs text-foreground/40">Hanya tiket kategori "Streaming" yang dapat mengakses halaman ini.</p>
                    </div>

                    <button type="submit" 
                            class="w-full inline-flex h-12 items-center justify-center rounded-lg bg-primary px-6 text-base font-semibold text-primary-foreground hover:bg-primary/90 transition-all duration-300 hover:shadow-lg hover:shadow-primary/20 active:scale-[0.98]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 mr-2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                        Masuk & Nonton
                    </button>
                </form>

                <div class="mt-6 p-4 rounded-lg bg-primary/5 border border-primary/10">
                    <p class="text-xs text-foreground/50 text-center">
                        <strong class="text-primary">⚠️ Perhatian:</strong> 1 tiket hanya bisa digunakan di <strong>1 perangkat</strong> pada satu waktu. Jika Anda login di perangkat lain, sesi di perangkat sebelumnya akan otomatis terputus.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
