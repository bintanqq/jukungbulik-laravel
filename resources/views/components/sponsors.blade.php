{{-- resources/views/components/sponsor-carousel.blade.php --}}
{{-- Usage: <x-sponsor-carousel /> --}}

@php
$sponsors = [
    ['name' => 'Bank Kalsel',    'url' => '#', 'img' => '/icon.svg'],
    ['name' => 'Pemprov Kalsel', 'url' => '#', 'img' => '/icon.svg'],
    ['name' => 'Disbudpar',      'url' => '#', 'img' => '/icon.svg'],
    ['name' => 'Sponsor 4',      'url' => '#', 'img' => '/icon.svg'],
    ['name' => 'Sponsor 5',      'url' => '#', 'img' => '/icon.svg'],
    ['name' => 'Sponsor 6',      'url' => '#', 'img' => '/icon.svg'],
    ['name' => 'Sponsor 7',      'url' => '#', 'img' => '/icon.svg'],
    ['name' => 'Sponsor 8',      'url' => '#', 'img' => '/icon.svg'],
    ['name' => 'Sponsor 9',      'url' => '#', 'img' => '/icon.svg'],
    ['name' => 'Sponsor 10',     'url' => '#', 'img' => '/icon.svg'],
    ['name' => 'Sponsor 11',     'url' => '#', 'img' => '/icon.svg'],
    ['name' => 'Sponsor 12',     'url' => '#', 'img' => '/icon.svg'],
];
@endphp

<section class="spc relative">
    <p class="spc__label">Didukung Oleh</p>

    <div class="pointer-events-none absolute left-0 top-0 bottom-0 w-16 sm:w-32 z-20" style="background: linear-gradient(to right, hsl(var(--background, 0 0% 3.9%)), transparent); top: 50px;"></div>
    <div class="pointer-events-none absolute right-0 top-0 bottom-0 w-16 sm:w-32 z-20" style="background: linear-gradient(to left, hsl(var(--background, 0 0% 3.9%)), transparent); top: 50px;"></div>

    <div class="spc__wrap relative z-0">
        <div class="spc__track">
            
            {{-- GRUP 1 --}}
            <div class="spc__group" role="list" aria-label="Daftar sponsor">
                @foreach ($sponsors as $s)
                <a class="spc__card" href="{{ $s['url'] }}" target="_blank" rel="noopener noreferrer" draggable="false" title="{{ $s['name'] }}" role="listitem">
                    <img src="{{ $s['img'] }}" class="spc__logo" alt="{{ $s['name'] }}" loading="lazy" decoding="async">
                    <span class="spc__name">{{ $s['name'] }}</span>
                </a>
                @endforeach
            </div>

            {{-- GRUP 2 (Duplikasi wajib untuk efek looping tanpa jeda/patah) --}}
            <div class="spc__group" role="list" aria-hidden="true">
                @foreach ($sponsors as $s)
                <a class="spc__card" href="{{ $s['url'] }}" target="_blank" rel="noopener noreferrer" draggable="false" title="{{ $s['name'] }}">
                    <img src="{{ $s['img'] }}" class="spc__logo" alt="{{ $s['name'] }}" loading="lazy" decoding="async">
                    <span class="spc__name">{{ $s['name'] }}</span>
                </a>
                @endforeach
            </div>

        </div>
    </div>
</section>

<style>
.spc {
    padding: 3rem 0;
    border-top: 1px solid rgba(0,0,0,.08);
    overflow: hidden;
    width: 100%;
}
.spc__label {
    text-align: center;
    font-size: 11px;
    font-weight: 600;
    color: #9ca3af;
    letter-spacing: .16em;
    text-transform: uppercase;
    margin: 0 0 1.75rem;
}
.spc__wrap {
    width: 100%;
    overflow: hidden; /* Kita matikan scroll manualnya */
    padding: 4px 0 16px;
    box-sizing: border-box;
}

/* Track menampung kedua grup secara horizontal */
.spc__track {
    display: flex;
    width: max-content;
}

/* Animasi Marquee dipasang di sini */
.spc__group {
    display: flex;
    gap: 32px;
    padding-right: 32px; /* Harus sama dengan ukuran gap agar looping pixel-perfect */
    animation: marquee 30s linear infinite; /* Atur durasi (30s) buat cepat/lambatnya */
}

/* Fitur Utama: Pas di-hover, jalannya langsung diam */
.spc__track:hover .spc__group {
    animation-play-state: paused;
}

/* Keyframes geser kiri penuh */
@keyframes marquee {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-100%);
    }
}

/* Styling Card bawaan lo (Tetap dipertahankan) */
.spc__card {
    flex-shrink: 0;
    width: 170px;
    height: 150px;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(8px);
    border-radius: 16px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 12px;
    text-decoration: none;
    -webkit-user-drag: none;
    -webkit-tap-highlight-color: transparent;
    transition: transform .25s ease, border-color .25s ease, background .25s ease;
}
.spc__card:hover {
    transform: translateY(-4px);
    border-color: rgba(201, 168, 76, 0.4); /* Sentuhan Gold Jukung Bulik */
    background: rgba(255, 255, 255, 0.08);
}
.spc__card:active { transform: translateY(-1px); }

.spc__logo {
    height: auto;
    width: auto;
    max-height: 76px;
    max-width: 130px;
    opacity: 1;
    display: block;
    pointer-events: none;
    object-fit: contain;
}

.spc__name {
    font-size: 12px;
    font-weight: 500;
    color: #9ca3af;
    pointer-events: none;
}

/* Tablet */
@media (max-width: 768px) {
    .spc__card { width: 150px; height: 135px; }
    .spc__group { gap: 24px; padding-right: 24px; }
}

/* Mobile */
@media (max-width: 480px) {
    .spc__card { width: 130px; height: 120px; }
    .spc__group { gap: 20px; padding-right: 20px; }
    .spc__logo  { max-height: 56px; max-width: 100px; }
}
</style>