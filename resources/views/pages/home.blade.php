@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<!-- Hero Section -->
<section id="beranda" class="pt-32 pb-16 md:pt-40 md:pb-24 text-center relative bg-background border-b border-border/30 overflow-hidden min-h-screen flex flex-col justify-center">
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('hero-bg.jpg') }}')">
        <div class="absolute inset-0 bg-background/60"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-background/30 via-transparent to-background"></div>
    </div>
    
    <!-- Hero Particles Background -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden" x-data="particles()">
        <template x-for="particle in items" :key="particle.id">
            <div class="absolute rounded-full particle"
                 :style="`left: ${particle.x}%; bottom: -${particle.y}px; width: ${particle.size}px; height: ${particle.size}px; background-color: var(--color-primary); opacity: 0.6; animation-duration: ${particle.duration}s; animation-delay: ${particle.delay}s; box-shadow: 0 0 ${particle.size * 2}px var(--color-primary);`">
            </div>
        </template>
    </div>

    <!-- Decorative Ornaments -->
    <svg class="absolute top-4 left-4 w-16 h-16 md:w-24 md:h-24 opacity-40" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 5 L5 30 Q5 35 10 35 L35 35 Q40 35 40 30 L40 25 Q40 20 35 20 L20 20 Q15 20 15 15 L15 10 Q15 5 20 5 L95 5" stroke="var(--color-primary)" stroke-width="1.5" fill="none" stroke-linecap="round"/><path d="M5 5 L30 5 Q35 5 35 10 L35 35 Q35 40 30 40 L25 40 Q20 40 20 35 L20 20 Q20 15 15 15 L10 15 Q5 15 5 20 L5 95" stroke="var(--color-primary)" stroke-width="1.5" fill="none" stroke-linecap="round"/><path d="M10 10 L15 5 L20 10 L15 15 Z" fill="var(--color-primary)" opacity="0.5"/><circle cx="25" cy="10" r="2" fill="var(--color-primary)" opacity="0.6"/><circle cx="10" cy="25" r="2" fill="var(--color-primary)" opacity="0.6"/></svg>
    <svg class="absolute top-4 right-4 rotate-90 w-16 h-16 md:w-24 md:h-24 opacity-40" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 5 L5 30 Q5 35 10 35 L35 35 Q40 35 40 30 L40 25 Q40 20 35 20 L20 20 Q15 20 15 15 L15 10 Q15 5 20 5 L95 5" stroke="var(--color-primary)" stroke-width="1.5" fill="none" stroke-linecap="round"/><path d="M5 5 L30 5 Q35 5 35 10 L35 35 Q35 40 30 40 L25 40 Q20 40 20 35 L20 20 Q20 15 15 15 L10 15 Q5 15 5 20 L5 95" stroke="var(--color-primary)" stroke-width="1.5" fill="none" stroke-linecap="round"/><path d="M10 10 L15 5 L20 10 L15 15 Z" fill="var(--color-primary)" opacity="0.5"/><circle cx="25" cy="10" r="2" fill="var(--color-primary)" opacity="0.6"/><circle cx="10" cy="25" r="2" fill="var(--color-primary)" opacity="0.6"/></svg>
    <svg class="absolute bottom-4 left-4 -rotate-90 w-16 h-16 md:w-24 md:h-24 opacity-40" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 5 L5 30 Q5 35 10 35 L35 35 Q40 35 40 30 L40 25 Q40 20 35 20 L20 20 Q15 20 15 15 L15 10 Q15 5 20 5 L95 5" stroke="var(--color-primary)" stroke-width="1.5" fill="none" stroke-linecap="round"/><path d="M5 5 L30 5 Q35 5 35 10 L35 35 Q35 40 30 40 L25 40 Q20 40 20 35 L20 20 Q20 15 15 15 L10 15 Q5 15 5 20 L5 95" stroke="var(--color-primary)" stroke-width="1.5" fill="none" stroke-linecap="round"/><path d="M10 10 L15 5 L20 10 L15 15 Z" fill="var(--color-primary)" opacity="0.5"/><circle cx="25" cy="10" r="2" fill="var(--color-primary)" opacity="0.6"/><circle cx="10" cy="25" r="2" fill="var(--color-primary)" opacity="0.6"/></svg>
    <svg class="absolute bottom-4 right-4 rotate-180 w-16 h-16 md:w-24 md:h-24 opacity-40" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 5 L5 30 Q5 35 10 35 L35 35 Q40 35 40 30 L40 25 Q40 20 35 20 L20 20 Q15 20 15 15 L15 10 Q15 5 20 5 L95 5" stroke="var(--color-primary)" stroke-width="1.5" fill="none" stroke-linecap="round"/><path d="M5 5 L30 5 Q35 5 35 10 L35 35 Q35 40 30 40 L25 40 Q20 40 20 35 L20 20 Q20 15 15 15 L10 15 Q5 15 5 20 L5 95" stroke="var(--color-primary)" stroke-width="1.5" fill="none" stroke-linecap="round"/><path d="M10 10 L15 5 L20 10 L15 15 Z" fill="var(--color-primary)" opacity="0.5"/><circle cx="25" cy="10" r="2" fill="var(--color-primary)" opacity="0.6"/><circle cx="10" cy="25" r="2" fill="var(--color-primary)" opacity="0.6"/></svg>

    <div class="relative z-10 mx-auto max-w-5xl px-4 text-center mt-20 opacity-0 translate-y-8 transition-all duration-1000 ease-out" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 100)" :class="shown && '!opacity-100 !translate-y-0'">
        <p class="mb-4 text-xs md:text-sm tracking-[0.3em] text-primary uppercase font-medium">Melestarikan Seni Budaya Banjar</p>
        <h1 class="mb-4 font-serif text-5xl font-bold tracking-wide sm:text-6xl md:text-7xl lg:text-8xl gold-gradient-text">JUKUNG BULIK</h1>
        <p class="mb-12 text-base md:text-lg tracking-[0.15em] text-foreground/80 sm:text-xl md:text-2xl">Pertunjukan Teater Tradisional Banjar</p>

        <div class="mb-12 flex flex-wrap items-center justify-center gap-4 text-xs md:text-sm text-foreground/70 sm:gap-6 md:text-base opacity-0 translate-y-8 transition-all duration-1000 delay-300 ease-out" :class="shown && '!opacity-100 !translate-y-0'">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-primary"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                <span>01 Oktober 2026</span>
            </div>
            <div class="hidden sm:block h-4 w-px bg-border"></div>
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-primary"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <span>19.00 WITA</span>
            </div>
            <div class="hidden sm:block h-4 w-px bg-border"></div>
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-primary"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                <span>Gedung Balairung Banjarmasin</span>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 opacity-0 translate-y-8 transition-all duration-1000 delay-500 ease-out" :class="shown && '!opacity-100 !translate-y-0'">
            <a href="{{ url('/beli-tiket') }}" class="inline-flex h-11 min-w-[200px] items-center justify-center rounded-md bg-primary px-8 text-base font-semibold text-primary-foreground hover:bg-primary/90 gold-glow">Beli Tiket Sekarang</a>
            <a href="{{ url('/tentang') }}" class="inline-flex h-11 min-w-[200px] items-center justify-center rounded-md border border-primary/50 bg-transparent px-8 text-base font-semibold text-primary hover:bg-primary/10">Pelajari Lebih Lanjut</a>
        </div>
    </div>
    
    <a href="#tentang" class="absolute bottom-8 left-1/2 -translate-x-1/2 cursor-pointer scroll-indicator z-20" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 800)" :class="shown ? 'opacity-100' : 'opacity-0'" class="transition-opacity duration-1000">
        <div class="flex flex-col items-center gap-2 text-foreground/50">
            <span class="text-xs tracking-wider">SCROLL</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-primary"><path d="m6 9 6 6 6-6"/></svg>
        </div>
    </a>
