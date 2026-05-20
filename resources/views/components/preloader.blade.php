{{-- resources/views/components/preloader.blade.php --}}
<div id="preloader" class="preloader">
    <div class="preloader__content">
        <div class="preloader__logo-wrap">
            <img src="{{ asset('icon.svg') }}" class="preloader__logo" alt="Logo Jukung Bulik">
        </div>
        
        <div class="preloader__line-container">
            <div class="preloader__line"></div>
        </div>
        
        <span class="preloader__text">Memuat Keajaiban Budaya...</span>
    </div>
</div>

<style>
/* Base Style Preloader Overlay */
.preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background-color: rgba(6, 4, 9, 0.4); /* Transparan sangat tipis agar warna dasar tetap elegan */
    backdrop-filter: blur(20px); /* Efek frosted glass blur */
    -webkit-backdrop-filter: blur(20px);
    z-index: 99999; /* Pastikan selalu berada di paling atas */
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 1;
    visibility: visible;
    transition: opacity 0.3s cubic-bezier(0.25, 1, 0.5, 1), 
                visibility 0.3s cubic-bezier(0.25, 1, 0.5, 1);
}

/* State ketika loading selesai */
.preloader.fade-out {
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
}

/* Konten di Tengah */
.preloader__content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 24px;
}

/* Wrapper Logo dengan Efek Pulse Ringkas */
.preloader__logo-wrap {
    position: relative;
    animation: logoPulse 2s infinite ease-in-out;
}

.preloader__logo {
    width: 90px; /* Sesuaikan ukuran ideal logo lo */
    height: auto;
    filter: drop-shadow(0 0 15px rgba(201, 168, 76, 0.3)); /* Soft glow emas */
}

/* Loading Line (Garis Emas Berjalan) */
.preloader__line-container {
    width: 140px;
    height: 2px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 2px;
    overflow: hidden;
    position: relative;
}

.preloader__line {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 50%;
    background: linear-gradient(90deg, transparent, #c9a84c, transparent); /* Sentuhan Emas Jukung Bulik */
    animation: lineGroove 1.5s infinite ease-in-out;
    border-radius: 2px;
}

/* Teks Pelengkap */
.preloader__text {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.25em;
    color: #c9a84c; /* Warna teks emas subtle */
    opacity: 0.7;
    font-weight: 500;
}

/* Animasi */
@keyframes logoPulse {
    0%, 100% { transform: scale(1); filter: drop-shadow(0 0 15px rgba(201, 168, 76, 0.2)); }
    50% { transform: scale(1.03); filter: drop-shadow(0 0 25px rgba(201, 168, 76, 0.4)); }
}

@keyframes lineGroove {
    0% { left: -50%; }
    100% { left: 100%; }
}

/* Mencegah scroll saat preloader aktif */
body.preloader-active {
    overflow: hidden;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const preloader = document.getElementById('preloader');
    
    // Tambahkan class lock scroll di body saat baru buka
    document.body.classList.add('preloader-active');

    const hidePreloader = () => {
        setTimeout(() => {
            if (preloader) {
                preloader.classList.add('fade-out');
            }
            document.body.classList.remove('preloader-active');
        }, 800); 
    };

    if (document.readyState === 'complete') {
        hidePreloader();
    } else {
        window.addEventListener('load', hidePreloader);
    }
});
</script>
