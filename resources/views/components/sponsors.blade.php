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

    <!-- Fade Kiri Kanan -->
    <div class="pointer-events-none absolute left-0 top-0 bottom-0 w-16 sm:w-32 z-20" style="background: linear-gradient(to right, hsl(var(--background)), transparent); top: 50px;"></div>
    <div class="pointer-events-none absolute right-0 top-0 bottom-0 w-16 sm:w-32 z-20" style="background: linear-gradient(to left, hsl(var(--background)), transparent); top: 50px;"></div>

    <div class="spc__wrap relative z-0">
        <div class="spc__track" id="spcTrack" role="list" aria-label="Daftar sponsor">
            @foreach ($sponsors as $s)
            <a
                class="spc__card"
                href="{{ $s['url'] }}"
                target="_blank"
                rel="noopener noreferrer"
                draggable="false"
                title="{{ $s['name'] }}"
                role="listitem"
            >
                <img src="{{ $s['img'] }}" class="spc__logo" alt="{{ $s['name'] }}" loading="lazy" decoding="async">
                <span class="spc__name">{{ $s['name'] }}</span>
            </a>
            @endforeach
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
    overflow-x: auto;
    overflow-y: hidden;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
    -ms-overflow-style: none;
    /* Padding kiri-kanan biar kartu pertama/terakhir ga nempel tepi */
    padding: 4px 24px 16px;
    box-sizing: border-box;
}
.spc__wrap::-webkit-scrollbar { display: none; }

.spc__track {
    display: flex;
    gap: 32px; /* Gap diperlebar jadi 32px biar lebih lega */
    width: max-content;
    cursor: grab;
    user-select: none;
    -webkit-user-select: none;
}
.spc__track.is-dragging { cursor: grabbing; }

.spc__card {
    flex-shrink: 0;
    width: 170px; /* Lebih lebar dikit */
    height: 150px; /* Lebih tinggi biar hampir kotak (tidak terlalu persegi panjang) */
    background: rgba(255, 255, 255, 0.03); /* Glassmorphism transparan */
    border: 1px solid rgba(255, 255, 255, 0.08); /* Border subtle */
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
    max-height: 76px; /* Logo jauh lebih besar secara vertikal */
    max-width: 130px; /* Logo jauh lebih besar secara horizontal */
    opacity: 1;
    display: block;
    pointer-events: none;
    object-fit: contain;
    transition: transform .18s;
}

.spc__name {
    font-size: 12px;
    font-weight: 500;
    color: #9ca3af; /* Teks abu-abu terang agar terbaca di dark mode */
    pointer-events: none;
}

/* Tablet */
@media (max-width: 768px) {
    .spc__card { width: 150px; height: 135px; }
    .spc__wrap  { padding: 4px 16px 14px; }
    .spc__track { gap: 24px; }
}

/* Mobile */
@media (max-width: 480px) {
    .spc__card { width: 130px; height: 120px; }
    .spc__wrap  { padding: 4px 12px 12px; }
    .spc__track { gap: 20px; }
    .spc__logo  { max-height: 56px; max-width: 100px; }
}
</style>

<script>
(function () {
    var wrap  = document.querySelector('.spc__wrap');
    var track = document.getElementById('spcTrack');
    if (!wrap || !track) return;

    var down = false, dragged = false;
    var startX = 0, startScroll = 0;
    var lastX = 0, vel = 0, raf = null;

    /* ── Mouse ── */
    wrap.addEventListener('mousedown', function (e) {
        down = true; dragged = false;
        startX = e.clientX;
        startScroll = wrap.scrollLeft;
        lastX = e.clientX; vel = 0;
        track.classList.add('is-dragging');
        if (raf) { cancelAnimationFrame(raf); raf = null; }
    });

    document.addEventListener('mousemove', function (e) {
        if (!down) return;
        var dx = e.clientX - startX;
        vel = lastX - e.clientX;   /* positif = geser kiri */
        lastX = e.clientX;
        if (Math.abs(dx) > 4) dragged = true;
        wrap.scrollLeft = startScroll - dx;
    });

    document.addEventListener('mouseup', function () {
        if (!down) return;
        down = false;
        track.classList.remove('is-dragging');
        momentum();
    });

    /* ── Touch ── */
    wrap.addEventListener('touchstart', function (e) {
        down = true; dragged = false;
        startX = e.touches[0].clientX;
        startScroll = wrap.scrollLeft;
        lastX = e.touches[0].clientX; vel = 0;
        if (raf) { cancelAnimationFrame(raf); raf = null; }
    }, { passive: true });

    wrap.addEventListener('touchmove', function (e) {
        if (!down) return;
        var dx = e.touches[0].clientX - startX;
        vel = lastX - e.touches[0].clientX;
        lastX = e.touches[0].clientX;
        if (Math.abs(dx) > 6) {
            dragged = true;
            e.preventDefault();   /* cegah scroll vertikal saat geser horizontal */
        }
        wrap.scrollLeft = startScroll - dx;
    }, { passive: false });

    wrap.addEventListener('touchend', function () {
        down = false;
        momentum();
    });

    /* ── Momentum (native scrollLeft, bukan transform) ── */
    function momentum() {
        if (Math.abs(vel) < 0.5) return;
        raf = requestAnimationFrame(function tick() {
            vel *= 0.90;
            wrap.scrollLeft += vel;
            if (Math.abs(vel) > 0.4) {
                raf = requestAnimationFrame(tick);
            } else {
                raf = null;
            }
        });
    }

    /* ── Blokir klik saat drag ── */
    track.querySelectorAll('.spc__card').forEach(function (c) {
        c.addEventListener('click', function (e) {
            if (dragged) { e.preventDefault(); e.stopPropagation(); }
        });
    });

    wrap.addEventListener('dragstart', function (e) { e.preventDefault(); });
})();
</script>