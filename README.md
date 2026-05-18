# Jukung Bulik - Production Deployment Guide

Panduan lengkap untuk meng-hosting website **Jukung Bulik** ke VPS (Ubuntu 22.04 / 24.04).

## 🛡️ Jaminan Keamanan Sistem (Security Assurances)

Website ini dibangun menggunakan **Laravel 13 & Livewire 3** dengan standar keamanan tinggi:
1. **Anti SQL Injection**: Menggunakan *Eloquent ORM* yang otomatis melakukan *PDO parameter binding*. Hacker tidak bisa menyisipkan query SQL jahat.
2. **Anti XSS (Cross-Site Scripting)**: Semua input dan output di-render menggunakan sintaks Blade `{{ }}` yang otomatis melakukan *HTML Entity Escaping*.
3. **Anti CSRF (Cross-Site Request Forgery)**: Semua transaksi dan pengiriman form dilindungi oleh token CSRF.
4. **Anti DDOS & Brute Force**: 
   - Panel admin dibatasi oleh *Rate Limiting* bawaan Laravel.
   - **DIWAJIBKAN** menggunakan **Cloudflare (Proxy)** untuk menahan serangan DDOS skala besar (L7 / L4 attacks) sebelum traffic menyentuh VPS.

---

## 🚀 Step-by-Step Setup VPS (Production Ready)

Setelah membeli VPS (direkomendasikan spesifikasi minimal: 1 Core CPU, 1GB RAM, OS **Ubuntu 24.04 LTS / 26.04 LTS**), ikuti langkah-langkah berikut:

### Tahap 1: Setup Server & Web Server (Nginx + PHP + MySQL)

Akses VPS menggunakan SSH: `ssh root@IP_VPS_ANDA`

Jalankan perintah ini secara berurutan:

```bash
# 1. Update OS
sudo apt update && sudo apt upgrade -y

# 2. Install Nginx, MySQL, dan Unzip
sudo apt install nginx mysql-server unzip -y

# 3. Install PHP 8.3 & Ekstensi yang dibutuhkan Laravel
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install php8.3-fpm php8.3-cli php8.3-mysql php8.3-xml php8.3-mbstring php8.3-curl php8.3-zip php8.3-intl php8.3-bcmath -y

# 4. Install Composer (PHP Package Manager)
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
sudo mv composer.phar /usr/local/bin/composer
rm composer-setup.php

# 5. Install Node.js & NPM (Untuk Build Assets)
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt-get install -y nodejs
```

### Tahap 2: Setup Database MySQL

```bash
sudo mysql
```

Di dalam terminal MySQL, ketik perintah ini (ubah `password_rahasia` dengan password aman lu):
```sql
CREATE DATABASE jukungbulik_db;
CREATE USER 'jukung_user'@'localhost' IDENTIFIED BY 'password_rahasia';
GRANT ALL PRIVILEGES ON jukungbulik_db.* TO 'jukung_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### Tahap 3: Upload Code & Install Dependency

**🛑 SANGAT PENTING: Daftar File/Folder yang DILARANG Keras di-Upload ke VPS!**
Biar web lu super ringan, proses upload cepet, dan VPS gak penuh sama sampah, **JANGAN PERNAH** upload folder & file di bawah ini dari laptop lu:
1. `node_modules/` (Berat banget! Lebin baik *build* di laptop, lalu upload folder `public/build/`-nya saja).
2. `vendor/` (Jangan diupload! Nanti bakal kita *generate* ulang di VPS biar bersih).
3. `.git/` & `.github/` (File tracking riwayat, gak kepake di VPS).
4. `tests/` & `phpunit.xml` (Cuma buat *testing developer*, gak perlu di production).
5. `.env` (Jangan upload rahasia lokal lu! Nanti di VPS kita copy dari `.env.example`).
6. `nextjs.html` atau file `.html` aneh lainnya (Itu sisa testing lokal).

**Cara Upload yang Bener:**
1. Di laptop lu (lokal), jalanin dulu `npm run build`. Ini bakal nge-kompres semua CSS/JS jadi super kecil.
2. Upload semua file (kecuali daftar larangan di atas) ke direktori `/var/www/jukungbulik` di VPS.
3. Masuk ke direktori:
   ```bash
   cd /var/www/jukungbulik
   ```
4. Install dependencies backend (tanpa *package testing* biar enteng):
   ```bash
   composer install --optimize-autoloader --no-dev
   ```

### Tahap 4: Konfigurasi `.env`

1. Copy file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   nano .env
   ```
