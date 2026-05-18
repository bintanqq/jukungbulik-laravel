<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jukung Bulik - @yield('title', 'Pertunjukan Teater Tradisional Banjar')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400..900&family=Inter:wght@300..700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-background text-foreground font-sans antialiased min-h-screen flex flex-col relative">
    

    <nav x-data="{ scrolled: false }" 
         @scroll.window="scrolled = (window.pageYOffset > 50)"
         :class="{ 'bg-background/80 backdrop-blur-lg border-b border-border/50': scrolled, 'bg-transparent': !scrolled }"
         class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between md:h-20">
                <!-- Back Button -->
                <a href="{{ url('/') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors hover:bg-primary/10 hover:text-primary h-10 px-4 py-2 text-foreground/70">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 mr-2"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                    Kembali
                </a>

                <!-- Logo -->
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <div class="relative h-10 w-10 overflow-hidden rounded-full border-2 border-primary/50 flex items-center justify-center">
                        <img src="/icon.svg" alt="Jukung Bulik" class="absolute inset-0 object-cover w-full h-full" onerror="this.style.display='none'">
                        <div class="absolute inset-0 flex items-center justify-center bg-primary/20 text-primary font-serif font-bold text-sm">JB</div>
                    </div>
                    <span class="font-serif text-lg font-bold text-primary hidden sm:block">JUKUNG BULIK</span>
                </a>

                <!-- Spacer -->
                <div class="w-[100px]"></div>
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
                        <a href="https://instagram.com/jukungbulik" target="_blank" class="w-10 h-10 rounded-lg border border-border/50 bg-card/30 flex items-center justify-center text-foreground/60 hover:text-primary hover:border-primary/50 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                        </a>
                        <a href="https://wa.me/6281234567890" target="_blank" class="w-10 h-10 rounded-lg border border-border/50 bg-card/30 flex items-center justify-center text-foreground/60 hover:text-primary hover:border-primary/50 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
                        </a>
                        <a href="#" target="_blank" class="w-10 h-10 rounded-lg border border-border/50 bg-card/30 flex items-center justify-center text-foreground/60 hover:text-primary hover:border-primary/50 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17"/></svg>
                        </a>
                        <a href="#" target="_blank" class="w-10 h-10 rounded-lg border border-border/50 bg-card/30 flex items-center justify-center text-foreground/60 hover:text-primary hover:border-primary/50 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
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
