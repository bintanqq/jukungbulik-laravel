@extends('layouts.app')

@section('title', 'Nonton Streaming - JUKUNG BULIK 2026')

@section('content')
<div class="pt-24 pb-4 md:pt-28 text-center relative bg-background">
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="inline-flex items-center gap-2 rounded-full border border-emerald-500/30 bg-emerald-500/10 px-4 py-1.5 text-sm text-emerald-400 mb-3">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
            </span>
            <span class="font-medium tracking-wide">LIVE STREAMING</span>
        </div>
        <h1 class="font-serif text-2xl md:text-3xl font-bold gold-gradient-text mb-1">JUKUNG BULIK 2026</h1>
        <p class="text-sm text-foreground/50">Pertunjukan Teater Tradisional Banjar</p>
    </div>
</div>

<div class="pb-12 sm:pb-20 relative" 
     x-data="streamPlayer('{{ $videoId }}')">

    <!-- Session Expired Overlay -->
    <div x-show="!sessionValid" x-cloak 
         class="fixed inset-0 z-50 bg-background/95 backdrop-blur-lg flex items-center justify-center p-4">
        <div class="text-center max-w-md">
            <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-red-500/10 border border-red-500/30 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-10 w-10 text-red-400"><circle cx="12" cy="12" r="10"/><line x1="15" x2="9" y1="9" y2="15"/><line x1="9" x2="15" y1="9" y2="15"/></svg>
            </div>
            <h2 class="font-serif text-2xl font-bold text-foreground mb-3">Sesi Berakhir</h2>
            <p class="text-foreground/60 mb-6">Tiket ini sedang digunakan di perangkat lain. Hanya 1 perangkat yang dapat menonton secara bersamaan.</p>
            <a href="{{ route('streaming.index') }}" 
               class="inline-flex h-11 items-center justify-center rounded-lg bg-primary px-6 text-sm font-semibold text-primary-foreground hover:bg-primary/90 transition-all">
                Masuk Kembali
            </a>
        </div>
    </div>
    
    <div class="relative mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        
        @if($videoId)
            <!-- Protected Video Player Box -->
            <div id="video-container" class="relative rounded-2xl overflow-hidden border border-border/50 bg-black shadow-2xl shadow-primary/5 mb-4">
                <div class="relative w-full overflow-hidden" style="padding-top: 56.25%;">
                    
                    <!-- YouTube Embed: Autoplay + Muted + No Controls + No Annotations -->
                    <iframe 
                        id="yt-player"
                        src="https://www.youtube.com/embed/{{ $videoId }}?enablejsapi=1&autoplay=1&mute=1&controls=0&modestbranding=1&rel=0&iv_load_policy=3&disablekb=1&playsinline=1&fs=0"
                        class="absolute inset-0 w-full h-full pointer-events-none select-none scale-[1.02]"
                        frameborder="0"
                        allow="autoplay; encrypted-media; picture-in-picture"
                        allowfullscreen>
                    </iframe>

                    <!-- TOTAL 100% SHIELD OVERLAY — Completely isolates YouTube iframe from ALL mouse interaction -->
                    <div class="absolute inset-0 z-30 cursor-pointer select-none" 
                         @click="togglePlay()"
                         @contextmenu.prevent>
                    </div>

                    <!-- Muted Banner Notification (Click anywhere to unmute) -->
                    <div x-show="isMuted" 
                         @click="toggleMute()"
                         class="absolute top-4 left-4 z-40 bg-black/80 backdrop-blur-md border border-primary/40 rounded-full px-4 py-2 flex items-center gap-2 cursor-pointer text-xs text-primary font-medium shadow-lg hover:bg-primary hover:text-primary-foreground transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="1" y1="1" x2="23" y2="23"/><path d="M9 9v3a3 3 0 0 0 5.12 2.12M15 9.34V4a3 3 0 0 0-5.94-.6"/></svg>
                        <span>Video di-mute (Klik untuk aktifkan Suara)</span>
                    </div>

                    <!-- Paused Overlay Indicator -->
                    <div x-show="!isPlaying" 
                         class="absolute inset-0 z-20 flex items-center justify-center bg-black/40 backdrop-blur-xs pointer-events-none transition-all">
                        <div class="w-20 h-20 rounded-full bg-primary/90 text-primary-foreground flex items-center justify-center shadow-xl shadow-primary/30">
                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="currentColor" class="translate-x-0.5"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Custom Controls Toolbar Below Video -->
            <div class="rounded-xl border border-border/50 bg-card/40 backdrop-blur-sm p-4 mb-8 flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <!-- Play / Pause Button -->
                    <button @click="togglePlay()" 
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-primary text-primary-foreground hover:bg-primary/90 font-semibold text-sm transition-all shadow-md active:scale-95">
                        <template x-if="!isPlaying">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                                <span>Putar Video</span>
                            </div>
                        </template>
                        <template x-if="isPlaying">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><rect x="6" y="4" width="4" height="16"/><rect x="14" y="4" width="4" height="16"/></svg>
                                <span>Jeda Video</span>
                            </div>
                        </template>
                    </button>

                    <!-- Mute / Unmute Button -->
                    <button @click="toggleMute()" 
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-border/50 bg-background/50 hover:border-primary/50 text-foreground text-sm transition-all active:scale-95">
                        <template x-if="isMuted">
                            <div class="flex items-center gap-2 text-amber-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="1" y1="1" x2="23" y2="23"/><path d="M9 9v3a3 3 0 0 0 5.12 2.12M15 9.34V4a3 3 0 0 0-5.94-.6"/></svg>
                                <span>Suara: Mati</span>
                            </div>
                        </template>
                        <template x-if="!isMuted">
                            <div class="flex items-center gap-2 text-emerald-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/></svg>
                                <span>Suara: Aktif</span>
                            </div>
                        </template>
                    </button>
                </div>

                <div class="flex items-center gap-3">
                    <span class="hidden sm:inline-flex items-center gap-1.5 rounded-full bg-red-500/20 px-3 py-1 text-xs font-semibold text-red-400 border border-red-500/30">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                        </span>
                        LIVE
                    </span>

                    <!-- Fullscreen Button -->
                    <button @click="toggleFullscreen()" 
                            class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-border/50 bg-background/50 hover:border-primary/50 text-foreground text-sm transition-all active:scale-95"
                            title="Layar Penuh">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/></svg>
                        <span class="hidden sm:inline">Layar Penuh</span>
                    </button>
                </div>
            </div>
        @else
            <!-- No Video Available -->
            <div class="rounded-2xl border border-border/50 bg-card/30 backdrop-blur-sm p-12 text-center mb-8">
                <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-primary/10 border border-primary/30 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-10 w-10 text-primary"><polygon points="23 7 16 12 23 17 23 7"/><rect width="15" height="14" x="1" y="5" rx="2" ry="2"/></svg>
                </div>
                <h2 class="font-serif text-2xl font-bold text-foreground mb-3">Streaming Belum Dimulai</h2>
                <p class="text-foreground/60 max-w-md mx-auto">Link streaming belum tersedia. Silakan kembali saat pertunjukan dimulai.</p>
            </div>
        @endif

        <!-- Viewer Info Card -->
        <div class="rounded-xl border border-border/50 bg-card/30 backdrop-blur-sm p-6">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-primary/10 border border-primary/30 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-primary"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-foreground">{{ $order->nama }}</p>
                        <p class="text-xs text-foreground/50 font-mono">{{ $order->ticket_code }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 px-3 py-1 text-xs font-medium text-emerald-400">
                        <span class="relative flex h-1.5 w-1.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-emerald-500"></span>
                        </span>
                        Terhubung
                    </span>
                    <form action="{{ route('streaming.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs text-foreground/40 hover:text-red-400 transition-colors bg-transparent border-0 cursor-pointer">Keluar</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://www.youtube.com/iframe_api"></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('streamPlayer', (videoId) => ({
            sessionValid: true,
            player: null,
            isPlaying: true,
            isMuted: true,
            
            init() {
                // Heartbeat check session every 2 minutes
                setInterval(() => this.checkSession(), 2 * 60 * 1000);

                // Setup YouTube Player API with Autoplay + Mute
                if (videoId) {
                    window.onYouTubeIframeAPIReady = () => {
                        this.player = new YT.Player('yt-player', {
                            events: {
                                'onReady': (event) => {
                                    event.target.mute();
                                    event.target.playVideo();
                                    this.isPlaying = true;
                                    this.isMuted = true;
                                },
                                'onStateChange': (event) => {
                                    this.isPlaying = (event.data === YT.PlayerState.PLAYING);
                                }
                            }
                        });
                    };
                    if (window.YT && window.YT.Player) {
                        window.onYouTubeIframeAPIReady();
                    }
                }
            },

            checkSession() {
                fetch('{{ route('streaming.heartbeat') }}', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => {
                    if (!res.ok) this.sessionValid = false;
                })
                .catch(() => {});
            },

            togglePlay() {
                if (!this.player) return;
                if (this.isPlaying) {
                    this.player.pauseVideo();
                    this.isPlaying = false;
                } else {
                    this.player.playVideo();
                    this.isPlaying = true;
                }
            },

            toggleMute() {
                if (!this.player) return;
                if (this.isMuted) {
                    this.player.unMute();
                    this.isMuted = false;
                } else {
                    this.player.mute();
                    this.isMuted = true;
                }
            },

            toggleFullscreen() {
                const container = document.getElementById('video-container');
                if (!document.fullscreenElement) {
                    if (container.requestFullscreen) container.requestFullscreen();
                    else if (container.webkitRequestFullscreen) container.webkitRequestFullscreen();
                } else {
                    if (document.exitFullscreen) document.exitFullscreen();
                }
            }
        }));
    });
</script>
@endsection