2. Ubah baris ini sesuai dengan server lu:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://domain-lu.com
   APP_TIMEZONE=Asia/Makassar

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=jukungbulik_db
   DB_USERNAME=jukung_user
   DB_PASSWORD=password_rahasia
   
   XENDIT_API_KEY=xnd_production_xxxxx
   ```
3. Generate App Key & Jalankan Migrasi **(INI ALASAN FOLDER MIGRATIONS DIBUTUHKAN)**:
   ```bash
   php artisan key:generate
   php artisan migrate --force
   ```

### Tahap 5: Optimasi Cache Laravel

Agar web super cepat dan ringan di VPS:
```bash
php artisan optimize
php artisan view:cache
php artisan filament:optimize
```

### Tahap 6: Konfigurasi Nginx (Domain)

1. Buat file konfigurasi Nginx:
   ```bash
   sudo nano /etc/nginx/sites-available/jukungbulik
   ```
2. Paste konfigurasi berikut (Ubah `domain-lu.com`):
   ```nginx
    server {
        listen 80;
        server_name domain-lu.com;
        root /var/www/jukungbulik/public;

        # Security Headers
        add_header X-Frame-Options "SAMEORIGIN";
        add_header X-Content-Type-Options "nosniff";
        add_header X-XSS-Protection "1; mode=block";
        add_header Referrer-Policy "strict-origin-when-cross-origin";

        index index.php;

        charset utf-8;

        # Gzip Compression (Bikin load aset text/CSS/JS 70% lebih cepat)
        gzip on;
        gzip_vary on;
        gzip_min_length 1024;
        gzip_proxied any;
        gzip_types text/plain text/css text/xml text/javascript application/javascript application/x-javascript application/xml;
        gzip_disable "MSIE [1-6]\.";

        location / {
            try_files $uri $uri/ /index.php?$query_string;
        }

        # Cache Control Aset Statis (Bikin Loading Gambar Instan)
        location ~* \.(jpg|jpeg|png|gif|ico|css|js|webp|svg|woff|woff2|ttf|eot)$ {
            expires 365d;
            add_header Cache-Control "public, no-transform";
            access_log off;
            log_not_found off;
        }

        location = /favicon.ico { access_log off; log_not_found off; }
        location = /robots.txt  { access_log off; log_not_found off; }

        error_page 404 /index.php;

        location ~ \.php$ {
            fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
            fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
            include fastcgi_params;
        }

        location ~ /\.(?!well-known).* {
            deny all;
        }
    }
   ```
3. Aktifkan Nginx & Set Permission:
   ```bash
   sudo ln -s /etc/nginx/sites-available/jukungbulik /etc/nginx/sites-enabled/
   sudo chown -R www-data:www-data /var/www/jukungbulik
   sudo chmod -R 775 /var/www/jukungbulik/storage /var/www/jukungbulik/bootstrap/cache
   sudo systemctl restart nginx
   ```

---

## 🔑 Panduan Setup API & Integrasi (Wajib!)

Web ini sangat bergantung pada 3 layanan utama (Payment, WhatsApp, dan Email). Pastikan lu ngisi kredensial ini di file `.env` lu dengan benar:

### 1. Setup Xendit (Payment Gateway)
Sistem pembayaran menggunakan Xendit Webhook.
- Daftar akun di [Xendit](https://xendit.co/) dan selesaikan KYC.
- Masuk ke dashboard, copy **Secret Key**.
- Masukkan ke `.env`: `XENDIT_SECRET_KEY=xnd_production_xxxx`
- Di Dashboard Xendit, setting **Webhook URL** ke: `https://domain-lu.com/webhook/xendit`
- Centang opsi `Invoice Paid`, copy **Webhook Token**-nya, dan masukkan ke `.env`: `XENDIT_WEBHOOK_TOKEN=xxxx`

