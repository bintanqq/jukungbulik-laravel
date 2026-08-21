@extends('layouts.app')

@section('title', 'Klaim Sertifikat')

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

    <!-- Decorative Ornaments -->
    <svg class="absolute top-4 left-4 w-16 h-16 md:w-24 md:h-24 opacity-40 z-10" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 5 L5 30 Q5 35 10 35 L35 35 Q40 35 40 30 L40 25 Q40 20 35 20 L20 20 Q15 20 15 15 L15 10 Q15 5 20 5 L95 5" stroke="var(--color-primary)" stroke-width="1.5" fill="none" stroke-linecap="round"/><path d="M5 5 L30 5 Q35 5 35 10 L35 35 Q35 40 30 40 L25 40 Q20 40 20 35 L20 20 Q20 15 15 15 L10 15 Q5 15 5 20 L5 95" stroke="var(--color-primary)" stroke-width="1.5" fill="none" stroke-linecap="round"/><path d="M10 10 L15 5 L20 10 L15 15 Z" fill="var(--color-primary)" opacity="0.5"/><circle cx="25" cy="10" r="2" fill="var(--color-primary)" opacity="0.6"/><circle cx="10" cy="25" r="2" fill="var(--color-primary)" opacity="0.6"/></svg>
    <svg class="absolute top-4 right-4 rotate-90 w-16 h-16 md:w-24 md:h-24 opacity-40 z-10" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 5 L5 30 Q5 35 10 35 L35 35 Q40 35 40 30 L40 25 Q40 20 35 20 L20 20 Q15 20 15 15 L15 10 Q15 5 20 5 L95 5" stroke="var(--color-primary)" stroke-width="1.5" fill="none" stroke-linecap="round"/><path d="M5 5 L30 5 Q35 5 35 10 L35 35 Q35 40 30 40 L25 40 Q20 40 20 35 L20 20 Q20 15 15 15 L10 15 Q5 15 5 20 L5 95" stroke="var(--color-primary)" stroke-width="1.5" fill="none" stroke-linecap="round"/><path d="M10 10 L15 5 L20 10 L15 15 Z" fill="var(--color-primary)" opacity="0.5"/><circle cx="25" cy="10" r="2" fill="var(--color-primary)" opacity="0.6"/><circle cx="10" cy="25" r="2" fill="var(--color-primary)" opacity="0.6"/></svg>
    
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 opacity-0 translate-y-8 transition-all duration-1000 ease-out" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 100)" :class="shown && '!opacity-100 !translate-y-0'">
        <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-primary/30 bg-primary/10 px-4 py-1.5 text-sm text-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" x2="4" y1="22" y2="15"/></svg>
            <span class="font-medium tracking-wide">KLAIM SERTIFIKAT</span>
        </div>
        
        <h1 class="font-serif text-4xl font-bold tracking-wide sm:text-5xl md:text-6xl gold-gradient-text mb-6">
            Sertifikat <span class="text-foreground">Digital</span>
        </h1>
        
        <div class="text-center text-sm text-foreground/50 opacity-0 transition-opacity duration-1000 delay-700" :class="shown && '!opacity-100'">
            <p>Masukkan kode tiket dan nama Anda untuk mengklaim sertifikat kehadiran JUKUNG BULIK 2026.</p>
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8 text-primary"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" x2="4" y1="22" y2="15"/></svg>
                    </div>
                </div>
                
                <h2 class="text-center font-serif text-2xl font-bold text-foreground mb-2">Klaim Sertifikat</h2>
                <p class="text-center text-sm text-foreground/60 mb-8">Sertifikat hanya dapat diklaim <strong class="text-primary">1 kali</strong> per kode tiket</p>

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

                <form action="{{ route('certificate.claim') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="ticket_code" class="block text-sm font-medium text-foreground/80 mb-2">Kode Tiket</label>
                        <input type="text" 
                               name="ticket_code" 
                               id="ticket_code" 
                               value="{{ old('ticket_code') }}"
                               placeholder="Contoh: JB2026-ABCDEFGHIJKL"
                               class="w-full rounded-lg border border-border/50 bg-background/50 px-4 py-3 text-foreground placeholder-foreground/30 focus:border-primary/50 focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all uppercase tracking-wider font-mono"
                               required>
                    </div>

                    <div>
                        <label for="certificate_name" class="block text-sm font-medium text-foreground/80 mb-2">Nama untuk Sertifikat</label>
                        <input type="text" 
                               name="certificate_name" 
                               id="certificate_name" 
                               value="{{ old('certificate_name') }}"
                               placeholder="Masukkan nama lengkap Anda"
                               class="w-full rounded-lg border border-border/50 bg-background/50 px-4 py-3 text-foreground placeholder-foreground/30 focus:border-primary/50 focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all"
                               required>
                        <p class="mt-1 text-xs text-foreground/40">Nama ini akan tercetak pada sertifikat. Pastikan ejaan sudah benar.</p>
                    </div>

                    <button type="submit" 
                            class="w-full inline-flex h-12 items-center justify-center rounded-lg bg-primary px-6 text-base font-semibold text-primary-foreground hover:bg-primary/90 transition-all duration-300 hover:shadow-lg hover:shadow-primary/20 active:scale-[0.98]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 mr-2"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" x2="4" y1="22" y2="15"/></svg>
                        Klaim Sertifikat
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
