# Konter Digital CMS

CMS modern dan profesional untuk membuat landing page dan blog dengan fitur lengkap, dibangun dengan Laravel 11 dan Tailwind CSS.

## 🚀 Fitur Utama

### Content Management
- **Blog System** - Post management dengan categories dan tags
- **Pages** - Custom pages dengan SEO optimization
- **Media Library** - File manager dengan drag & drop upload
- **Menu Builder** - Visual menu builder dengan nested support

### User & Permissions
- **Role-Based Access Control** - Admin, Editor, Author roles
- **Granular Permissions** - Fine-grained permission system
- **User Management** - User profiles dan activity tracking

### SEO & Analytics
- **SEO Optimization** - Meta tags, Open Graph, Twitter Cards
- **Google Analytics 4 Integration** - Real-time analytics dashboard in admin panel
- **Analytics Dashboard** - Visitors, page views, traffic sources, device breakdown
- **Tracking Integration** - Google Analytics, Tag Manager, Facebook Pixel
- **Sitemap Generation** - Auto-generate XML sitemap

### Frontend
- **Modern Design** - Tailwind CSS dengan gradient purple-indigo theme
- **Responsive** - Mobile-first design
- **Professional Landing Page** - Hero, Features, Products, Pricing, Testimonials
- **Blog Templates** - Index, single post, category, tag pages
- **Contact Form** - With email notifications

### Settings
- **General Settings** - Site name, logo, favicon, contact info
- **Email Configuration** - SMTP settings via admin panel
- **Social Media** - Facebook, Instagram, Twitter, WhatsApp links
- **Ads Management** - Google AdSense, Adsera, custom ads

## 📋 Requirements

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL/SQLite

## 🔧 Installation

### 1. Clone & Install
```bash
git clone <repository-url>
cd cms
composer install
npm install
```

### 2. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:
```env
APP_URL=http://localhost:8000
DB_CONNECTION=sqlite
```

### 3. Database Setup
```bash
touch database/database.sqlite
php artisan migrate
php artisan db:seed
```

### 4. Storage & Assets
```bash
php artisan storage:link
npm run build
```

### 5. Run Application
```bash
php artisan serve
```

Akses: `http://localhost:8000`

## 👤 Default Login

**Admin Account:**
- Email: `admin@konterdigital.com`
- Password: `password123`

**⚠️ Ganti password setelah login pertama!**

## 📁 Struktur Project

```
cms/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Admin panel controllers
│   │   └── Frontend/       # Frontend controllers
│   ├── Models/             # Eloquent models
│   └── Providers/          # Service providers
├── database/
│   ├── migrations/         # Database migrations
│   └── seeders/            # Database seeders
├── resources/
│   ├── css/                # Tailwind CSS
│   ├── js/                 # JavaScript
│   └── views/
│       ├── admin/          # Admin views
│       ├── frontend/       # Frontend views
│       └── layouts/        # Layout templates
├── routes/
│   ├── web.php             # Web routes
│   └── auth.php            # Auth routes
└── public/
    └── storage/            # Public storage (symlink)
```

## 🎨 Frontend Pages

### Public Pages
- **Home** - Landing page dengan hero, features, products, pricing
- **Blog** - Blog index dengan search dan pagination
- **Single Post** - Post detail dengan related posts
- **Category** - Posts by category
- **Tag** - Posts by tag
- **Contact** - Contact form dengan auto-reply email
- **Pages** - Custom pages (Privacy, Terms, About, dll)

### Admin Panel
- Dashboard dengan statistics dan Google Analytics widget
- Posts, Pages, Categories, Tags management
- Media library
- Menu builder
- User & role management
- Settings configuration
- Ads management
- Contact messages
- Real-time analytics data from Google Analytics 4

## 🔐 Security Features

- CSRF Protection
- XSS Protection
- SQL Injection prevention
- Role-based access control
- Password hashing (bcrypt)
- Secure file upload validation
- Rate limiting

## ⚡ Performance

- Query optimization dengan eager loading
- View caching
- Asset minification (Vite)
- Image optimization
- Database indexing

## 🛠️ Maintenance Commands

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Google Analytics
```bash
# Test analytics configuration
php artisan analytics:test

# Clear analytics cache
php artisan cache:clear
```

**Note**: Google Analytics credentials disimpan di database (field `ga_credentials_json` dan `ga_property_id`), bukan sebagai file. Configure via Admin Panel > Settings > Google Analytics API.

### Update Dependencies
```bash
composer update
npm update
npm run build
```

### Backup Database
```bash
# SQLite
cp database/database.sqlite database/backup-$(date +%Y%m%d).sqlite
```

## 🐛 Troubleshooting

### Logo/Favicon tidak muncul
```bash
php artisan storage:link
php artisan config:clear
php artisan view:clear
# Hard refresh browser: Ctrl + Shift + R
```

**Jika favicon tidak muncul di ngrok atau domain lain:**

1. **Jalankan troubleshooting script:**
   ```bash
   php check-favicon.php
   ```
   Script ini akan mengecek semua konfigurasi favicon dan memberikan rekomendasi.

2. **Pastikan APP_URL sudah benar di .env:**
   ```env
   APP_URL=https://your-domain.ngrok-free.dev
   ```

3. **Clear semua cache:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

