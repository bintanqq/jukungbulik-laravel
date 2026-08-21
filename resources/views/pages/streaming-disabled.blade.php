@extends('layouts.app')

@section('title', 'Akses Streaming Belum Dibuka')

@section('content')
<div class="pt-32 pb-8 md:pt-40 md:pb-12 text-center relative bg-background border-b border-border/30">
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('hero-bg.jpg') }}')">
        <div class="absolute inset-0 bg-background/60"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-background/30 via-transparent to-background"></div>
    </div>
    
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 opacity-0 translate-y-8 transition-all duration-1000 ease-out" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 100)" :class="shown && '!opacity-100 !translate-y-0'">
        <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-amber-500/30 bg-amber-500/10 px-4 py-1.5 text-sm text-amber-400">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
            <span class="font-medium tracking-wide">AKSES DITUTUP</span>
        </div>
        
        <h1 class="font-serif text-4xl font-bold tracking-wide sm:text-5xl md:text-6xl gold-gradient-text mb-6">
            Live <span class="text-foreground">Streaming</span>
        </h1>
    </div>
</div>

<div class="py-12 sm:py-20 relative">
    <div class="relative mx-auto max-w-xl px-4 sm:px-6 lg:px-8 text-center">
        <div class="rounded-2xl border border-border/50 bg-card/30 backdrop-blur-sm p-8 shadow-xl">
            <div class="w-16 h-16 mx-auto mb-6 rounded-full bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            
            <h2 class="font-serif text-2xl font-bold text-foreground mb-3">Siaran Belum Dimulai</h2>
            <p class="text-foreground/60 text-sm leading-relaxed mb-8">
                Akses halaman nonton live streaming saat ini sedang nonaktif atau belum dibuka oleh panitia. Silakan kembali saat jadwal siaran langsung dimulai.
            </p>

            <a href="{{ route('home') }}" 
               class="inline-flex h-11 items-center justify-center rounded-lg bg-primary px-6 text-sm font-semibold text-primary-foreground hover:bg-primary/90 transition-all duration-300 shadow-md">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