</section>


<!-- Countdown Section -->
<section class="py-16 md:py-20 bg-secondary/50 relative overflow-hidden">
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, var(--color-primary) 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>
    <div class="relative mx-auto max-w-4xl px-4 text-center opacity-0 translate-y-8 transition-all duration-1000 ease-out" x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown && '!opacity-100 !translate-y-0'">
        @if($period)
            <p class="text-lg sm:text-xl md:text-2xl font-serif font-bold gold-gradient-text">PRESALE SEDANG BERLANGSUNG!</p>
            <p class="mt-4 text-foreground/60">Dapatkan tiketmu sekarang dengan harga spesial!</p>
        @else
            @php
                $nextPresale = \App\Models\PresalePeriod::where('starts_at', '>', now())->where('is_active', true)->orderBy('starts_at')->first();
            @endphp
            @if($nextPresale)
                <p class="mb-12 text-sm tracking-[0.2em] text-foreground/60 uppercase">Presale dibuka dalam:</p>
                <div class="flex items-center justify-center gap-2 sm:gap-4 md:gap-6" x-data="countdown('{{ $nextPresale->starts_at }}')">
                    <template x-for="(value, unit) in { Hari: days, Jam: hours, Menit: minutes, Detik: seconds }">
                        <div class="flex flex-col items-center">
                            <div class="flex h-16 w-16 sm:h-20 sm:w-20 md:h-24 md:w-24 items-center justify-center rounded-lg border border-primary/30 bg-card/50">
                                <span class="font-serif text-2xl sm:text-3xl md:text-4xl font-bold text-primary" x-text="value">00</span>
                            </div>
                            <span class="mt-2 text-xs sm:text-sm text-foreground/60 tracking-wider uppercase" x-text="unit"></span>
                        </div>
                    </template>
                </div>
            @else
                @if($categories->count() > 0)
                    <p class="text-lg sm:text-xl md:text-2xl font-serif font-bold text-foreground">TIKET TERSEDIA</p>
                    <p class="mt-4 text-foreground/60">Amankan kursimu sebelum kehabisan!</p>
                @else
                    <p class="text-lg sm:text-xl md:text-2xl font-serif font-bold text-primary">PENJUALAN TIKET BELUM DIBUKA</p>
                    <p class="mt-4 text-foreground/60">Nantikan informasi selanjutnya melalui Instagram @jukungbulik</p>
                @endif
            @endif
        @endif
    </div>
