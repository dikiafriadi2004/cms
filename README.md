# CMS Laravel — Content Management System

CMS berbasis Laravel 12 untuk landing page dan blog. Dilengkapi manajemen konten lengkap, SEO tools, iklan, analytics, dan sistem role/permission.

---

## Daftar Isi

- [Fitur](#fitur)
- [Requirement](#requirement)
- [Instalasi Lokal](#instalasi-lokal)
- [Instalasi di VPS / Production](#instalasi-di-vps--production)
- [Konfigurasi .env](#konfigurasi-env)
- [Akun Default](#akun-default)
- [Role & Permission](#role--permission)
- [Struktur Admin Panel](#struktur-admin-panel)
- [Queue Worker](#queue-worker)
- [Backup Otomatis](#backup-otomatis)
- [Rebuild CSS / JS](#rebuild-css--js)
- [Perintah Artisan Berguna](#perintah-artisan-berguna)
- [Struktur Folder Penting](#struktur-folder-penting)

---

## Fitur

**Konten**
- Posts (artikel blog) dengan editor rich text, SEO score, reading time
- Pages (halaman statis) dengan dukungan homepage
- Categories & Tags dengan slug otomatis
- Media Library — upload gambar, dokumen, folder management
- Menu Builder — header & footer menu dengan drag-and-drop

**SEO**
- Meta title, description, keywords per post/page
- Open Graph & Twitter Card otomatis
- JSON-LD Structured Data (Article, Blog, WebSite, Organization)
- Sitemap XML otomatis (`/sitemap.xml`) dengan cache 6 jam
- Robots.txt dari database, bisa diatur via CMS (`/robots.txt`)
- Google Site Verification
- Focus keyword & SEO score analyzer

**Iklan (Ads)**
- Posisi: header, footer, sidebar, content_top, content_bottom, between_posts, in_content
- Tipe: Google AdSense, manual HTML, image dengan link
- Rotation: random, weighted, sequential
- Display rules per halaman/kategori/post
- Analytics: impressions, clicks, CTR per iklan

**Analytics**
- Google Analytics 4 (GA4) via Tracking ID
- Google Tag Manager
- Facebook Pixel
- Google Analytics API (dashboard summary via service account)

**Pengguna & Keamanan**
- Role-based access control: super-admin, admin, editor, author
- 40+ permission granular
- Session enkripsi & secure cookie
- Security headers (CSP, X-Frame-Options, HSTS-ready)
- Rate limiting login (5 attempts) & contact form (5/menit)
- Validasi konten upload (MIME type + content check)

**Email & Notifikasi**
- Konfigurasi SMTP via Admin Panel (tanpa edit .env)
- Auto-reply ke pengirim contact form
- Notifikasi ke admin saat ada pesan baru
- Semua email dikirim via queue (tidak blocking)

**Lainnya**
- Backup otomatis harian (database + files) via spatie/laravel-backup
- Template frontend yang bisa diganti via Admin Panel
- Settings lengkap via CMS (logo, favicon, hero section, footer, social media)
- Cache settings & menu untuk performa optimal

---

## Requirement

| Komponen | Versi Minimum |
|----------|--------------|
| PHP | 8.2+ |
| Laravel | 12.x |
| MySQL | 8.0+ / MariaDB 10.4+ |
| Node.js | 18+ (hanya untuk rebuild CSS) |
| Composer | 2.x |
| PHP Extensions | GD, PDO, mbstring, openssl, tokenizer, xml, ctype, json, bcmath |

---

## Instalasi Lokal

### 1. Clone & install dependencies

```bash
git clone <repo-url> cms
cd cms
composer install
```

### 2. Setup environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` — minimal ubah:
```env
APP_URL=http://localhost:8000
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Migrasi & seed database

```bash
php artisan migrate
php artisan db:seed
```

### 4. Storage link

```bash
php artisan storage:link
```

### 5. Jalankan server

```bash
php artisan serve
```

Buka `http://localhost:8000` untuk frontend, `http://localhost:8000/admin` untuk admin panel.

> Untuk menjalankan queue di lokal (agar email terkirim):
> ```bash
> php artisan queue:listen --tries=1
> ```

---

## Instalasi di VPS / Production

### 1. Upload & install

```bash
git clone <repo-url> /var/www/html
cd /var/www/html
composer install --optimize-autoloader --no-dev
```

### 2. Setup environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` untuk production:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=nama_database
DB_USERNAME=db_user
DB_PASSWORD=db_password

SESSION_SECURE_COOKIE=true
SESSION_ENCRYPT=true

TRUSTED_PROXIES=127.0.0.1
# Jika pakai Cloudflare: TRUSTED_PROXIES=*
```

### 3. Migrasi, seed, optimize

```bash
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 4. Permission folder

```bash
sudo chown -R www-data:www-data /var/www/html
sudo chmod -R 755 /var/www/html/storage
sudo chmod -R 755 /var/www/html/bootstrap/cache
```

### 5. Nginx config (contoh)

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/html/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

## Konfigurasi .env

Konfigurasi teknis di `.env`, konfigurasi konten (nama situs, logo, SMTP, social media, dll) diatur via **Admin Panel > Settings**.

| Key | Keterangan |
|-----|-----------|
| `APP_URL` | URL lengkap dengan https |
| `APP_DEBUG` | `false` di production |
| `DB_*` | Koneksi database |
| `QUEUE_CONNECTION` | `database` (default) |
| `CACHE_STORE` | `database` (default) |
| `SESSION_ENCRYPT` | `true` di production |
| `SESSION_SECURE_COOKIE` | `true` di production |
| `TRUSTED_PROXIES` | IP proxy/load balancer, `*` untuk Cloudflare |
| `BACKUP_NOTIFICATION_EMAIL` | Email penerima notifikasi backup |
| `AWS_*` | Opsional — untuk backup ke S3 |

---

## Akun Default

Setelah `php artisan db:seed`:

| Field | Value |
|-------|-------|
| Email | `admin@example.com` |
| Password | `password` |
| Role | `super-admin` |

> **Ganti password segera setelah login pertama kali.**

---

## Role & Permission

| Role | Akses |
|------|-------|
| `super-admin` | Semua fitur termasuk role & permission management |
| `admin` | Semua fitur kecuali manage roles/permissions |
| `editor` | Kelola semua konten (post, page, kategori, tag, media, menu, iklan) |
| `author` | Hanya bisa buat & edit konten milik sendiri |

Permission tersedia untuk setiap aksi (view, create, edit, delete) pada setiap modul. Role bisa dikustomisasi via **Admin Panel > Roles**.

---

## Struktur Admin Panel

```
/admin
├── Dashboard          — Statistik, post terbaru, Google Analytics
├── Posts              — Artikel blog (CRUD, bulk action, SEO)
├── Pages              — Halaman statis (CRUD, homepage setting)
├── Categories         — Kategori post
├── Tags               — Tag post
├── Media              — Upload & kelola file/gambar
├── Menus              — Builder menu header & footer
├── Ads                — Manajemen iklan & analytics
├── Contacts           — Pesan dari contact form + reply
├── Users              — Manajemen pengguna
├── Roles              — Manajemen role & permission
└── Settings
    ├── General        — Nama situs, kontak, alamat
    ├── Branding       — Logo, favicon
    ├── SEO            — Meta default, OG image, robots.txt, Google verification
    ├── Analytics      — GA4, GTM, Facebook Pixel, GA API
    ├── Email          — Konfigurasi SMTP
    ├── Social Media   — Link sosial media
    ├── Hero Section   — Konten hero landing page
    ├── Footer         — Teks footer
    └── Template       — Pilih template frontend
```

---

## Queue Worker

Email dikirim via queue agar tidak memblokir response ke user. Queue harus jalan sebagai background process.

### Setup Supervisor di VPS

```bash
sudo apt install supervisor -y
sudo cp supervisor/laravel-queue.conf /etc/supervisor/conf.d/laravel-queue.conf
```

Edit path di file config jika berbeda dari `/var/www/html`:
```bash
sudo nano /etc/supervisor/conf.d/laravel-queue.conf
```

Aktifkan:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-queue:*
```

Cek status:
```bash
sudo supervisorctl status
```

Restart setelah deploy:
```bash
sudo supervisorctl restart laravel-queue:*
```

Lihat log queue:
```bash
tail -f storage/logs/queue.log
```

### Lokal (development)

```bash
php artisan queue:listen --tries=1
```

---

## Backup Otomatis

Backup database + files berjalan otomatis setiap hari via Laravel Scheduler:
- `01:00` — cleanup backup lama
- `02:00` — backup baru

### Aktifkan cron di VPS

```bash
crontab -e
```

Tambahkan:
```
* * * * * cd /var/www/html && php artisan schedule:run >> /dev/null 2>&1
```

### Jalankan backup manual

```bash
php artisan backup:run
php artisan backup:clean
php artisan backup:list
```

Backup disimpan di `storage/app/Laravel/` secara default. Untuk backup ke S3, konfigurasi `AWS_*` di `.env` dan update `config/backup.php`.

---

## Rebuild CSS / JS

CSS dan JS sudah di-compile dan di-commit ke repo (`public/css/app.css`, `public/js/app.js`). Rebuild hanya diperlukan jika ada perubahan pada Tailwind config atau source CSS/JS.

### Rebuild CSS

```bash
npm install
npm run build
```

### Watch mode (development)

```bash
npm run watch
```

### Rebuild JS manual

```bash
npx esbuild resources/js/app.js --bundle --minify --outfile=public/js/app.js --format=iife
```

> Commit hasil build ke git setelah rebuild.

---

## Perintah Artisan Berguna

```bash
# Clear semua cache
php artisan config:clear && php artisan cache:clear && php artisan view:clear && php artisan route:clear

# Cache untuk production
php artisan config:cache && php artisan route:cache && php artisan view:cache

# Refresh permissions (jika ada perubahan role/permission)
php artisan permissions:refresh

# Cek status queue jobs
php artisan queue:monitor

# Lihat semua route
php artisan route:list

# Cek status migrasi
php artisan migrate:status

# Backup manual
php artisan backup:run

# Maintenance mode
php artisan down --render="errors.503"
php artisan up
```

---

## Struktur Folder Penting

```
app/
├── Helpers/
│   ├── helpers.php          — Helper functions global (storage_url, favicon_url, dll)
│   ├── SettingsCache.php    — Cache settings dari database
│   └── SeoHelper.php        — Helper untuk SEO
├── Http/
│   ├── Controllers/
│   │   ├── Admin/           — Controller admin panel
│   │   ├── Frontend/        — Controller halaman publik
│   │   └── Auth/            — Controller autentikasi
│   └── Middleware/
│       ├── SecurityHeaders.php   — CSP, X-Frame-Options, dll
│       └── CheckUserActive.php   — Blokir user non-aktif
├── Mail/                    — Mailable classes (email)
├── Models/                  — Eloquent models
├── Policies/                — Authorization policies
└── Services/
    ├── GoogleAnalyticsService.php
    ├── MailConfigService.php    — Konfigurasi SMTP dari database
    └── TemplateService.php      — Manajemen template frontend

resources/
├── css/app.css              — Source CSS (Tailwind)
├── js/app.js                — Source JS (Alpine.js)
└── views/
    ├── admin/               — Blade views admin panel
    ├── auth/                — Login, verify email, confirm password
    ├── emails/              — Template email
    ├── errors/              — Custom error pages (403, 404, 419, 500, 503)
    └── frontend/            — Views halaman publik

public/
├── css/app.css              — CSS compiled (di-commit)
└── js/app.js                — JS compiled (di-commit)

database/
├── migrations/              — 34 migration files
└── seeders/
    ├── DatabaseSeeder.php   — Entry point seeder
    ├── RolePermissionSeeder.php
    ├── AdminUserSeeder.php
    ├── SettingSeeder.php
    ├── CategorySeeder.php
    ├── TagSeeder.php
    ├── PostSeeder.php
    ├── MenuSeeder.php
    └── AdSeeder.php

supervisor/
├── laravel-queue.conf       — Config Supervisor untuk queue worker
└── README.md                — Panduan setup Supervisor
```

---

## Tech Stack

| Layer | Teknologi |
|-------|-----------|
| Framework | Laravel 12 |
| Frontend CSS | Tailwind CSS 3.4 (compiled static) |
| Frontend JS | Alpine.js 3 (compiled static) |
| Database | MySQL 8 / SQLite |
| Image Processing | Intervention Image 3 |
| Permissions | Spatie Laravel Permission |
| Sitemap | Spatie Laravel Sitemap |
| Backup | Spatie Laravel Backup |
| Analytics API | Spatie Laravel Analytics |
| Markdown | League CommonMark |
| Queue | Laravel Database Queue |
| Scheduler | Laravel Task Scheduling |
