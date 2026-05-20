# 🎭 Jukung Bulik — Panduan Deployment & Security Lengkap

Panduan **step-by-step dari nol** untuk deploy website tiket **Jukung Bulik** ke VPS production. Termasuk hardening keamanan anti-hack, anti-DDoS, anti-cheat, dan anti-brute-force.

> **Tech Stack:** Laravel 13 • Livewire 3 • Filament Admin Panel • Xendit Payment Gateway • PHP 8.4

---

## 📋 Daftar Isi

1. [Rekomendasi Spesifikasi & Software](#-rekomendasi-spesifikasi--software)
2. [Beli & Setup VPS dari Nol](#-beli--setup-vps-dari-nol)
3. [Install Software di VPS](#-tahap-1-install-software-di-vps)
4. [Setup Database MySQL](#-tahap-2-setup-database-mysql)
5. [Upload Code & Install Dependencies](#-tahap-3-upload-code--install-dependencies)
6. [Konfigurasi .env](#-tahap-4-konfigurasi-env)
7. [Setup Nginx & Domain](#-tahap-5-setup-nginx--domain)
8. [Pasang SSL (HTTPS)](#-tahap-6-pasang-ssl-https)
9. [Setup Queue Worker (Supervisor)](#-tahap-7-setup-queue-worker-supervisor)
10. [Setup Cloudflare (Anti-DDoS)](#-tahap-8-setup-cloudflare-anti-ddos)
11. [Security Hardening VPS](#-tahap-9-security-hardening-vps-anti-hack)
12. [Setup API & Integrasi](#-panduan-setup-api--integrasi)
13. [Jaminan Keamanan Sistem](#-jaminan-keamanan-sistem-security-architecture)
14. [Kustomisasi Konten & Gambar](#-panduan-kustomisasi-konten--gambar)
15. [Troubleshooting](#-troubleshooting)

---

## 💻 Rekomendasi Spesifikasi & Software

### Spesifikasi VPS Minimum

| Komponen | Minimum | Rekomendasi |
|:---------|:--------|:------------|
| CPU | 1 Core | 2 Core |
| RAM | 1 GB | 2 GB |
| Storage | 20 GB SSD | 40 GB NVMe SSD |
| Bandwidth | 1 TB/bulan | Unlimited |
| Lokasi | Singapore / Jakarta | Singapore (latency rendah) |

> **💡 Provider VPS yang Bagus:** [DigitalOcean](https://digitalocean.com), [Vultr](https://vultr.com), [Hetzner](https://hetzner.com), [IDCloudHost](https://idcloudhost.com) (lokal Indo). Budget sekitar **Rp 50.000 – 150.000/bulan**.

### Versi Software yang Direkomendasikan (Mei 2026)

| Software | Versi | Keterangan |
|:---------|:------|:-----------|
| **Ubuntu** | **26.04 LTS** "Resolute Raccoon" | Rilis April 2026, support hingga April 2031 |
| **PHP** | **8.4.x** (Active Support) | Laravel 13 butuh minimal PHP 8.3. Gunakan 8.4 untuk active support |
| **MySQL** | **8.4 LTS** | Long-Term Support, stabil untuk production |
| **Nginx** | **1.30.x** (Stable) | Versi stable terbaru |
| **Node.js** | **24.x LTS** | Hanya dipakai untuk `npm run build` di laptop |
| **Composer** | **2.x** (latest) | PHP Package Manager |
| **Supervisor** | **4.3.x** | Process manager untuk queue worker |
| **Certbot** | **5.x** (via snap) | SSL gratis dari Let's Encrypt |

> ⚠️ **JANGAN pakai PHP 8.3** — sudah masuk fase "Security Only", tidak dapat bugfix lagi. Pakai **PHP 8.4** yang masih Active Support.

---

## 🛒 Beli & Setup VPS dari Nol

### 1. Beli VPS
1. Buka website provider VPS (contoh: [DigitalOcean](https://digitalocean.com)).
2. Daftar akun dan verifikasi pembayaran.
3. Buat "Droplet" / "Instance" baru:
   - **OS:** Ubuntu 26.04 LTS
   - **Plan:** Regular SSD, 1GB RAM ($6/bulan) atau 2GB RAM ($12/bulan)
   - **Region:** Singapore (SGP1)
   - **Authentication:** Pilih **SSH Key** (SANGAT DIREKOMENDASIKAN, lebih aman dari password)

### 2. Generate SSH Key (Jika Belum Punya)
Di laptop lu (bukan VPS), buka terminal:
```bash
# Generate SSH key pair
ssh-keygen -t ed25519 -C "email-lu@gmail.com"

# Copy public key — paste ke dashboard VPS provider saat buat instance
cat ~/.ssh/id_ed25519.pub
```

### 3. Login ke VPS
```bash
ssh root@IP_VPS_LU
```

> Jika pertama kali, ketik `yes` saat ditanya fingerprint.

---

## 📦 Tahap 1: Install Software di VPS

```bash
# ============================================================
# 1. Update & Upgrade OS
# ============================================================
sudo apt update && sudo apt upgrade -y

# ============================================================
# 2. Install Nginx + MySQL + Utilities
# ============================================================
sudo apt install nginx mysql-server unzip curl git software-properties-common -y

# ============================================================
# 3. Install PHP 8.4 + Ekstensi Laravel
# ============================================================
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install php8.4-fpm php8.4-cli php8.4-mysql php8.4-xml \
    php8.4-mbstring php8.4-curl php8.4-zip php8.4-intl \
    php8.4-bcmath php8.4-gd php8.4-dom -y

# ============================================================
# 4. Install Composer
# ============================================================
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
sudo mv composer.phar /usr/local/bin/composer
rm composer-setup.php

# ============================================================
# 5. Verifikasi Semua Terinstall
# ============================================================
php -v          # Harus muncul PHP 8.4.x
nginx -v        # Harus muncul nginx/1.30.x
mysql --version # Harus muncul Ver 8.4.x
composer -V     # Harus muncul Composer version 2.x
```

> **📌 Node.js TIDAK perlu di-install di VPS.** Lu cukup jalanin `npm run build` di laptop, lalu upload folder `public/build/` ke VPS.

---

## 🗄️ Tahap 2: Setup Database MySQL

```bash
# Masuk ke MySQL
sudo mysql
```

Di dalam terminal MySQL:
```sql
-- Buat database
CREATE DATABASE jukungbulik_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Buat user khusus (JANGAN pakai root!)
-- GANTI 'PasswordSuperKuat123!' dengan password yang benar-benar kuat
CREATE USER 'jukung_user'@'localhost' IDENTIFIED BY 'PasswordSuperKuat123!';

-- Kasih akses HANYA ke database ini
GRANT ALL PRIVILEGES ON jukungbulik_db.* TO 'jukung_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

> ⚠️ **Password Database harus KUAT!** Minimal 16 karakter, campur huruf besar-kecil, angka, dan simbol. Contoh: `Jk8$Bul1k_Pr0d#2026!`

---

## 📤 Tahap 3: Upload Code & Install Dependencies

### File/Folder yang DILARANG Upload ke VPS

| ❌ Jangan Upload | Alasan |
|:-----------------|:-------|
| `node_modules/` | Berat banget, 200MB+, gak kepake di VPS |
| `vendor/` | Akan di-generate ulang di VPS |
| `.git/` & `.github/` | File tracking git, gak perlu |
| `.env` | Rahasia lokal, nanti bikin baru di VPS |
| `tests/` & `phpunit.xml` | File testing, gak perlu di production |
| `.idea/` | File IDE (PhpStorm), gak perlu |

### Langkah Upload

**1. Build assets di LAPTOP (bukan di VPS):**
```bash
# Di laptop lu
npm run build
```

**2. Upload ke VPS** (pilih salah satu cara):

**Cara A — Pakai SCP (Terminal):**
```bash
# Dari laptop, upload ke VPS (exclude file yang gak perlu)
rsync -avz --progress \
    --exclude='node_modules' \
    --exclude='vendor' \
    --exclude='.git' \
    --exclude='.github' \
    --exclude='.env' \
    --exclude='tests' \
    --exclude='.idea' \
    --exclude='phpunit.xml' \
    ./ root@IP_VPS_LU:/var/www/jukungbulik/
```

**Cara B — Pakai FileZilla (GUI):**
1. Buka FileZilla, masukkan Host: `IP_VPS`, User: `root`, Port: `22`.
2. Navigasi ke `/var/www/jukungbulik/` di sisi remote.
3. Upload semua file KECUALI yang ada di daftar larangan di atas.

**3. Install dependencies di VPS:**
```bash
cd /var/www/jukungbulik

# Install dependency Laravel (tanpa package dev/testing)
composer install --optimize-autoloader --no-dev
```

---

## ⚙️ Tahap 4: Konfigurasi .env

```bash
# Copy template .env
cp .env.example .env

# Edit dengan nano
nano .env
```

Ubah baris-baris berikut sesuai server lu:

```env
APP_NAME="Jukung Bulik"
APP_ENV=production
APP_DEBUG=false                          # ← WAJIB false di production!
APP_URL=https://domain-lu.com            # ← Ganti dengan domain lu
APP_TIMEZONE=Asia/Makassar

# Database (sesuaikan dengan yang dibuat di Tahap 2)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jukungbulik_db
DB_USERNAME=jukung_user
DB_PASSWORD=PasswordSuperKuat123!        # ← Password DB yang lu buat tadi

# Session & Queue
SESSION_DRIVER=database
QUEUE_CONNECTION=database                # ← WAJIB database, bukan sync
CACHE_STORE=database

# Xendit Payment (dari dashboard Xendit)
XENDIT_SECRET_KEY=xnd_production_xxx     # ← Secret key PRODUCTION
XENDIT_WEBHOOK_TOKEN=xxx                 # ← Webhook verification token

# Fonnte WhatsApp
FONNTE_TOKEN=xxx                         # ← Token dari Fonnte

# Email SMTP (contoh pakai Resend)
MAIL_MAILER=smtp
MAIL_HOST=smtp.resend.com
MAIL_PORT=465
MAIL_USERNAME=resend
MAIL_PASSWORD=re_xxx                     # ← API key Resend
MAIL_ENCRYPTION=smtps
MAIL_FROM_ADDRESS="tiket@domain-lu.com"
MAIL_FROM_NAME="Tiket Jukung Bulik"

# Admin Panel
FILAMENT_ADMIN_EMAIL=admin@jukungbulik.id
FILAMENT_ADMIN_PASSWORD=PasswordAdminKuatBgt!  # ← GANTI! Jangan "password"!
FILAMENT_PATH=admin                      # ← Bisa diganti jadi path rahasia, misal: "kelola-tiket"

# Session Security (WAJIB untuk production)
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=strict

# Log Level
LOG_CHANNEL=stack
LOG_LEVEL=error                          # ← Hanya log error di production
```

Simpan file (Ctrl+O, Enter, Ctrl+X).

```bash
# Generate App Key
php artisan key:generate

# Jalankan migrasi database
php artisan migrate --force

# Seed data awal (admin user, kategori tiket, periode presale)
php artisan db:seed --force

# Optimasi cache Laravel (WAJIB untuk production!)
php artisan optimize
php artisan view:cache
php artisan filament:optimize
```

> ⚠️ **PENTING:** Setelah selesai setup, JANGAN biarkan `FILAMENT_ADMIN_PASSWORD=password`. Ganti dengan password yang kuat. Hanya email yang tercantum di `FILAMENT_ADMIN_EMAIL` yang bisa login ke admin panel.

---

## 🌐 Tahap 5: Setup Nginx & Domain

### 1. Arahkan Domain ke VPS

Di penyedia domain lu (Niagahoster/Idwebhost/Namecheap/dll):
- Buat **A Record**: `@` → `IP_VPS_LU`
- Buat **A Record**: `www` → `IP_VPS_LU`

> Propagasi DNS bisa makan waktu 5 menit - 24 jam.

### 2. Buat Konfigurasi Nginx

```bash
sudo nano /etc/nginx/sites-available/jukungbulik
```

Paste konfigurasi berikut (ganti `domain-lu.com`):

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name domain-lu.com www.domain-lu.com;
    root /var/www/jukungbulik/public;
    index index.php;
    charset utf-8;

    # === Security Headers ===
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;

    # === Sembunyikan versi Nginx (anti fingerprinting) ===
    server_tokens off;

    # === Gzip Compression (hemat bandwidth 70%) ===
    gzip on;
    gzip_vary on;
    gzip_min_length 1024;
    gzip_proxied any;
    gzip_types text/plain text/css text/xml text/javascript
               application/javascript application/x-javascript
               application/xml application/json;
    gzip_disable "MSIE [1-6]\.";

    # === Limit Upload Size (cegah abuse upload file gede) ===
    client_max_body_size 10M;

    # === Limit Request Rate di Level Nginx (anti-DDoS layer 1) ===
    # Didefinisikan di http block (lihat langkah 3 di bawah)

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # === Cache Aset Statis (bikin loading instan) ===
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|webp|svg|woff|woff2|ttf|eot)$ {
        expires 365d;
        add_header Cache-Control "public, no-transform";
        access_log off;
        log_not_found off;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    # === PHP Processing ===
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;

        # Timeout untuk request berat (webhook, PDF generation)
        fastcgi_read_timeout 120s;
    }

    # === Blokir Akses ke File Tersembunyi (.env, .git, dll) ===
    location ~ /\.(?!well-known).* {
        deny all;
    }

    # === Blokir Akses Langsung ke File Sensitif ===
    location ~* (\.env|\.log|composer\.json|composer\.lock|package\.json) {
        deny all;
        return 404;
    }
}
```

### 3. Tambahkan Rate Limiting di Level Nginx

```bash
sudo nano /etc/nginx/nginx.conf
```

Tambahkan ini di dalam block `http { }` (sebelum `include`):

```nginx
    # Rate limiting zones
    limit_req_zone $binary_remote_addr zone=general:10m rate=10r/s;
    limit_req_zone $binary_remote_addr zone=login:10m rate=3r/m;
```

### 4. Aktifkan Site & Restart

```bash
# Hapus default site
sudo rm /etc/nginx/sites-enabled/default

# Aktifkan site Jukung Bulik
sudo ln -s /etc/nginx/sites-available/jukungbulik /etc/nginx/sites-enabled/

# Set permission file
sudo chown -R www-data:www-data /var/www/jukungbulik
sudo chmod -R 755 /var/www/jukungbulik
sudo chmod -R 775 /var/www/jukungbulik/storage /var/www/jukungbulik/bootstrap/cache

# Test konfigurasi Nginx
sudo nginx -t

# Restart Nginx
sudo systemctl restart nginx
```

---

## 🔒 Tahap 6: Pasang SSL (HTTPS)

> **WAJIB!** Tanpa SSL, data pembeli (nama, email, WhatsApp) bisa disadap.

```bash
# Install Certbot via Snap
sudo snap install --classic certbot
sudo ln -s /snap/bin/certbot /usr/bin/certbot

# Dapatkan & pasang SSL otomatis
sudo certbot --nginx -d domain-lu.com -d www.domain-lu.com

# Verifikasi auto-renewal berjalan
sudo certbot renew --dry-run
```

> Certbot otomatis memodifikasi config Nginx untuk redirect HTTP → HTTPS dan auto-renew sertifikat setiap 60-90 hari.

---

## 👷 Tahap 7: Setup Queue Worker (Supervisor)

Queue worker **WAJIB** jalan agar email tiket PDF dan notifikasi WhatsApp terkirim setelah pembayaran lunas.

```bash
# Install Supervisor
sudo apt install supervisor -y

# Copy config dari project
sudo cp /var/www/jukungbulik/deployment/supervisor/jukungbulik-worker.conf /etc/supervisor/conf.d/

# Edit path jika perlu
sudo nano /etc/supervisor/conf.d/jukungbulik-worker.conf
```

Pastikan isinya seperti ini (sudah ada di project):
```ini
[program:jukungbulik-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/jukungbulik/artisan queue:work --queue=notifications,emails,default --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/jukungbulik/storage/logs/worker.log
stopwaitsecs=3600
```

```bash
# Load & start worker
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start jukungbulik-worker:*

# Verifikasi jalan
sudo supervisorctl status
# Output harus: jukungbulik-worker:xxx  RUNNING
```

---

## 🛡️ Tahap 8: Setup Cloudflare (Anti-DDoS)

Cloudflare adalah **WAJIB** — ini pertahanan utama terhadap serangan DDoS. Tanpa Cloudflare, IP VPS lu terbuka dan bisa diserang langsung.

### Langkah Setup:

1. **Daftar** di [dash.cloudflare.com](https://dash.cloudflare.com) (GRATIS).
2. **Tambahkan domain** lu.
3. **Ganti Nameserver** di penyedia domain ke Nameserver Cloudflare yang diberikan.
4. **Tunggu propagasi** (5 menit – 24 jam).

### Konfigurasi Keamanan Cloudflare:

| Menu | Setting | Nilai |
|:-----|:--------|:------|
| **SSL/TLS** | Mode | **Full (Strict)** — karena kita sudah pasang SSL di VPS |
| **SSL/TLS → Edge Certificates** | Always Use HTTPS | ✅ ON |
| **SSL/TLS → Edge Certificates** | Minimum TLS Version | **TLS 1.2** |
| **Security → Settings** | Security Level | **High** |
| **Security → Settings** | Challenge Passage | **30 minutes** |
| **Security → Settings** | Browser Integrity Check | ✅ ON |
| **Security → Bots** | Bot Fight Mode | ✅ ON |
| **Speed → Optimization** | Auto Minify | ✅ CSS, JS, HTML |
| **Caching → Configuration** | Browser Cache TTL | **4 hours** |

### Jika Ada Serangan DDoS:

1. Masuk ke Cloudflare Dashboard → **Security → Settings**.
2. Nyalakan **"I'm Under Attack Mode"** — ini akan menampilkan challenge page ke semua pengunjung selama 5 detik.
3. Setelah serangan reda, matikan kembali ke **High**.

> **💡 Tips:** Setelah Cloudflare aktif, **ubah `trustProxies` di VPS** agar hanya trust IP Cloudflare. IP Cloudflare bisa dilihat di: https://www.cloudflare.com/ips/

---

## 🏰 Tahap 9: Security Hardening VPS (Anti-Hack)

### 9.1 — Buat User Non-Root

**JANGAN** pakai root untuk operasional sehari-hari!

```bash
# Buat user baru
adduser deployer

# Kasih akses sudo
usermod -aG sudo deployer

# Copy SSH key dari root ke user baru
mkdir -p /home/deployer/.ssh
cp /root/.ssh/authorized_keys /home/deployer/.ssh/
chown -R deployer:deployer /home/deployer/.ssh
chmod 700 /home/deployer/.ssh
chmod 600 /home/deployer/.ssh/authorized_keys

# Test login (di terminal baru, JANGAN tutup yang lama)
ssh deployer@IP_VPS_LU
```

### 9.2 — Hardening SSH (Anti Brute-Force)

```bash
sudo nano /etc/ssh/sshd_config
```

Ubah/tambahkan baris berikut:
```
# Matikan login root via SSH
PermitRootLogin no

# Matikan login pakai password (hanya SSH key)
PasswordAuthentication no

# Matikan autentikasi yang gak perlu
KbdInteractiveAuthentication no
UsePAM yes

# Timeout koneksi idle
ClientAliveInterval 300
ClientAliveCountMax 2

# Batasi user yang boleh SSH
AllowUsers deployer
```

```bash
# Restart SSH (JANGAN tutup terminal yang aktif sebelum test!)
sudo systemctl restart sshd

# Test di terminal BARU
ssh deployer@IP_VPS_LU
```

> ⚠️ **HATI-HATI!** Kalau salah konfigurasi, lu bisa terkunci dari VPS. Selalu test di terminal baru sebelum tutup terminal lama.

### 9.3 — Setup Firewall (UFW)

```bash
# Reset rules
sudo ufw reset

# Default: tolak semua incoming, izinkan semua outgoing
sudo ufw default deny incoming
sudo ufw default allow outgoing

# Izinkan SSH (WAJIB sebelum enable UFW!)
sudo ufw allow ssh

# Izinkan HTTP & HTTPS (untuk Nginx)
sudo ufw allow 'Nginx Full'

# Aktifkan firewall
sudo ufw enable

# Verifikasi
sudo ufw status verbose
```

Output yang benar:
```
Status: active
Default: deny (incoming), allow (outgoing)

To                         Action      From
--                         ------      ----
22/tcp                     ALLOW       Anywhere
80,443/tcp (Nginx Full)    ALLOW       Anywhere
```

### 9.4 — Install Fail2ban (Anti Brute-Force Otomatis)

Fail2ban otomatis memblokir IP yang gagal login berkali-kali.

```bash
# Install
sudo apt install fail2ban -y

# Buat konfigurasi lokal
sudo cp /etc/fail2ban/jail.conf /etc/fail2ban/jail.local
sudo nano /etc/fail2ban/jail.local
```

Ubah/tambahkan di bagian `[DEFAULT]`:
```ini
[DEFAULT]
bantime = 3600          # Ban 1 jam
findtime = 600          # Dalam window 10 menit
maxretry = 5            # Setelah 5 kali gagal
banaction = ufw         # Pakai UFW untuk ban

[sshd]
enabled = true
port = ssh
maxretry = 3            # SSH lebih ketat: 3x gagal = ban
bantime = 86400         # Ban 24 jam untuk SSH

[nginx-http-auth]
enabled = true

[nginx-limit-req]
enabled = true
```

```bash
# Restart Fail2ban
sudo systemctl restart fail2ban
sudo systemctl enable fail2ban

# Cek status
sudo fail2ban-client status sshd
```

### 9.5 — Auto Security Updates

```bash
# Install unattended upgrades
sudo apt install unattended-upgrades -y

# Aktifkan
sudo dpkg-reconfigure -plow unattended-upgrades
# Pilih "Yes"
```

Ini memastikan patch keamanan Ubuntu ter-install otomatis.

### 9.6 — Amankan MySQL

```bash
sudo mysql_secure_installation
```

Jawab:
- **VALIDATE PASSWORD component:** `Y`
- **Password strength:** `2` (STRONG)
- **Remove anonymous users:** `Y`
- **Disallow root login remotely:** `Y`
- **Remove test database:** `Y`
- **Reload privilege tables:** `Y`

---

## 🔑 Panduan Setup API & Integrasi

### 1. Setup Xendit (Payment Gateway)

1. Daftar di [xendit.co](https://xendit.co/) dan selesaikan KYC.
2. Di Dashboard Xendit:
   - Copy **Secret Key** dari menu Settings → API Keys.
   - Masukkan ke `.env`: `XENDIT_SECRET_KEY=xnd_production_xxxx`
3. Setup Webhook:
   - Masuk menu **Settings → Webhooks**.
   - Set **Webhook URL**: `https://domain-lu.com/webhook/xendit`
   - Centang event: **Invoice Paid**
   - Copy **Webhook Verification Token**.
   - Masukkan ke `.env`: `XENDIT_WEBHOOK_TOKEN=xxxx`

> **🔒 Keamanan Webhook Xendit yang sudah diterapkan:**
> - ✅ Validasi `x-callback-token` header (timing-safe comparison via `hash_equals`)
> - ✅ Whitelist IP Xendit (16 IP terdaftar)
> - ✅ Verifikasi amount (`paid_amount` == `order.total_price`)
> - ✅ Idempotency check (mencegah double-processing)
> - ✅ Database transaction + row locking (mencegah race condition)

### 2. Setup Fonnte (Notifikasi WhatsApp)

1. Daftar di [fonnte.com](https://fonnte.com/).
2. Koneksikan nomor WhatsApp (Scan QR).
3. Copy **Token** dari menu API.
4. Masukkan ke `.env`: `FONNTE_TOKEN=xxxx`

### 3. Setup Email SMTP

PDF Tiket di-generate otomatis dan dikirim via email setelah pembayaran lunas.

**Opsi A — Resend (Rekomendasi):**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.resend.com
MAIL_PORT=465
MAIL_USERNAME=resend
MAIL_PASSWORD=re_xxxx_api_key_lu
MAIL_ENCRYPTION=smtps
MAIL_FROM_ADDRESS="tiket@domain-lu.com"
MAIL_FROM_NAME="Tiket Jukung Bulik"
```

**Opsi B — Gmail (pakai App Password):**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=email-lu@gmail.com
MAIL_PASSWORD=xxxx_xxxx_xxxx_xxxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="email-lu@gmail.com"
MAIL_FROM_NAME="Tiket Jukung Bulik"
```

**Opsi C — Brevo/Sendinblue (Gratis 300 email/hari):**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp-relay.brevo.com
MAIL_PORT=587
MAIL_USERNAME=email-lu@gmail.com
MAIL_PASSWORD=smtp_key_dari_brevo
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="tiket@domain-lu.com"
MAIL_FROM_NAME="Tiket Jukung Bulik"
```

---

## 🛡️ Jaminan Keamanan Sistem (Security Architecture)

Website ini dibangun dengan **pertahanan berlapis** (defense-in-depth):

### Layer 1: Anti-DDoS (Cloudflare)
| Serangan | Perlindungan |
|:---------|:-------------|
| DDoS L3/L4 (volumetric) | Cloudflare proxy menyerap traffic sebelum sampai VPS |
| DDoS L7 (HTTP flood) | Cloudflare WAF + Rate Limiting + Under Attack Mode |
| IP scanning | IP asli VPS tersembunyi di balik Cloudflare |

### Layer 2: Anti-Brute-Force (Server Level)
| Serangan | Perlindungan |
|:---------|:-------------|
| SSH brute-force | Fail2ban (3x gagal = ban 24 jam) + SSH key only |
| Admin login brute-force | Filament rate limit (3 attempt/60 detik) |
| Ticket purchase spam | Rate limit per IP (5/menit), per email (3/menit), per WhatsApp (3/menit) |
| Port scanning | UFW firewall — hanya port 22, 80, 443 terbuka |

### Layer 3: Anti-Cheating (Application Level)
| Serangan | Perlindungan |
|:---------|:-------------|
| Manipulasi harga via DevTools | ❌ **Tidak mungkin** — harga dihitung 100% server-side dari database. Form hanya kirim `nama`, `email`, `whatsapp`, `category_id`, `quantity` |
| Webhook palsu | Validasi `x-callback-token` (timing-safe) + IP whitelist 16 IP Xendit |
| Webhook dengan jumlah palsu | Verifikasi `amount` di webhook harus **sama persis** dengan `total_price` di database |
| Overselling tiket (race condition) | `DB::transaction()` + `lockForUpdate()` pada row kategori tiket |
| Double payment processing | `DB::transaction()` + `lockForUpdate()` pada row order |
| Double scan tiket | `DB::transaction()` + `lockForUpdate()` pada row order |
| Mass-assignment attack | Field sensitif (`payment_status`, `scan_status`) **dikeluarkan** dari `$fillable` |
| Unauthorized admin access | Hanya email yang tercantum di `FILAMENT_ADMIN_EMAIL` yang bisa login |

### Layer 4: Anti-Injection & XSS (Framework Level)
| Serangan | Perlindungan |
|:---------|:-------------|
| SQL Injection | Eloquent ORM (PDO prepared statements) — tidak ada raw SQL |
| XSS (Cross-Site Scripting) | Blade `{{ }}` auto-escape — tidak ada `{!! !!}` |
| CSRF | Token CSRF di semua form (kecuali webhook yang divalidasi token sendiri) |
| Clickjacking | Header `X-Frame-Options: SAMEORIGIN` |
| MIME sniffing | Header `X-Content-Type-Options: nosniff` |
| Session hijacking | `SESSION_SECURE_COOKIE=true` + `SESSION_SAME_SITE=strict` + `httpOnly` |
| File `.env` diakses | Nginx deny rule + Laravel `.htaccess` |

### Layer 5: Kriptografi & Secret Management
| Aspek | Implementasi |
|:------|:-------------|
| API Keys | Disimpan di `.env` (server-side only), TIDAK pernah di-expose ke frontend |
| Password admin | Di-hash menggunakan bcrypt (one-way hash) |
| Session | Encrypted, JSON serialization (bukan PHP serialize — mencegah gadget chain) |
| SSL/TLS | HTTPS wajib via Certbot + Cloudflare Full Strict |
| Webhook token comparison | `hash_equals()` — timing-safe, mencegah timing attack |

---

## 🎨 Panduan Kustomisasi Konten & Gambar

### 1. Kustomisasi Gambar

Semua aset gambar ada di folder `public/`:
- **Background Hero**: Ganti `public/hero-bg.jpg` (resolusi 1920x1080, max 500KB).
- **Logo**: Ganti `public/logo.png` dan `public/favicon.ico`.
- **Galeri**: Taruh foto di `public/gallery/`, panggil di `gallery.blade.php` dengan `{{ asset('gallery/foto-1.jpg') }}`.

### 2. Kustomisasi Teks

File tampilan ada di `resources/views/pages/`:

| Halaman | File |
|:--------|:-----|
| Beranda | `resources/views/pages/home.blade.php` |
| Tentang Kami | `resources/views/pages/about.blade.php` |
| Galeri | `resources/views/pages/gallery.blade.php` |
| Kontak | `resources/views/pages/contact.blade.php` |
| Beli Tiket | `resources/views/pages/ticket.blade.php` |

### 3. Mengubah WhatsApp & Link Sosmed

- Nomor WA CS: Edit di `resources/views/layouts/app.blade.php`, cari `wa.me/62xxx`.
- Username sosmed: Edit di `resources/views/pages/contact.blade.php`.

### 4. Mengubah Daftar Sponsor

Edit `resources/views/components/sponsors.blade.php`:
```php
$sponsors = [
    ['name' => 'Nama Sponsor', 'url' => 'https://link.com', 'img' => '/images/logo.png'],
    // Tambah/kurangi sesuka hati
];
```

---

## 🔄 Update & Maintenance

### Deploy Update Baru

```bash
# Login ke VPS
ssh deployer@IP_VPS_LU

# Masuk ke folder project
cd /var/www/jukungbulik

# Upload file baru (dari laptop)
# Kemudian di VPS:
composer install --optimize-autoloader --no-dev
php artisan migrate --force
php artisan optimize
php artisan view:cache
php artisan filament:optimize

# Restart queue worker
sudo supervisorctl restart jukungbulik-worker:*
```

### Cek Log Error

```bash
# Log Laravel
tail -f /var/www/jukungbulik/storage/logs/laravel.log

# Log Queue Worker
tail -f /var/www/jukungbulik/storage/logs/worker.log

# Log Nginx
tail -f /var/log/nginx/error.log
```

### Backup Database

```bash
# Backup manual
mysqldump -u jukung_user -p jukungbulik_db > backup_$(date +%Y%m%d).sql

# Otomatis tiap hari via cron
crontab -e
# Tambahkan:
0 3 * * * mysqldump -u jukung_user -pPasswordLu jukungbulik_db > /var/backups/jukungbulik_$(date +\%Y\%m\%d).sql
```

---

## ❓ Troubleshooting

| Masalah | Solusi |
|:--------|:-------|
| **502 Bad Gateway** | Restart PHP-FPM: `sudo systemctl restart php8.4-fpm` |
| **Permission denied di storage** | `sudo chown -R www-data:www-data storage bootstrap/cache` |
| **Email/WA gak terkirim** | Cek worker: `sudo supervisorctl status`. Kalau mati: `sudo supervisorctl start jukungbulik-worker:*` |
| **CSS/JS gak ke-load** | Pastikan `npm run build` sudah dijalankan di laptop dan folder `public/build/` ter-upload |
| **Halaman blank putih** | Cek log: `tail -f storage/logs/laravel.log` |
| **Admin gak bisa login** | Pastikan email yang dipakai login sama dengan `FILAMENT_ADMIN_EMAIL` di `.env` |
| **Webhook Xendit gagal** | Cek URL webhook di dashboard Xendit, pastikan domain sudah HTTPS |
| **Terkunci dari VPS (SSH)** | Gunakan Console/VNC dari dashboard VPS provider |

---

**🎉 Selesai!** Website Jukung Bulik sekarang sudah live, aman, dan siap jualan tiket.

**Ringkasan Pertahanan Keamanan:**
- ✅ **Anti-DDoS** — Cloudflare + Nginx rate limiting
- ✅ **Anti-Hack** — UFW firewall + Fail2ban + SSH key only
- ✅ **Anti-Cheat** — Server-side price calculation + amount verification + database locking
- ✅ **Anti-Brute-Force** — Rate limiting berlapis (Cloudflare → Nginx → Laravel → Filament)
- ✅ **Anti-Injection** — Eloquent ORM + Blade auto-escape + CSRF protection
- ✅ **Anti-Forgery** — Webhook token validation (timing-safe) + IP whitelist
