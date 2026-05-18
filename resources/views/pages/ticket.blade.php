@extends('layouts.purchase')

@section('title', 'Beli Tiket')

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
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
            <span class="font-medium tracking-wide">PEMBELIAN TIKET</span>
        </div>
        
        <h1 class="font-serif text-4xl font-bold tracking-wide sm:text-5xl md:text-6xl gold-gradient-text mb-6">
            Pilih <span class="text-foreground">Kategori Tiket</span>
        </h1>
        
        <div class="text-center text-sm text-foreground/50 opacity-0 transition-opacity duration-1000 delay-700" :class="shown && '!opacity-100'">
            <p>Mendukung berbagai metode pembayaran (QRIS, Transfer Bank, E-Wallet). E-ticket akan dikirim via WhatsApp setelah konfirmasi pembayaran.</p>
        </div>
    </div>
</div>

@if(!$period)
    <div class="bg-secondary/50 py-10 text-center border-b border-border/50 opacity-0 translate-y-8 transition-all duration-1000 ease-out" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 400)" :class="shown && '!opacity-100 !translate-y-0'">
        <div class="mx-auto max-w-3xl px-4">
            @php
                $nextPresale = \App\Models\PresalePeriod::where('starts_at', '>', now())->where('is_active', true)->orderBy('starts_at')->first();
            @endphp
            @if($nextPresale)
                <p class="mb-6 text-sm tracking-[0.2em] text-foreground/60 uppercase">Presale dibuka dalam:</p>
                <div class="flex items-center justify-center gap-2 sm:gap-4 md:gap-6" x-data="countdown('{{ $nextPresale->starts_at }}')">
                    <template x-for="(value, unit) in { Hari: days, Jam: hours, Menit: minutes, Detik: seconds }">
                        <div class="flex flex-col items-center">
                            <div class="flex h-14 w-14 sm:h-16 sm:w-16 md:h-20 md:w-20 items-center justify-center rounded-lg border border-primary/30 bg-card/50">
                                <span class="font-serif text-xl sm:text-2xl md:text-3xl font-bold text-primary" x-text="value">00</span>
                            </div>
                            <span class="mt-2 text-[10px] sm:text-xs text-foreground/60 tracking-wider uppercase" x-text="unit"></span>
                        </div>
                    </template>
                </div>
            @else
                <p class="font-serif text-lg md:text-xl font-bold text-primary mb-2">Penjualan Tiket Belum Dibuka</p>
                <p class="text-sm text-foreground/60">Nantikan informasi selanjutnya melalui Instagram @jukungbulik</p>
            @endif
        </div>
    </div>
@endif

<div class="py-12 sm:py-20 relative">
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, var(--color-primary) 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>
    
    <div class="relative px-4 sm:px-6 lg:px-8">
        @livewire('buy-ticket-form')
    </div>
</div>
@endsection
