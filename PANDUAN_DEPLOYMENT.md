# PANDUAN DEPLOYMENT SISTEM MESS FR ACADEMY (PRODUKSI)
**Domain Target:** `https://mess-academy.first-resources.com`  
**Framework:** Laravel 13 (PHP 8.3 / 8.4) & Livewire 4  
**Database:** MySQL 8.0+ / MariaDB 10.6+  
**Web Server:** Nginx (Reverse Proxy + PHP-FPM)  

Dokumen ini ditujukan untuk **Tim IT / DevOps First Resources** sebagai panduan teknis deployment ke server produksi. Panduan ini telah diperbarui berdasarkan seluruh skenario dan pengujian nyata di lingkungan server FR Academy.

---

## 1. Kebutuhan Server (System Requirements)

- **Sistem Operasi:** Linux Ubuntu Server 20.04 / 22.04 / 24.04 LTS atau RHEL / AlmaLinux
- **Web Server:** Nginx
- **PHP Version:** **PHP 8.3 atau 8.4**
- **Ekstensi PHP Wajib:**
  - `php-fpm`, `php-mysql`, `php-mbstring`, `php-xml`, `php-bcmath`
  - `php-curl`, `php-zip`, `php-gd`, `php-intl`
  > **Catatan Ekstensi `php-gd`:**  
  > Ekstensi `php-gd` wajib aktif agar sistem dapat mencetak laporan PDF yang memuat logo perusahaan (`logofr.png`). Barcode ruangan dan e-ticket tamu telah menggunakan format **vektor SVG**, sehingga hasil cetak barcode tetap sangat tajam dan tidak pecah.
- **Database:** MySQL 8.0+ atau MariaDB 10.6+
- **SSL Certificate:** Sertifikat SSL Wildcard First Resources (`*.first-resources.com`) atau Let's Encrypt / DigiCert.
- **DNS Record:** Pastikan A-Record `mess-academy.first-resources.com` sudah diarahkan ke IP server produksi (misal `10.121.1.17` pada DNS internal perusahaan).

---

## 2. Struktur Paket & Catatan Dependensi

Paket deployment ini sudah disiapkan agar **langsung siap dijalankan tanpa build tool**:
1. **Frontend Assets Sudah Di-build (`public/build`)**: Server produksi **TIDAK MEMERLUKAN** Node.js atau NPM.
2. **Folder `vendor/` Sudah Disertakan**: Kompatibel multiplatform, sehingga tidak wajib menjalankan `composer install` jika koneksi internet server dibatasi.
3. **Penyimpanan Storage**: Symlink `public/storage` dibuat di server menggunakan perintah artisan standar.

---

## 3. Langkah-Langkah Deployment (Step-by-Step)

### OPSI A: Deployment Menggunakan File ZIP
Jika mentransfer file zip (`fr-academy-mess-deploy.zip`) ke server:

```bash
# 1. Buat direktori dan ekstrak file
sudo mkdir -p /var/www/fr-academy-mess
sudo unzip fr-academy-mess-deploy.zip -d /var/www/fr-academy-mess
cd /var/www/fr-academy-mess
```

### OPSI B: Deployment Menggunakan Git (Paling Praktis)
Jika server memiliki akses ke repository GitHub:

```bash
cd /var/www
git clone https://github.com/dzakwan24si/fr-academy-mess.git
cd fr-academy-mess
```

---

### Langkah 1: Persiapan Database MySQL / MariaDB (PENTING)

> [!WARNING]
> **PERINGATAN KHUSUS MULTI-APLIKASI (JIKA BERDAMPINGAN DENGAN PORTAL):**  
> Jika server produksi sudah menjalankan sistem Portal (`academy.first-resources.com`) dan menggunakan user database yang sama (misal `db_user`), **JANGAN mengubah password user tersebut**. Cukup berikan izin hak akses ke database baru `db_mess_academy`.

#### Masuk ke MySQL / MariaDB Server:
```bash
sudo mysql
```

