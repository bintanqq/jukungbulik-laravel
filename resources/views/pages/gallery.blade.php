@extends('layouts.app')

@section('title', 'Galeri')

@section('content')

<div class="pt-32 pb-8 md:pt-40 md:pb-12 text-center relative bg-background border-b border-border/30 overflow-hidden">
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
            Galeri <span class="gold-gradient-text">Kenangan</span>
        </h1>
        <p class="text-foreground/60 max-w-2xl mx-auto">
            Kumpulan momen indah dan aksi panggung memukau dari berbagai pertunjukan kami.
        </p>
    </div>
</div>

<section id="galeri" class="py-20 md:py-28" x-data="{ modalOpen: false, modalImage: '', shown: false }" x-intersect.once.margin.-100px="shown = true">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 opacity-0 translate-y-8 transition-all duration-1000 ease-out" :class="shown && '!opacity-100 !translate-y-0'">
            <p class="text-sm tracking-[0.2em] text-primary uppercase mb-4">Dokumentasi</p>
            <h2 class="font-serif text-3xl font-bold sm:text-4xl md:text-5xl">
                <span class="gold-gradient-text">Galeri Foto</span>
            </h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 opacity-0 translate-y-12 transition-all duration-1000 delay-300 ease-out" :class="shown && '!opacity-100 !translate-y-0'">
            @for($i = 1; $i <= 6; $i++)
                @php
                    $isLarge = ($i == 1 || $i == 4);
                @endphp
                <div class="group relative overflow-hidden rounded-lg border border-border/30 bg-card/30 cursor-pointer {{ $isLarge ? 'md:row-span-2' : '' }}" @click="modalOpen = true; modalImage = '/gallery/gallery-{{ $i }}.jpg'">
                    <div class="relative w-full h-full min-h-[250px] {{ $isLarge ? 'aspect-[3/4] md:aspect-[2/3]' : 'aspect-square' }}">
                        <img src="/gallery/gallery-{{ $i }}.jpg" alt="Gallery {{ $i }}" class="absolute inset-0 object-cover w-full h-full transition-transform duration-700 group-hover:scale-110 z-10" loading="lazy" decoding="async" onerror="this.style.display='none'">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-background/90 via-background/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex flex-col items-center justify-end pb-8 z-20">
                        <div class="w-12 h-12 rounded-full bg-primary/20 backdrop-blur-md flex items-center justify-center border border-primary/50 shadow-[0_0_15px_rgba(201,168,76,0.3)] mb-3 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-primary"><circle cx="11" cy="11" r="8"/><line x1="21" x2="16.65" y1="21" y2="16.65"/><line x1="11" x2="11" y1="8" y2="14"/><line x1="8" x2="14" y1="11" y2="11"/></svg>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>

    <!-- Lightbox Modal -->
    <div x-show="modalOpen" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-background/90 backdrop-blur-sm p-4 cursor-zoom-out" @click="modalOpen = false">
        <button class="absolute top-4 right-4 text-foreground/70 hover:text-foreground hover:bg-secondary/50 rounded-full p-2">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 6L6 18M6 6l12 12"></path></svg>
        </button>
        <div class="relative w-full max-w-5xl aspect-video sm:aspect-auto sm:h-[80vh] rounded-lg overflow-hidden border border-border/50" @click.stop>
            <img :src="modalImage" class="absolute inset-0 w-full h-full object-contain">
        </div>
    </div>
</section>
@endsection