### 2. Setup Fonnte (Notifikasi WhatsApp)
Sistem akan otomatis mengirim pesan WA saat pembayaran lunas.
- Daftar di [Fonnte](https://fonnte.com/).
- Koneksikan nomor WhatsApp (Scan QR).
- Masuk ke menu "API", copy **Token**.
- Masukkan ke `.env`: `FONNTE_TOKEN=xxxx`

### 3. Setup Email & PDF Tiket
PDF Tiket di-generate otomatis menggunakan `barryvdh/laravel-dompdf` dan QR Code menggunakan `simplesoftwareio/simple-qrcode`. Setelah lunas, tiket PDF akan dikirim via Email.
- Gunakan layanan SMTP gratis seperti [Brevo (Sendinblue)](https://www.brevo.com/) atau akun Gmail biasa (pakai *App Password*).
- Masukkan konfigurasi SMTP di `.env`:
  ```env
  MAIL_MAILER=smtp
  MAIL_HOST=smtp-relay.brevo.com (atau smtp.gmail.com)
  MAIL_PORT=587
  MAIL_USERNAME=email_lu@gmail.com
  MAIL_PASSWORD=password_smtp_lu
  MAIL_ENCRYPTION=tls
  MAIL_FROM_ADDRESS="no-reply@jukungbulik.com"
  MAIL_FROM_NAME="Tiket Jukung Bulik"
  ```
> **Penting**: Karena sistem ngirim email & WA via *Queue* (biar web gak loading lama pas user bayar), di VPS lu wajib jalanin *Supervisor* atau perintah ini pakai Screen/Tmux: `php artisan queue:work`

### 4. Setup Cloudflare (Anti-DDOS)
1. Buat akun [Cloudflare](https://dash.cloudflare.com/)
2. Tambahkan domain lu.
3. Ubah Nameserver di penyedia domain lu (Niagahoster/Idwebhost/dll) ke Nameserver Cloudflare.
4. Di menu SSL/TLS Cloudflare, pilih **Flexible** atau **Full**.
5. Di menu Security -> Settings, nyalakan fitur **"Under Attack Mode"** jika sewaktu-waktu ada serangan DDOS.

---

## 🎨 Panduan Kustomisasi Konten & Gambar

Untuk mengubah gambar-gambar dan teks *hardcoded* di website, lu bisa langsung masuk ke direktori *source code*. Semua *settingan* UI dibikin *developer-friendly* supaya lu gampang ngeditnya tanpa harus bongkar *logic* Laravel.

### 1. Kustomisasi Gambar (Images)
Semua aset gambar (Background, Logo, dll) diletakkan di dalam folder `public/`.
- **Background Utama (Hero Section)**: Ganti file `public/hero-bg.jpg` dengan gambar pantai atau panggung lu. Semua halaman akan otomatis ngikutin background ini.
- **Background Kedua (Optional)**: Kalau butuh background beda-beda per halaman, lu bisa tambahin `public/hero-bg-2.jpg`, lalu ubah *code* pemanggilannya di Blade.
- **Foto Galeri**: Masukin foto-foto *dummy* lu ke dalam folder `public/gallery/` (misal: `public/gallery/foto-1.jpg`). Di `gallery.blade.php`, tinggal panggil pakai `{{ asset('gallery/foto-1.jpg') }}`.
- **Logo**: Ganti file `public/logo.png` atau `public/favicon.ico`.

> **💡 Tips Ukuran Gambar**: Buat background utama (`hero-bg.jpg`), pastikan ukuran *file*-nya dikompres di bawah **500KB** (resolusi 1920x1080) biar website lu nggak lemot pas dibuka di HP.

### 2. Kustomisasi Teks & Tulisan (Text)
Karena lu minta desain webnya se-identik mungkin sama *mockup* Next.js, tulisan-tulisan panjang (Visi Misi, Sejarah, Paragraf Tentang Kami) masih ditulis *hardcoded* di file tampilan. File-file ini ada di dalam folder `resources/views/pages/`:
- **Beranda**: Edit di `resources/views/pages/home.blade.php`
- **Tentang Kami**: Edit di `resources/views/pages/about.blade.php`
- **Galeri**: Edit di `resources/views/pages/gallery.blade.php`
- **Kontak**: Edit di `resources/views/pages/contact.blade.php`
- **Beli Tiket**: Edit di `resources/views/pages/ticket.blade.php`

**Cara Ngubah Teks:**
1. Buka file `.blade.php` yang mau lu ubah pakai VS Code.
2. Cari tulisan yang mau diubah (contoh: *Melestarikan Budaya Banjar*).
3. Langsung timpa teksnya aja, **jangan** ubah teks yang ada di dalam tag `<script>`, `@php`, atau atribut kelas seperti `class="..."`.

### 3. Mengubah Nomor WhatsApp & Link Sosmed
Semua nomor WhatsApp CS dan link sosmed ada di dalam file `resources/views/layouts/app.blade.php`.
1. Buka `resources/views/layouts/app.blade.php`.
2. Cari baris yang mengandung `wa.me/6281234567890`. Ubah angkanya dengan nomor lu (jangan pakai 0 di awal, langsung 62).
3. Cari kata `@jukungbulik` di `resources/views/pages/contact.blade.php` kalau lu mau ngubah username sosmed di halaman Kontak.

### 4. Mengubah Logo & Daftar Sponsor
Sponsor sekarang menggunakan sistem **PHP Array** yang dinamis, rapi, dan mudah dikelola tanpa perlu menyalin baris-baris HTML panjang.
1. Buka file `resources/views/components/sponsors.blade.php`.
2. Di bagian paling atas, edit bagian array `$sponsors`:
   ```php
   $sponsors = [
       ['name' => 'Nama Sponsor 1', 'url' => 'https://link-sponsor-1.com', 'img' => '/images/logo-1.png'],
       ['name' => 'Nama Sponsor 2', 'url' => 'https://link-sponsor-2.com', 'img' => '/images/logo-2.png'],
   ];
   ```
3. Kamu hanya perlu mengganti `name`, `url` (tujuan klik), dan `img` (path gambar logo di folder `public`).
4. Kamu bebas menambah atau mengurangi baris di dalam array `$sponsors` tersebut. Sistem secara otomatis me-render jumlah sponsor, mematikan interaksi drag bawaan browser pada gambar, dan memproses transisi glassmorphic-nya.

---
**Selesai!** Website Jukung Bulik sekarang sudah live dan aman dari serangan hacker/DDOS.
