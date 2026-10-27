# PANDUAN DEPLOYMENT SISTEM MESS FR ACADEMY
**Domain Target:** `https://mess-academy.first-resources.com`  
**Framework:** Laravel 13 (PHP 8.3 / 8.4) & Livewire 4  
**Database:** MySQL / MariaDB  

Dokumen ini ditujukan untuk **Tim IT / DevOps First Resources** sebagai panduan teknis deployment ke server produksi.

---

## 1. Kebutuhan Server (System Requirements)

- **Sistem Operasi:** Linux Ubuntu Server 22.04 LTS / 24.04 LTS (disarankan) atau RHEL/AlmaLinux
- **Web Server:** Nginx (disarankan) atau Apache
- **PHP Version:** **PHP 8.3 atau 8.4**
- **Ekstensi PHP Wajib:**
  - `php-fpm`, `php-mysql`, `php-mbstring`, `php-xml`, `php-bcmath`
  - `php-curl`, `php-zip`, `php-gd`, `php-intl`, `php-sqlite3` (opsional)
- **Database:** MySQL 8.0+ / MariaDB 10.6+
- **Memory:** Minimum 2 GB RAM (disarankan 4 GB)
- **SSL Certificate:** HTTPS aktif (Let's Encrypt / DigiCert / Cloudflare Flexible/Full SSL)

---

## 2. Struktur Paket Zip & Catatan Aset

Paket deployment ini sudah dilengkapi:
- Seluruh kode backend Laravel & konfigurasi siap pakai.
- **Folder `vendor/` sudah disertakan** (kompatibel multiplatform, tidak wajib menjalankan `composer install` jika koneksi server terbatas).
- **Aset frontend sudah dikompilasi (`public/build`)**, sehingga server produksi **TIDAK MEMERLUKAN** Node.js / NPM.
- Folder `node_modules` telah di-exclude agar ukuran zip ringkas.

---

## 3. Langkah-Langkah Deployment (Step-by-Step)

### Langkah 1: Ekstrak File ke Direktori Web
Ekstrak arsip zip ke direktori web server, misalnya `/var/www/mess-academy`:

```bash
sudo mkdir -p /var/www/mess-academy
sudo unzip fr-academy-mess-deploy.zip -d /var/www/mess-academy
cd /var/www/mess-academy
```

---

### Langkah 2: Konfigurasi Environment (`.env`)
Salin file `.env.example` ke `.env` (atau edit file `.env` yang sudah disertakan):

```bash
cp .env.example .env
nano .env
```

Periksa dan sesuaikan variabel utama berikut:

```env
APP_NAME="Mess FR Academy"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://mess-academy.first-resources.com

APP_TIMEZONE=Asia/Jakarta
APP_LOCALE=id

# KREDENSIAL DATABASE PRODUKSI
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_mess_academy
DB_USERNAME=user_database_produksi
DB_PASSWORD=password_database_produksi

# KEAMANAN SESSION & COOKIE
SESSION_DRIVER=database
SESSION_SECURE_COOKIE=true
SESSION_DOMAIN=null

FILESYSTEM_DISK=public
QUEUE_CONNECTION=database
CACHE_STORE=database

# CLOUDFLARE TURNSTILE (CAPTCHA LOGIN ADMIN)
# Daftarkan domain 'mess-academy.first-resources.com' pada Cloudflare Dashboard jika ingin key baru
TURNSTILE_SITE_KEY=0x4AAAAAAEzPGJLBNyo86KAl
TURNSTILE_SECRET_KEY=0x4AAAAAAEzPGKSsKiRsoVbsX1tzF-N7x8k
```

> **Catatan Kunci Enkripsi (`APP_KEY`):**  
> Jika `APP_KEY` masih kosong, jalankan:
> ```bash
> php artisan key:generate
> ```

---

### Langkah 3: Izin Direktori (Permissions)
Web server (misal `www-data` atau `nginx`) wajib memiliki hak akses tulis pada folder `storage` dan `bootstrap/cache`:

```bash
sudo chown -R www-data:www-data /var/www/mess-academy
sudo find /var/www/mess-academy -type d -exec chmod 755 {} \;
sudo find /var/www/mess-academy -type f -exec chmod 644 {} \;
sudo chmod -R 775 /var/www/mess-academy/storage
sudo chmod -R 775 /var/www/mess-academy/bootstrap/cache
```

---

### Langkah 4: Tautkan Storage (Storage Link)
Buat symlink publik untuk penyimpanan file bukti foto komplain & kebersihan:

```bash
# Hapus symlink lama jika terbawa dari environment Windows
rm -f public/storage

# Buat symlink baru
php artisan storage:link
```

---

### Langkah 5: Migrasi & Database Seeding
Jalankan migrasi database:

```bash
php artisan migrate --force
```

*(Opsional)* Jika database baru dan ingin mengisi akun default peran admin (Superadmin, Koordinator Mess, Tim Kebersihan, Staf Dapur, Teknisi, Staf Laundry, Kepala TU) dan data master kamar/aset:
```bash
php artisan db:seed --force
```

> **Daftar Akun Default (setelah seeding):**
> - Admin Utama: `superadmin@fracademy.test` (Password: `password`)
> - Koordinator Mess: `koordinator@fracademy.test` (Password: `password`)
> - Staf Kebersihan: `kebersihan@fracademy.test` (Password: `password`)
> - Staf Dapur: `dapur@fracademy.test` (Password: `password`)
> - Teknisi (Pak Tepung): `teknisi@fracademy.test` (Password: `password`)
> - Staf Laundry: `laundry@fracademy.test` (Password: `password`)
> - Kepala TU: `kepalatu@fracademy.test` (Password: `password`)
> *(Segera ubah password setelah login pertama via menu Manajemen Akun)*

---

### Langkah 6: Optimasi Performa (Production Caching)
Jalankan cache configuration, routes, dan views untuk performa maksimal:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 4. Contoh Konfigurasi Nginx Server Block

Simpan pada `/etc/nginx/sites-available/mess-academy`:

```nginx
server {
    listen 80;
    server_name mess-academy.first-resources.com;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl http2;
    server_name mess-academy.first-resources.com;
    root /var/www/mess-academy/public;

    # SSL Certificate
    ssl_certificate /etc/ssl/certs/mess-academy.crt;
    ssl_certificate_key /etc/ssl/private/mess-academy.key;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;

    index index.php index.html;
    charset utf-8;

    # Ukuran maksimum upload (disesuaikan dengan kebutuhan upload foto kamera komplain 20MB)
    client_max_body_size 25M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock; # Sesuaikan versi PHP
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
        fastcgi_buffer_size 128k;
        fastcgi_buffers 4 256k;
        fastcgi_busy_buffers_size 256k;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Proxy Headers untuk HTTPS Termination
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header X-Forwarded-Proto https;
    proxy_set_header Host $host;
}
```

Aktifkan konfigurasi dan reload Nginx:
```bash
sudo ln -s /etc/nginx/sites-available/mess-academy /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

---

## 5. Background Jobs & Worker (Opsional / Disarankan)

Sistem menggunakan queue database untuk notifikasi. Jalankan worker menggunakan `systemd` atau `supervisor`.

Contoh Supervisor config (`/etc/supervisor/conf.d/mess-worker.conf`):
```ini
[program:mess-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/mess-academy/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/mess-academy/storage/logs/worker.log
stopwaitsecs=3600
```

---

## 6. Troubleshooting Umum

1. **419 Page Expired / CSRF Error:**
   - Pastikan `SESSION_DOMAIN=null` pada `.env` jika menggunakan subdomain tunggal.
   - Pastikan akses menggunakan protokol `https://` yang sama dengan `APP_URL`.
2. **Foto Upload Tidak Tampil (404 Not Found):**
   - Hapus symlink lama dan jalankan `php artisan storage:link`.
   - Pastikan permission folder `storage/app/public` writeable (775) oleh user `www-data`.
3. **Cloudflare Turnstile Gagal / Error Domain:**
   - Kunci Turnstile terikat pada domain asal. Daftarkan hostname `mess-academy.first-resources.com` di Cloudflare Dashboard -> Turnstile Sites, lalu masukkan `Site Key` dan `Secret Key` baru ke file `.env`.
4. **Mixed Content Warning:**
   - Aplikasi sudah dilengkapi pemaksaan HTTPS otomatis melalui reverse proxy dan `URL::forceScheme('https')` di `AppServiceProvider.php`. Pastikan reverse proxy meneruskan header `X-Forwarded-Proto https`.