#### Jalankan perintah SQL berikut:
```sql
-- 1. Buat database baru khusus sistem Mess
CREATE DATABASE IF NOT EXISTS db_mess_academy CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- 2A. OPSI REKOMENDASI: Gunakan user yang sama dengan Portal (tanpa ubah password)
-- Cukup berikan izin akses ke db_mess_academy untuk localhost dan 127.0.0.1
GRANT ALL PRIVILEGES ON db_mess_academy.* TO 'db_user'@'localhost';
GRANT ALL PRIVILEGES ON db_mess_academy.* TO 'db_user'@'127.0.0.1';

-- 2B. OPSI ALTERNATIF: Buat user database baru terpisah khusus Mess
-- CREATE USER IF NOT EXISTS 'mess_user'@'localhost' IDENTIFIED BY 'PasswordKuat2026!';
-- CREATE USER IF NOT EXISTS 'mess_user'@'127.0.0.1' IDENTIFIED BY 'PasswordKuat2026!';
-- GRANT ALL PRIVILEGES ON db_mess_academy.* TO 'mess_user'@'localhost';
-- GRANT ALL PRIVILEGES ON db_mess_academy.* TO 'mess_user'@'127.0.0.1';

-- 3. Terapkan perubahan hak akses
FLUSH PRIVILEGES;
EXIT;
```

---

### Langkah 2: Konfigurasi Environment (`.env`)

Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
nano .env
```

Sesuaikan baris-baris konfigurasi utama berikut:

```env
APP_NAME="Mess FR Academy"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://mess-academy.first-resources.com

APP_TIMEZONE=Asia/Jakarta
APP_LOCALE=id

# KREDENSIAL DATABASE
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_mess_academy
DB_USERNAME=db_user

# PENTING: Jika password mengandung tanda seru (!) atau karakter khusus, 
# WAJIB diapit tanda kutip dua ("") agar tidak terpotong oleh parser!
DB_PASSWORD="password_database_anda"

# KEAMANAN SESSION & COOKIE
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

FILESYSTEM_DISK=public
QUEUE_CONNECTION=database
CACHE_STORE=database

# CLOUDFLARE TURNSTILE (CAPTCHA LOGIN ADMIN)
# Key default sudah aktif untuk domain First Resources
TURNSTILE_SITE_KEY=0x4AAAAAAEzPGJLBNyo86KAl
TURNSTILE_SECRET_KEY=0x4AAAAAAEzPGKSsKiRsoVbsX1tzF-N7x8k
```

> **Simpan di nano:** Tekan `Ctrl + O` lalu `Enter`, kemudian keluar dengan `Ctrl + X`.

---

### Langkah 3: Generate Application Key
Jika `APP_KEY` pada file `.env` belum terisi, jalankan:
```bash
php artisan key:generate --force
```

---

### Langkah 4: Tautkan Storage (Storage Link)
Buat symlink publik untuk penyimpanan file bukti foto komplain & kebersihan:
```bash
# Hapus symlink lama jika ada
rm -f public/storage

# Buat symlink baru
php artisan storage:link
```

---

### Langkah 5: Migrasi Database & Seeding Data Awal

Jalankan migrasi tabel database:
```bash
php artisan migrate --force
```

Jalankan seeder akun peran admin & data kamar/aset awal:
```bash
php artisan db:seed --force
```

> **Daftar Akun Default (setelah seeding):**
> - **Superadmin (Admin Utama):** `superadmin@fracademy.test` (Password: `password`)
> - **Koordinator Mess:** `koordinator@fracademy.test` (Password: `password`)
> - **Tim Kebersihan:** `kebersihan@fracademy.test` (Password: `password`)
> - **Staf Dapur:** `dapur@fracademy.test` (Password: `password`)
> - **Teknisi (Maintenance):** `teknisi@fracademy.test` (Password: `password`)
> - **Staf Laundry:** `laundry@fracademy.test` (Password: `password`)
> - **Kepala TU:** `kepalatu@fracademy.test` (Password: `password`)  
> *(Pengguna dapat mengganti password setelah login via menu Manajemen Akun).*

---

### Langkah 6: Pengaturan Hak Akses Folder (Permissions)

Agar web server dan artisan command dapat menulis log, session, file upload, dan font cache DomPDF tanpa kendala *Permission Denied*:

```bash
sudo chown -R www-data:www-data /var/www/fr-academy-mess
sudo chmod -R 775 /var/www/fr-academy-mess/storage
sudo chmod -R 775 /var/www/fr-academy-mess/bootstrap/cache