</section>

<!-- About Preview -->
<section id="tentang" class="py-16 md:py-20 overflow-hidden">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-2 items-center" x-data="{ shown: false }" x-intersect.once.margin.-100px="shown = true">
            <div class="opacity-0 -translate-x-8 transition-all duration-1000 ease-out" :class="shown && '!opacity-100 !translate-x-0'">
                <p class="text-sm tracking-[0.2em] text-primary uppercase mb-4 font-semibold">Sekilas Tentang</p>
                <h2 class="font-serif text-3xl font-bold text-foreground sm:text-4xl md:text-5xl mb-6">
                    <span class="gold-gradient-text">Jukung Bulik</span><br/>
                    <span class="text-foreground/90 text-2xl sm:text-3xl">Warisan Budaya Banjar</span>
                </h2>
                <div class="space-y-4 text-foreground/70 leading-relaxed mb-12">
                    <p>Jukung Bulik adalah pertunjukan teater tradisional yang berakar dari kebudayaan suku Banjar, Kalimantan Selatan. Sebuah perpaduan harmonis antara tarian, musik, dan cerita rakyat yang penuh makna.</p>
                </div>
                <a href="{{ url('/tentang') }}" class="inline-flex h-11 items-center justify-center rounded-md border border-primary/50 bg-transparent px-8 text-base font-semibold text-primary hover:bg-primary/10">
                    Baca Selengkapnya 
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2 h-4 w-4"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
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

