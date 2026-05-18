<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jukung Bulik - @yield('title', 'Pertunjukan Teater Tradisional Banjar')</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Pertunjukan teater tradisional Banjar yang menampilkan keindahan dan kekayaan budaya Kalimantan Selatan melalui seni pertunjukan yang memukau.">
    <meta name="keywords" content="Jukung Bulik, Teater Banjar, Teater Tradisional, Kalimantan Selatan, Budaya Banjar, Pertunjukan Seni, Tiket Teater">
    <meta name="author" content="Jukung Bulik">
    <meta name="theme-color" content="#c9a84c">
    
    <!-- Open Graph / Social Media -->
    <meta property="og:title" content="Jukung Bulik - Warisan Budaya Banjar">
    <meta property="og:description" content="Pertunjukan teater tradisional Banjar yang menampilkan keindahan dan kekayaan budaya Kalimantan Selatan melalui seni pertunjukan yang memukau.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:image" content="{{ asset('hero-bg.jpg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400..900&family=Inter:wght@300..700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-background text-foreground font-sans antialiased min-h-screen flex flex-col relative overflow-x-hidden w-full">
    

    <nav x-data="{ scrolled: false, isMobileMenuOpen: false }" 
         @scroll.window="scrolled = (window.pageYOffset > 50)"
         :class="{ 'bg-background/80 backdrop-blur-lg border-b border-border/50': scrolled, 'bg-transparent': !scrolled }"
         class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between md:h-20">
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <div class="relative h-10 w-10 overflow-hidden rounded-full border-2 border-primary/50 flex items-center justify-center">
                        <img src="/icon.svg" alt="Jukung Bulik" class="absolute inset-0 object-cover w-full h-full" onerror="this.style.display='none'">
                        <div class="absolute inset-0 flex items-center justify-center bg-primary/20 text-primary font-serif font-bold text-sm">JB</div>
                    </div>
                    <span class="font-serif text-lg font-bold text-primary hidden sm:block">JUKUNG BULIK</span>
                </a>
                
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ url('/') }}" class="text-sm font-medium text-foreground/80 hover:text-primary transition-colors">Beranda</a>
                    <a href="{{ url('/tentang') }}" class="text-sm font-medium text-foreground/80 hover:text-primary transition-colors">Tentang</a>
                    <a href="{{ url('/galeri') }}" class="text-sm font-medium text-foreground/80 hover:text-primary transition-colors">Galeri</a>
                    <a href="{{ url('/kontak') }}" class="text-sm font-medium text-foreground/80 hover:text-primary transition-colors">Kontak</a>
                    <a href="{{ url('/beli-tiket') }}" class="inline-flex h-10 items-center justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground hover:bg-primary/90 transition-colors">Beli Tiket</a>
                </div>

                <button class="md:hidden p-2 text-foreground" @click="isMobileMenuOpen = !isMobileMenuOpen">
                    <svg x-show="!isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <svg x-show="isMobileMenuOpen" style="display: none;" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <div x-show="isMobileMenuOpen" style="display: none;" class="fixed inset-0 z-40 bg-background/95 backdrop-blur-lg pt-20 md:hidden">
            <div class="flex flex-col items-center gap-6 p-8">
                <a href="{{ url('/') }}" class="text-xl font-medium text-foreground hover:text-primary transition-colors" @click="isMobileMenuOpen = false">Beranda</a>
                <a href="{{ url('/tentang') }}" class="text-xl font-medium text-foreground hover:text-primary transition-colors" @click="isMobileMenuOpen = false">Tentang</a>
                <a href="{{ url('/galeri') }}" class="text-xl font-medium text-foreground hover:text-primary transition-colors" @click="isMobileMenuOpen = false">Galeri</a>
                <a href="{{ url('/kontak') }}" class="text-xl font-medium text-foreground hover:text-primary transition-colors" @click="isMobileMenuOpen = false">Kontak</a>
                <a href="{{ url('/beli-tiket') }}" class="w-full max-w-xs mt-4 inline-flex h-11 items-center justify-center rounded-md bg-primary px-8 text-lg font-medium text-primary-foreground hover:bg-primary/90 transition-colors" @click="isMobileMenuOpen = false">Beli Tiket</a>
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        @yield('content')
    </main>



    <footer class="relative pt-16 pb-8 border-t border-primary/20 bg-background/50 mt-auto">
        <div class="absolute top-0 left-0 right-0 h-px" style="background: linear-gradient(90deg, transparent, rgba(201,168,76,0.4), transparent);"></div>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 md:grid-cols-4">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="relative h-12 w-12 overflow-hidden rounded-full border-2 border-primary/50">
                            <img src="/icon.svg" alt="Jukung Bulik" class="absolute inset-0 object-cover w-full h-full" onerror="this.style.display='none'">
                            <div class="absolute inset-0 flex items-center justify-center bg-primary/20 text-primary font-serif font-bold text-sm">JB</div>
                        </div>
                        <div>
                            <h3 class="font-serif text-xl font-bold gold-gradient-text">JUKUNG BULIK</h3>
                            <p class="text-sm text-foreground/50">Warisan Budaya Banjar</p>
                        </div>
                    </div>
                    <p class="text-sm text-foreground/60 max-w-md leading-relaxed">
                        Pertunjukan teater tradisional Banjar yang menampilkan keindahan dan kekayaan budaya Kalimantan Selatan melalui seni pertunjukan yang memukau.
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold text-foreground mb-4">Menu</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ url('/') }}" class="text-sm text-foreground/60 hover:text-primary transition-colors">Beranda</a></li>
                        <li><a href="{{ url('/tentang') }}" class="text-sm text-foreground/60 hover:text-primary transition-colors">Tentang</a></li>
                        <li><a href="{{ url('/galeri') }}" class="text-sm text-foreground/60 hover:text-primary transition-colors">Galeri</a></li>
                        <li><a href="{{ url('/kontak') }}" class="text-sm text-foreground/60 hover:text-primary transition-colors">Kontak</a></li>
                        <li><a href="{{ url('/beli-tiket') }}" class="text-sm text-foreground/60 hover:text-primary transition-colors">Beli Tiket</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-foreground mb-4">Ikuti Kami</h4>
                    <div class="flex gap-3">
                        <a href="https://wa.me/6281234567890" target="_blank" class="w-10 h-10 rounded-lg border border-border/50 bg-card/30 flex items-center justify-center text-foreground/60 hover:text-primary hover:border-primary/50 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
                        </a>
                        <a href="https://instagram.com/jukungbulik" target="_blank" class="w-10 h-10 rounded-lg border border-border/50 bg-card/30 flex items-center justify-center text-foreground/60 hover:text-primary hover:border-primary/50 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="mt-12 pt-8 border-t border-border/30 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-sm text-foreground/40">&copy; {{ date('Y') }} Jukung Bulik. Hak Cipta Dilindungi.</p>
                <p class="text-sm text-foreground/40">Dibuat dengan ❤️ di Kalimantan Selatan</p>
            </div>
        </div>
    </footer>

    @livewireScripts
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('particles', () => ({
                items: [],
                init() {
                    const isMobile = window.innerWidth < 768;
                    const particleCount = isMobile ? 5 : 12;
                    this.items = Array.from({ length: particleCount }, (_, i) => ({
                        id: i,
                        x: Math.random() * 100,
                        y: Math.random() * 100 + 100,
                        size: Math.random() * 4 + 2,
                        duration: Math.random() * 15 + 10,
                        delay: Math.random() * 10,
                    }));
                }
            }));
            Alpine.data('countdown', (endDate) => ({
                days: '00',
                hours: '00',
                minutes: '00',
                seconds: '00',
                init() {
                    const countDownDate = new Date(endDate).getTime();
                    const update = () => {
                        const now = new Date().getTime();
                        const distance = countDownDate - now;
                        if (distance < 0) {
                            location.reload();
                            return;
                        }
                        this.days = String(Math.floor(distance / (1000 * 60 * 60 * 24))).padStart(2, '0');
                        this.hours = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
                        this.minutes = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                        this.seconds = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');
                    };
                    update();
                    setInterval(update, 1000);
                }
            }));
        });
    </script>
</body>
</html>
