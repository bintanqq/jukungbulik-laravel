@extends('layouts.app')

@section('title', $alreadyClaimed ? 'Sertifikat Sudah Diklaim' : 'Sertifikat Berhasil Diklaim')

@section('content')
<div class="pt-32 pb-8 md:pt-40 md:pb-12 text-center relative bg-background border-b border-border/30">
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('hero-bg.jpg') }}')">
        <div class="absolute inset-0 bg-background/60"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-background/30 via-transparent to-background"></div>
    </div>
    
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 opacity-0 translate-y-8 transition-all duration-1000 ease-out" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 100)" :class="shown && '!opacity-100 !translate-y-0'">
        <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-emerald-500/30 bg-emerald-500/10 px-4 py-1.5 text-sm text-emerald-400">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            <span class="font-medium tracking-wide">{{ $alreadyClaimed ? 'SUDAH DIKLAIM' : 'BERHASIL DIKLAIM' }}</span>
        </div>
        
        <h1 class="font-serif text-4xl font-bold tracking-wide sm:text-5xl md:text-6xl gold-gradient-text mb-6">
            Sertifikat <span class="text-foreground">Anda</span>
        </h1>
    </div>
</div>

<div class="py-12 sm:py-20 relative">
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, var(--color-primary) 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>
    
    <div class="relative mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
        <div class="opacity-0 translate-y-8 transition-all duration-1000 ease-out delay-200" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 300)" :class="shown && '!opacity-100 !translate-y-0'">
            
            <div class="rounded-2xl border border-border/50 bg-card/30 backdrop-blur-sm p-8 shadow-xl text-center">
                
                @if($alreadyClaimed)
                    <div class="mb-6 rounded-lg border border-amber-500/30 bg-amber-500/10 p-4 text-sm text-amber-400">
                        <div class="flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>
                            <span class="font-semibold">Sertifikat ini sudah pernah diklaim sebelumnya</span>
                        </div>
                        <p class="mt-1">Diklaim pada: {{ $order->certificate_claimed_at->format('d M Y, H:i') }} WITA</p>
                    </div>
                @else
                    <div class="mb-6 rounded-lg border border-emerald-500/30 bg-emerald-500/10 p-4 text-sm text-emerald-400">
                        <div class="flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            <span class="font-semibold">Sertifikat berhasil dibuat!</span>
                        </div>
                        <p class="mt-1">Sertifikat juga akan dikirim ke Email & WhatsApp Anda.</p>
                    </div>
                @endif

                <!-- Certificate Info -->
                <div class="space-y-4 mb-8">
                    <div class="flex justify-between items-center py-3 border-b border-border/30">
                        <span class="text-sm text-foreground/60">Nama Sertifikat</span>
                        <span class="text-sm font-semibold text-foreground">{{ $order->certificate_name }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-border/30">
                        <span class="text-sm text-foreground/60">Kode Sertifikat</span>
                        <span class="text-sm font-mono text-primary">{{ $order->certificate_code }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-border/30">
                        <span class="text-sm text-foreground/60">Kode Tiket</span>
                        <span class="text-sm font-mono text-foreground/80">{{ $order->ticket_code }}</span>
                    </div>
                </div>

                <!-- Certificate Preview -->
                <div class="mb-8 rounded-xl overflow-hidden border border-primary/20 shadow-lg">
                    <img src="{{ route('certificate.download', ['ticketCode' => $order->ticket_code]) }}" 
                         alt="Sertifikat {{ $order->certificate_name }}"
                         class="w-full h-auto">
                </div>

                <!-- Download Button -->
                <a href="{{ route('certificate.download', ['ticketCode' => $order->ticket_code]) }}" 
                   class="w-full inline-flex h-12 items-center justify-center rounded-lg bg-primary px-6 text-base font-semibold text-primary-foreground hover:bg-primary/90 transition-all duration-300 hover:shadow-lg hover:shadow-primary/20 active:scale-[0.98]"
                   download>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 mr-2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                    Download Sertifikat
                </a>

                <div class="mt-6">
                    <a href="{{ route('certificate.index') }}" class="text-sm text-foreground/50 hover:text-primary transition-colors">
                        ← Kembali ke Halaman Klaim
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