<!-- Tickets Section -->
<section id="tiket" class="py-16 md:py-20" x-data="{ shown: false }" x-intersect.once.margin.-100px="shown = true">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 opacity-0 translate-y-8 transition-all duration-1000 ease-out" :class="shown && '!opacity-100 !translate-y-0'">
            <p class="text-sm tracking-[0.2em] text-primary uppercase mb-4">Tiket Tersedia</p>
            <h2 class="font-serif text-3xl font-bold sm:text-4xl md:text-5xl">
                <span class="gold-gradient-text">Pilih Tiketmu</span>
            </h2>
            @if($period && $period->discount > 0)
                <div class="mt-6 inline-flex items-center gap-2 rounded-full bg-primary/10 border border-primary/30 px-4 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-primary"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
                    <span class="text-sm font-medium text-primary">{{ $period->name }} Aktif - {{ $period->badge }}</span>
                </div>
            @endif
        </div>

        <div class="grid gap-6 md:grid-cols-2 max-w-4xl mx-auto opacity-0 translate-y-12 transition-all duration-1000 delay-200 ease-out" :class="shown && '!opacity-100 !translate-y-0'">
            @foreach($categories as $category)
                @php
                    $remaining = $category->quota - $category->sold;
                    $isSoldOut = $remaining === 0 || !$category->is_active;
                    $hasDiscount = $period && $period->discount > 0;
                    $currentPrice = $category->base_price * (1 - ($hasDiscount ? $period->discount : 0) / 100);
                @endphp
                <div class="group relative rounded-xl border bg-card/50 p-6 transition-all duration-300 flex flex-col h-full {{ $isSoldOut ? 'border-border/30 opacity-60' : 'border-border/50 hover:border-primary/50 hover:shadow-[0_0_30px_rgba(201,168,76,0.15)] hover:-translate-y-1' }} {{ $category->icon == 'crown' ? 'ring-1 ring-primary/30' : '' }}">
                    @if($category->icon == 'crown' && !$isSoldOut)
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-primary text-primary-foreground font-semibold px-3 py-0.5 rounded-full text-xs flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3 mr-1"><path d="m2 4 3 12h14l3-12-6 7-4-7-4 7-6-7zm3 16h14"/></svg>
                            PREMIUM
                        </div>
                    @endif
                    @if($isSoldOut)
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-muted text-muted-foreground font-semibold px-3 py-0.5 rounded-full text-xs">HABIS</div>
                    @endif

                    <div class="flex items-center justify-center gap-3 mb-4">
                        <div class="h-10 w-10 rounded-full flex items-center justify-center {{ $category->icon == 'crown' ? 'bg-primary/20 text-primary' : 'bg-secondary text-foreground/70' }}">
                            @if($category->icon == 'crown')
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="m2 4 3 12h14l3-12-6 7-4-7-4 7-6-7zm3 16h14"/></svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/><path d="M13 5v2"/><path d="M13 17v2"/><path d="M13 11v2"/></svg>
                            @endif
                        </div>
                        <h3 class="font-serif text-xl font-bold text-foreground">{{ $category->name }}</h3>
                    </div>

                    <div class="text-center mb-6">
                        @if($hasDiscount)
                            <p class="text-sm text-foreground/40 line-through mb-1">Rp{{ number_format($category->base_price, 0, ',', '.') }}</p>
                        @endif
                        <p class="text-3xl font-bold gold-gradient-text">Rp{{ number_format($currentPrice, 0, ',', '.') }}</p>
                        @if($hasDiscount)
                            <p class="text-xs text-green-500 mt-1">Hemat Rp{{ number_format($category->base_price - $currentPrice, 0, ',', '.') }}</p>
                        @endif
                    </div>

                    <ul class="space-y-3 mb-6 flex-grow">
                        @foreach($category->benefits as $benefit)
                            <li class="flex items-start gap-3 text-sm text-foreground/70">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-primary shrink-0 mt-0.5"><path d="M20 6 9 17l-5-5"/></svg>
                                <span>{{ $benefit }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-auto w-full">
                        @if(!$isSoldOut && $remaining < $category->quota)
                            <div class="mb-4">
                                <div class="flex justify-between text-xs text-foreground/50 mb-1">
                                    <span>Tersisa</span>
                                    <span>{{ $remaining }} / {{ $category->quota }}</span>
                                </div>
                                <div class="h-1.5 rounded-full bg-muted overflow-hidden">
                                    <div class="h-full bg-primary/80 rounded-full transition-all duration-500" style="width: {{ ($remaining / $category->quota) * 100 }}%"></div>
                                </div>
                            </div>
                        @endif

                        @if($isSoldOut)
                            <button disabled class="w-full h-10 rounded-md font-semibold bg-muted text-muted-foreground cursor-not-allowed">Tidak Tersedia</button>
                        @else
                            <a href="{{ url('/beli-tiket') }}" class="flex h-10 w-full items-center justify-center rounded-md font-semibold {{ $category->icon == 'crown' ? 'bg-primary text-primary-foreground hover:bg-primary/90' : 'bg-primary/80 text-primary-foreground hover:bg-primary' }}">Beli Sekarang</a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="flex items-center justify-center my-16 opacity-0 scale-50 transition-all duration-1000 delay-500 ease-out" :class="shown && '!opacity-50 !scale-100'">
            <div class="h-px w-24 bg-gradient-to-r from-transparent to-primary"></div>
            <div class="mx-4 h-3 w-3 rotate-45 border border-primary"></div>
            <div class="h-px w-24 bg-gradient-to-l from-transparent to-primary"></div>
        </div>

        <div class="text-center text-sm text-foreground/50 opacity-0 transition-opacity duration-1000 delay-700" :class="shown && '!opacity-100'">
            <p>Mendukung berbagai metode pembayaran (QRIS, Transfer Bank, E-Wallet). E-ticket akan dikirim via WhatsApp setelah konfirmasi pembayaran.</p>
        </div>
    </div>
</section>

<!-- Gallery Preview -->
<section class="py-16 md:py-20 bg-secondary/30" x-data="{ modalOpen: false, modalImage: '', shown: false }" x-intersect.once.margin.-100px="shown = true">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 opacity-0 translate-y-8 transition-all duration-1000 ease-out" :class="shown && '!opacity-100 !translate-y-0'">
            <p class="text-sm tracking-[0.2em] text-primary uppercase mb-4">Dokumentasi</p>
            <h2 class="font-serif text-3xl font-bold sm:text-4xl md:text-5xl">
                <span class="gold-gradient-text">Galeri Foto</span>
            </h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-12">
            @for($i = 1; $i <= 3; $i++)
            <div class="group relative aspect-[4/5] rounded-xl overflow-hidden border border-border/30 bg-card/50 cursor-pointer opacity-0 translate-y-12 transition-all duration-1000 ease-out" 
                 :class="shown && '!opacity-100 !translate-y-0'" 
                 style="transition-delay: {{ $i * 150 }}ms;"
                 @click="modalOpen = true; modalImage = '/gallery/gallery-{{ $i }}.jpg'">
                <div class="relative w-full h-full min-h-[250px]">
                    <img src="/gallery/gallery-{{ $i }}.jpg" alt="Foto {{ $i }}" class="absolute inset-0 object-cover w-full h-full transition-transform duration-700 group-hover:scale-110 z-10" loading="lazy" decoding="async" onerror="this.style.display='none'">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-background/90 via-background/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex flex-col items-center justify-end pb-8 z-20">
                    <div class="w-12 h-12 rounded-full bg-primary/20 backdrop-blur-md flex items-center justify-center border border-primary/50 shadow-[0_0_15px_rgba(201,168,76,0.3)] mb-3 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 transform translate-y-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-primary"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                    </div>
                </div>
            </div>
            @endfor
        </div>
        <div class="text-center opacity-0 translate-y-8 transition-all duration-1000 delay-500 ease-out" :class="shown && '!opacity-100 !translate-y-0'">
            <a href="{{ url('/galeri') }}" class="inline-flex h-11 items-center justify-center rounded-md bg-primary px-8 text-lg font-semibold text-primary-foreground hover:bg-primary/90">
                Lihat Galeri Lengkap 
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2 h-5 w-5"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
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

<!-- Contact CTA Section -->
<section class="py-16 md:py-20 text-center" x-data="{ shown: false }" x-intersect.once.margin.-50px="shown = true">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 opacity-0 scale-95 transition-all duration-1000 ease-out" :class="shown && '!opacity-100 !scale-100'">
        <h2 class="font-serif text-3xl font-bold mb-6 text-foreground">Punya Pertanyaan?</h2>
        <p class="text-foreground/60 mb-12 max-w-xl mx-auto">
            Kami siap membantu Anda jika ada kendala dalam pembelian tiket atau butuh informasi lebih lanjut mengenai acara.
        </p>
        <a href="{{ url('/kontak') }}" class="inline-flex items-center justify-center rounded-md border border-primary/50 bg-transparent px-8 py-4 text-lg font-semibold text-primary hover:bg-primary/10">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-5 w-5"><path d="m3 21 1.9-5.7a8.5 8.5 0 1 1 3.8 3.8z"/></svg>
            Hubungi Kami
        </a>
    </div>
</section>
<x-sponsors />
@endsection
