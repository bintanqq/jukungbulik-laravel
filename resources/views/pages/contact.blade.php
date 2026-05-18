@extends('layouts.app')

@section('title', 'Kontak')

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
            Hubungi <span class="gold-gradient-text">Panitia</span>
        </h1>
        <p class="text-foreground/60 max-w-2xl mx-auto">
            Punya pertanyaan? Kami siap membantu Anda mendapatkan pengalaman terbaik menonton Jukung Bulik.
        </p>
    </div>
</div>

<section id="kontak" class="py-20 md:py-28 bg-secondary/30" x-data="{ shown: false }" x-intersect.once.margin.-100px="shown = true">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 opacity-0 translate-y-8 transition-all duration-1000 ease-out" :class="shown && '!opacity-100 !translate-y-0'">
            <p class="text-sm tracking-[0.2em] text-primary uppercase mb-4">Informasi</p>
            <h2 class="font-serif text-3xl font-bold sm:text-4xl md:text-5xl">
                <span class="gold-gradient-text">Hubungi Kami</span>
            </h2>
        </div>

        <div class="grid gap-8 lg:grid-cols-2 opacity-0 translate-y-12 transition-all duration-1000 delay-300 ease-out" :class="shown && '!opacity-100 !translate-y-0'">
            <!-- Event Info Card -->
            <div class="rounded-xl border border-border/50 bg-card/50 p-6 md:p-8">
                <h3 class="font-serif text-xl font-bold text-foreground mb-6">Informasi Acara</h3>

                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-primary"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                        </div>
                        <div>
                            <p class="text-sm text-foreground/50">Tanggal</p>
                            <p class="text-foreground font-medium">01 Oktober 2026</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-primary"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <div>
                            <p class="text-sm text-foreground/50">Waktu</p>
                            <p class="text-foreground font-medium">19.00 WITA - Selesai</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-primary"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01"/><path d="M16 6h.01"/><path d="M12 6h.01"/><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/></svg>
                        </div>
                        <div>
                            <p class="text-sm text-foreground/50">Tempat</p>
                            <p class="text-foreground font-medium">Gedung Balairung Sari, Taman Budaya Kalsel</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-primary"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                        <div>
                            <p class="text-sm text-foreground/50">Kota</p>
                            <p class="text-foreground font-medium">Banjarmasin</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex flex-col sm:flex-row gap-3">
                    <a href="https://wa.me/6281234567890" target="_blank" class="flex-1 inline-flex items-center justify-center h-10 rounded-md bg-[#25D366] text-white hover:bg-[#25D366]/90 font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
                        WhatsApp
                    </a>
                    <a href="https://instagram.com/jukungbulik" target="_blank" class="flex-1 inline-flex items-center justify-center h-10 rounded-md border border-pink-500/50 text-pink-400 hover:bg-pink-500/10 font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                        @jukungbulik
                    </a>
                </div>

            </div>

            <!-- FAQ Section -->
            <div class="rounded-xl border border-border/50 bg-card/50 p-6 md:p-8" x-data="{ activeAccordion: null }">
                <h3 class="font-serif text-xl font-bold text-foreground mb-6">Pertanyaan Umum (FAQ)</h3>

                <div class="space-y-4">
                    @php
                    $faqs = [
                        ['q' => 'Kapan dan dimana pertunjukan diadakan?', 'a' => 'Pertunjukan akan diadakan pada tanggal 01 Oktober 2026 di Gedung Balairung Sari, Taman Budaya Kalsel, Banjarmasin.'],
                        ['q' => 'Bagaimana cara membeli tiket?', 'a' => 'Tiket dapat dibeli melalui website ini di menu Beli Tiket. Pembayaran dilakukan melalui transfer bank dan e-ticket akan dikirim via WhatsApp.'],
                        ['q' => 'Apakah anak-anak perlu membeli tiket?', 'a' => 'Ya, setiap penonton yang masuk ke area teater diwajibkan memiliki tiket, tidak memandang usia.'],
                        ['q' => 'Apakah kursi sudah ditentukan?', 'a' => 'Untuk kategori VIP, kursi bernomor (seating). Sedangkan kategori Regular adalah free seating (bebas memilih tempat duduk yang tersedia).'],
                        ['q' => 'Bolehkah membawa makanan/minuman?', 'a' => 'Dilarang membawa makanan dan minuman ke dalam ruang pertunjukan. Tersedia area khusus untuk makan dan minum di luar ruangan teater.']
                    ];
                    @endphp

                    @foreach($faqs as $index => $faq)
                    <div class="border-b border-border/30 pb-4">
                        <button class="flex w-full items-center justify-between text-left text-foreground hover:text-primary transition-colors focus:outline-none" @click="activeAccordion = activeAccordion === {{ $index }} ? null : {{ $index }}">
                            <span class="font-medium">{{ $faq['q'] }}</span>
                            <svg class="h-4 w-4 shrink-0 transition-transform duration-200" :class="{ 'rotate-180': activeAccordion === {{ $index }} }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div class="overflow-hidden transition-all duration-300 max-h-0" :style="activeAccordion === {{ $index }} ? 'max-height: ' + $el.scrollHeight + 'px' : ''">
                            <p class="pt-4 text-sm text-foreground/70">{{ $faq['a'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