# Jika tim teknis sering menjalankan artisan via akun SSH biasa,
# berikan hak akses tulis penuh pada storage dan cache:
sudo chmod -R 777 /var/www/fr-academy-mess/storage /var/www/fr-academy-mess/bootstrap/cache
```

---

### Langkah 7: Konfigurasi Nginx Virtual Host

> [!TIP]
> **TIPS MENGETAHUI SOCKET/PORT PHP-FPM & SSL SERVER:**  
> Untuk melihat alamat PHP-FPM dan letak sertifikat SSL yang sudah terbukti bekerja di server ini (milik Portal), jalankan:
> ```bash
> grep -rn "fastcgi_pass" /etc/nginx/sites-available/
> grep -rn "ssl_certificate" /etc/nginx/sites-available/
> ```

Buat file konfigurasi Nginx untuk domain Mess:
```bash
sudo nano /etc/nginx/sites-available/mess-academy
```

Isi konfigurasinya sebagai berikut:

```nginx
server {
    listen 80;
    server_name mess-academy.first-resources.com;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl http2;
    server_name mess-academy.first-resources.com;
    root /var/www/fr-academy-mess/public;

    # SERTIFIKAT SSL RESMI FIRST RESOURCES
    # (Samakan jalurnya dengan sertifikat Portal academy.first-resources.com)
    ssl_certificate /var/www/html/first-resources/first-resources_cert.crt;
    ssl_certificate_key /var/www/html/first-resources/first-resources_key.txt;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;

    index index.php index.html;
    charset utf-8;

    # Ukuran maksimum body request untuk upload foto komplain / bukti kebersihan
    client_max_body_size 25M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        # KONEKSI KE PHP-FPM:
        # Jika server menggunakan TCP port (standar port 9000):
        fastcgi_pass 127.0.0.1:9000;

        # ATAU jika server menggunakan Unix Socket (sesuaikan versinya):
        # fastcgi_pass unix:/var/run/php/php8.4-fpm.sock;

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

    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header X-Forwarded-Proto https;
    proxy_set_header Host $host;
}
```

#### Aktifkan Konfigurasi & Reload Nginx:
```bash
sudo ln -sf /etc/nginx/sites-available/mess-academy /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```
*(Jika muncul `syntax is ok` dan `test is successful`, Nginx telah aktif)*.

---

### Langkah 8: Optimasi Performa Cache (Production)

Jalankan perintah ini di dalam direktori `/var/www/fr-academy-mess`:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Jika di masa mendatang ada perubahan kode atau update git, cukup jalankan:
```bash
git pull origin master
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan optimize
```

---

## 4. Panduan Troubleshooting (Berdasarkan Uji Nyata)

### 1. Error `502 Bad Gateway` saat membuka website
- **Penyebab:** Nilai `fastcgi_pass` pada file Nginx tidak cocok dengan service PHP-FPM server (misal di Nginx tertulis file `.sock` padahal PHP-FPM server mendengarkan port TCP `127.0.0.1:9000`).
- **Solusi:** Cek dengan perintah `grep -rn "fastcgi_pass" /etc/nginx/sites-available/academy.first-resources.com` dan samakan nilai `fastcgi_pass`-nya.

### 2. Error `1045 Access denied for user 'db_user'@'localhost'`
- **Penyebab 1:** Password database mengandung karakter `!` tetapi tidak diapit tanda kutip dua pada file `.env`.  
  *Solusi:* Ubah menjadi `DB_PASSWORD="password123!"`.
- **Penyebab 2:** User database belum diberi izin untuk host `127.0.0.1`.  
  *Solusi:* Jalankan query MariaDB: `GRANT ALL PRIVILEGES ON db_mess_academy.* TO 'db_user'@'127.0.0.1'; FLUSH PRIVILEGES;`.

### 3. Error `The PHP GD extension is required, but is not installed`
- **Penyebab:** Ekstensi PHP `gd` belum terpasang di sistem server.
- **Catatan:** Barcode ruangan (`/barcode/cetak`) dan E-Ticket sudah dikonversi menjadi **vektor SVG**, sehingga fitur barcode dijamin aman dan tetap bisa dicetak tajam tanpa `gd`.
- Namun untuk pencetakan dokumen PDF yang memuat logo PNG (`logofr.png` seperti Laporan Okupansi / Laporan Aset), pasang ekstensi GD:
  ```bash
  sudo apt-get install -y php-gd
  # Atau sesuaikan versi PHP: sudo apt-get install -y php8.4-gd
  ```

### 4. Domain tidak bisa dibuka (`DNS_PROBE_FINISHED_NXDOMAIN`)
- **Penyebab:** Hostname `mess-academy.first-resources.com` belum didaftarkan di DNS server internal kantor.
- **Solusi Sementara (Uji Coba di Laptop Klien):**  
  Tambahkan baris berikut pada file `C:\Windows\System32\drivers\etc\hosts` di laptop penguji:
  ```text
  10.121.1.17 mess-academy.first-resources.com
  ```
  *(Ganti `10.121.1.17` sesuai IP server target).*