4. **Test favicon URL:**
   ```bash
   php artisan tinker --execute="echo favicon_url();"
   ```
   URL harus menggunakan domain yang benar, bukan localhost.

5. **Clear browser cache:**
   - Chrome/Edge: Ctrl + Shift + Delete
   - Firefox: Ctrl + Shift + Delete
   - Safari: Cmd + Option + E
   - Atau gunakan Incognito/Private mode

6. **Test direct access:**
   Buka URL favicon langsung di browser:
   ```
   https://your-domain.ngrok-free.dev/storage/settings/[filename].png
   ```

**Catatan:** Favicon menggunakan cache busting parameter (`?v=timestamp`) untuk memaksa browser mengambil versi terbaru.

### Permission errors
```bash
chmod -R 775 storage bootstrap/cache
```

### View tidak update
```bash
php artisan view:clear
# Hapus compiled views
rm -rf storage/framework/views/*.php
```

## 📝 Configuration

### Email Setup (Gmail)
1. Login ke admin panel
2. Settings > Email Configuration
3. Isi:
   - Mail Driver: `smtp`
   - Mail Host: `smtp.gmail.com`
   - Mail Port: `587`
   - Mail Username: `your-email@gmail.com`
   - Mail Password: `your-app-password`
   - Mail Encryption: `tls`

### Logo & Favicon
1. Login ke admin panel
2. Settings > General
3. Upload logo dan favicon
4. Save changes

### Menu Setup
1. Admin > Menus
2. Create menu (Header/Footer)
3. Add menu items (Pages, Posts, Categories, Custom links)
4. Drag & drop untuk reorder
5. Save

### Storage URL Helper
CMS ini menggunakan helper `storage_url()` untuk menangani path storage dengan benar:

```php
// Otomatis handle path yang sudah include /storage/ atau belum
storage_url('media/image.jpg')        // → /storage/media/image.jpg
storage_url('/storage/media/image.jpg') // → /storage/media/image.jpg
storage_url('settings/logo.png')      // → /storage/settings/logo.png
```

Helper ini mencegah double path seperti `/storage//storage/...` dan memastikan URL selalu menggunakan `APP_URL` dari `.env`.

## 🎯 Key Features Implemented

✅ Modern landing page dengan Tailwind CSS
✅ Blog system dengan categories dan tags
✅ SEO optimization
✅ **Google Analytics 4 integration dengan dashboard widget**
✅ Role & permission system
✅ Media library dengan file manager
✅ Menu builder dengan drag & drop
✅ Contact form dengan email notifications
✅ Settings management via admin panel
✅ Responsive design
✅ Professional admin panel

## 📊 Google Analytics Integration

CMS ini sudah terintegrasi dengan Google Analytics 4 (GA4) untuk menampilkan data analytics langsung di dashboard admin.

### Features
- ✅ Real-time visitor statistics
- ✅ Page views tracking
- ✅ Top pages analytics
- ✅ Traffic sources breakdown
- ✅ Device categories (Desktop/Mobile/Tablet)
- ✅ New vs Returning visitors
- ✅ Bounce rate & session duration

### Quick Setup
Untuk mengaktifkan Google Analytics di dashboard:

1. **Login ke Admin Panel**:
   - Navigate to Settings > Google Analytics API

2. **Get Service Account Credentials**:
   - Create Service Account di Google Cloud Console
   - Enable Google Analytics Data API
   - Download JSON credentials file

3. **Configure via Admin Panel**:
   - Open JSON file with text editor
   - Copy ALL JSON content
   - Paste into "Service Account Credentials (JSON)" textarea
   - Enter Property ID (angka saja, bukan G-XXXXXXXXXX)
   - Save settings

4. **Add Service Account to GA4**:
   - Copy service account email from JSON (`client_email`)
   - Add to GA4 property with Viewer role

5. **Check Dashboard**:
   - Navigate to Admin Dashboard
   - Analytics widget should display data

**Note**: Credentials disimpan di database (field `ga_credentials_json` dan `ga_property_id`), tidak perlu upload file atau edit .env.

### Documentation
Dokumentasi lengkap tersedia:
- **[Database Setup Guide](GOOGLE_ANALYTICS_SETUP_DATABASE.md)** - Setup menggunakan database storage (recommended)
- **[Setup Guide (ID)](GOOGLE_ANALYTICS_SETUP.md)** - Panduan lengkap Bahasa Indonesia
- **[Integration Guide (EN)](docs/GOOGLE_ANALYTICS_INTEGRATION.md)** - English documentation
- **[Features List](ANALYTICS_FEATURES.md)** - Daftar fitur analytics
- **[FAQ](FAQ_ANALYTICS.md)** - Pertanyaan umum

### Testing
```bash
# Test Google Analytics configuration
php artisan analytics:test
```

Command ini akan:
- ✅ Validasi konfigurasi
- ✅ Cek credentials file
- ✅ Test koneksi API
- ✅ Tampilkan sample data

## 📞 Support

Untuk bantuan dan support, hubungi:
- Email: support@konterdigital.com
- Website: https://konterdigital.com

## 📝 License

Open-sourced software licensed under the MIT license.

---

**Konter Digital CMS** - Modern CMS untuk Landing Page dan Blog 🚀
