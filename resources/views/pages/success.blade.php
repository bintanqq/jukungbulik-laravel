@extends('layouts.app')

@section('title', 'Pembayaran Berhasil')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center" x-data="{ init() { confetti() } }">
    <div class="w-20 h-20 bg-green-500/20 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
    </div>
    
    <h1 class="font-serif text-3xl font-bold text-primary mb-4">Pembayaran Berhasil!</h1>
    <p class="text-foreground/80 mb-8">Terima kasih, pembayaran Anda untuk tiket JUKUNG BULIK telah kami terima.</p>
    
    <div class="bg-card border border-border rounded-lg p-6 mb-8 text-left max-w-sm mx-auto">
        <div class="mb-4 text-center">
            <span class="block text-xs text-foreground/50 uppercase tracking-wider mb-1">Kode Tiket</span>
            <span class="font-mono text-2xl text-primary font-bold">{{ $order->ticket_code }}</span>
        </div>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-foreground/70">Nama</span>
                <span class="font-medium text-foreground">{{ $order->nama }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-foreground/70">Kategori</span>
                <span class="font-medium text-foreground">{{ $order->ticketCategory->name }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-foreground/70">Jumlah</span>
                <span class="font-medium text-foreground">{{ $order->quantity }} tiket</span>
            </div>
        </div>
    </div>
    
    <div class="space-y-3 mb-8 text-sm">
        <div class="flex flex-col items-center justify-center gap-1 text-foreground/80">
            <span>✅ E-ticket PDF sedang dikirim ke email kamu:</span>
            <span class="font-bold text-primary">{{ $order->email }}</span>
        </div>
        <div class="flex items-center justify-center gap-2 text-foreground/80">
            <span>📱 Notifikasi juga dikirim ke WhatsApp kamu</span>
        </div>
    </div>
    
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="mailto:" class="px-6 py-3 bg-primary text-background font-bold rounded-lg hover:bg-primary/90 transition-colors uppercase tracking-wider">Cek Email Saya</a>
        <a href="https://wa.me/?text=Saya%20sudah%20beli%20tiket%20Jukung%20Bulik!%20Kamu%20kapan?" target="_blank" class="px-6 py-3 bg-card border border-primary text-primary font-bold rounded-lg hover:bg-primary/10 transition-colors uppercase tracking-wider">Share ke WA</a>
    </div>
</div>
<!-- Confetti script -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
@endsection
