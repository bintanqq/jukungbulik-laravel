@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
<div class="pt-32 pb-16 md:pt-40 md:pb-24 text-center relative bg-background border-b border-border/30 overflow-hidden">
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

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-20 opacity-0 translate-y-8 transition-all duration-1000 ease-out" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 100)" :class="shown && '!opacity-100 !translate-y-0'">
        <h1 class="font-serif text-4xl font-bold text-foreground sm:text-5xl md:text-6xl mb-4">
            Tentang <span class="gold-gradient-text">Kami</span>
        </h1>
        <p class="text-foreground/60 max-w-2xl mx-auto">
            Mengenal lebih dekat pertunjukan Jukung Bulik dan dedikasi kami dalam melestarikan budaya Banjar.
        </p>
    </div>
</div>


<section id="tentang" class="py-20 md:py-28 overflow-hidden">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-2 items-center" x-data="{ shown: false }" x-intersect.once.margin.-100px="shown = true">
            <div class="opacity-0 -translate-x-8 transition-all duration-1000 ease-out" :class="shown && '!opacity-100 !translate-x-0'">
                <p class="text-sm tracking-[0.2em] text-primary uppercase mb-4 font-semibold">Sekilas Tentang</p>
                <h2 class="font-serif text-3xl font-bold text-foreground sm:text-4xl md:text-5xl mb-6">
                    <span class="gold-gradient-text">Jukung Bulik</span><br/>
                    <span class="text-foreground/90 text-2xl sm:text-3xl">Warisan Budaya Banjar</span>
                </h2>
                <div class="space-y-4 text-foreground/70 leading-relaxed mb-8">
                    <p>Jukung Bulik adalah pertunjukan teater tradisional yang berakar dari kebudayaan suku Banjar, Kalimantan Selatan. Sebuah perpaduan harmonis antara tarian, musik, dan cerita rakyat yang penuh makna.</p>
                </div>
            </div>
            <div class="relative aspect-video rounded-2xl border border-primary/20 bg-card/30 overflow-hidden flex items-center justify-center group opacity-0 scale-95 transition-all duration-1000 delay-200 ease-out" :class="shown && '!opacity-100 !scale-100'">
                <div class="absolute inset-0 bg-gradient-to-tr from-primary/10 to-transparent opacity-50 group-hover:opacity-70 transition-opacity"></div>
                <div class="animate-[float-up_4s_ease-in-out_infinite]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-20 h-20 text-primary/40 group-hover:text-primary/70 transition-colors group-hover:scale-110 duration-500"><path d="m2 9 20-4"/><path d="M4 14a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-6z"/><path d="M12 12v10"/><path d="m15 15-3-3-3 3"/></svg>
                </div>
                <div class="absolute bottom-6 left-6 right-6 p-4 rounded-xl bg-background/40 backdrop-blur-md border border-white/10">
                    <p class="font-serif text-lg text-foreground/90">Seni Teater Tradisional</p>
                    <p class="text-sm text-foreground/60">Melestarikan Budaya Banjar</p>
                </div>
                <style>
                    @keyframes float-up {
                        0%, 100% { transform: translateY(0); }
                        50% { transform: translateY(-10px); }
                    }
                </style>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-secondary/30" x-data="{ shown: false }" x-intersect.once.margin.-100px="shown = true">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-12 md:grid-cols-2 items-center">
            <div class="space-y-6 opacity-0 -translate-x-8 transition-all duration-1000 ease-out" :class="shown && '!opacity-100 !translate-x-0'">
                <h2 class="font-serif text-3xl font-bold text-foreground">Visi & Misi</h2>
                <div class="space-y-4 text-foreground/70 leading-relaxed">
                    <p>Visi kami adalah menjadikan seni tradisional Banjar sebagai tuan rumah di negeri sendiri dan dikenal luas di kancah internasional melalui kemasan pertunjukan yang modern namun tetap menjaga nilai-nilai luhur.</p>
                    <p>Misi kami meliputi pemberdayaan seniman lokal, edukasi budaya kepada generasi muda, dan penciptaan ekosistem kreatif yang berkelanjutan di Kalimantan Selatan.</p>
                </div>
            </div>
            <div class="relative aspect-video rounded-xl border border-primary/20 overflow-hidden bg-card/50 flex items-center justify-center opacity-0 translate-x-8 transition-all duration-1000 delay-300 ease-out" :class="shown && '!opacity-100 !translate-x-0'">
                <div class="text-center opacity-40">
                    <p class="font-serif text-lg">Dokumentasi Panitia</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
