@extends('layouts.app')

@section('title', 'Pembayaran Gagal')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
    <div class="w-20 h-20 bg-red-500/20 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </div>
    
    <h1 class="font-serif text-3xl font-bold text-red-500 mb-4">Pembayaran Gagal atau Kadaluarsa</h1>
    <p class="text-foreground/80 mb-8">Maaf, kami tidak dapat memproses pembayaran untuk kode tiket <strong>{{ $order->ticket_code }}</strong>.</p>
    
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ url('/beli-tiket') }}" class="px-6 py-3 bg-primary text-background font-bold rounded-lg hover:bg-primary/90 transition-colors uppercase tracking-wider">Coba Beli Lagi</a>
        <a href="{{ url('/kontak') }}" class="px-6 py-3 bg-card border border-border text-foreground font-bold rounded-lg hover:bg-card/80 transition-colors uppercase tracking-wider">Hubungi Bantuan</a>
    </div>
</div>
@endsection
