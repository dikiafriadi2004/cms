# Konter Digital CMS

CMS modern dan profesional untuk membuat landing page dan blog dengan fitur lengkap, dibangun dengan Laravel 11 dan Tailwind CSS.

## 🚀 Fitur Utama

### Content Management
- **Blog System** - Post management dengan categories dan tags
- **Pages** - Custom pages dengan SEO optimization
- **Media Library** - File manager dengan drag & drop upload
- **Menu Builder** - Visual menu builder dengan nested support

### User & Permissions
- **Role-Based Access Control** - Super Admin, Admin, Editor, Author roles
- **Granular Permissions** - Fine-grained permission system dengan ownership control
- **User Management** - User profiles dan activity tracking

### SEO & Analytics
- **SEO Optimization** - Meta tags, Open Graph, Twitter Cards
- **Google Analytics 4 Integration** - Real-time analytics dashboard
- **Analytics Dashboard** - Visitors, page views, traffic sources, device breakdown
- **Sitemap Generation** - Auto-generate XML sitemap
- **Robots.txt** - Dynamic robots.txt generation

### Ads Management
- **Multiple Ad Types** - AdSense, Adsera, Manual HTML, Image ads
- **Strategic Positions** - Header, Footer, Sidebar, Content Top/Bottom, Between Posts, In-Content
- **Display Rules** - Filter by page, post, category
- **Scheduling** - Start date & end date
- **In-Content Injection** - Auto-inject ads at specific paragraphs

### Frontend
- **Modern Design** - Tailwind CSS dengan gradient theme
- **Responsive** - Mobile-first design
- **Professional Landing Page** - Hero, Features, Products, Pricing, Testimonials, Statistics
- **Blog Templates** - Index, single post, category, tag pages
- **Contact Form** - With auto-reply and admin notifications

### Email System
- **SMTP Configuration** - Configure via admin panel (stored in database)
- **Auto-Reply** - Automatic reply to contact form submissions
- **Admin Notifications** - Email notifications for new contacts
- **Reply System** - Reply to contacts directly from admin panel
- **Logo in Emails** - Automatic logo display (works on real domains, not ngrok)

## 📋 Requirements

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL >= 5.7 or SQLite

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
APP_NAME="Konter Digital"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cms
DB_USERNAME=root
DB_PASSWORD=

# Or use SQLite
# DB_CONNECTION=sqlite
```

### 3. Database Setup (Automatic with Seeders!)
```bash
# For MySQL
php artisan migrate:fresh --seed

# For SQLite
touch database/database.sqlite
php artisan migrate:fresh --seed
```

Seeder akan otomatis membuat:
- ✅ Roles & Permissions (Super Admin, Admin, Editor, Author)
- ✅ Admin user (email: admin@example.com, password: password)
- ✅ Settings default (site name, contact info, SEO, dll)
- ✅ 5 Categories
- ✅ 10 Tags
- ✅ 20 Sample posts dengan konten lengkap
- ✅ Header & Footer menus
- ✅ Sample ads

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
- Email: `admin@example.com`
- Password: `password`

**⚠️ Ganti password setelah login pertama!**

## 📁 Struktur Project

```
cms/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Admin panel controllers
│   │   └── Frontend/       # Frontend controllers
│   ├── Models/             # Eloquent models
│   ├── Mail/               # Email templates (Mailable classes)
│   ├── Services/           # Services (GoogleAnalytics, MailConfig)
│   └── Helpers/            # Helper functions
├── database/
│   ├── migrations/         # Database migrations
│   └── seeders/            # Database seeders
├── resources/
│   ├── css/                # Tailwind CSS
│   ├── js/                 # JavaScript
│   └── views/
│       ├── admin/          # Admin views
│       ├── frontend/       # Frontend views
│       ├── emails/         # Email templates
│       └── layouts/        # Layout templates
├── routes/
│   ├── web.php             # Web routes
│   └── auth.php            # Auth routes
└── public/
    └── storage/            # Public storage (symlink)
```

## 🎨 Frontend Pages

### Public Pages
- **Home** (`/`) - Landing page dengan hero, features, products, pricing, testimonials
- **About** (`/about`) - About page dengan statistics
- **Blog** (`/blog`) - Blog index dengan search dan pagination
- **Single Post** (`/blog/{slug}`) - Post detail dengan related posts dan ads
- **Category** (`/category/{slug}`) - Posts by category
- **Tag** (`/tag/{slug}`) - Posts by tag
- **Contact** (`/contact`) - Contact form dengan auto-reply email
- **Custom Pages** (`/{slug}`) - Dynamic pages

### Admin Panel (`/admin`)
- **Dashboard** - Statistics dan Google Analytics widget
- **Posts** - Create, edit, delete posts dengan categories & tags
- **Pages** - Manage custom pages
- **Categories** - Blog categories management
- **Tags** - Blog tags management
- **Media** - File manager dengan upload
- **Menus** - Visual menu builder
- **Ads** - Ads management (AdSense, Adsera, Manual, Image)
- **Contacts** - View dan reply contact messages
- **Users** - User management
- **Roles** - Role & permission management
- **Settings** - Site settings, email config, Google Analytics

## 📊 Google Analytics Integration

### Setup Google Analytics 4

1. **Create Service Account** di Google Cloud Console
2. **Enable** Google Analytics Data API
3. **Download** JSON credentials file
4. **Login** ke Admin Panel > Settings
5. **Paste** JSON content ke textarea
6. **Enter** Property ID (angka saja, contoh: 123456789)
7. **Add** service account email ke GA4 property (Viewer role)
8. **Test** koneksi dengan tombol "Test Koneksi"

**Dashboard akan menampilkan:**
- Total visitors (7 hari terakhir)
- Page views
- Top 5 pages
- Traffic sources
- Device breakdown
- New vs Returning visitors

**Note:** Credentials disimpan di database (field `ga_credentials_json` dan `ga_property_id`).

## 📧 Email Configuration

### Setup Email via Admin Panel

1. Login ke Admin Panel
2. Settings > Email Configuration
3. Pilih Mail Driver (SMTP recommended)
4. Isi konfigurasi:
   - **SMTP (Gmail)**:
     - Host: `smtp.gmail.com`
     - Port: `587`
     - Username: `your-email@gmail.com`
     - Password: `your-app-password` (bukan password biasa!)
     - Encryption: `tls`
   - **SMTP (Other)**:
     - Sesuaikan dengan provider Anda
5. Save settings

**Email Features:**
- ✅ Auto-reply ke pengirim contact form
- ✅ Notification ke admin untuk contact baru
- ✅ Reply system dari admin panel
- ✅ Logo otomatis di email (untuk domain real)

**Note:** Logo tidak akan muncul di email saat menggunakan ngrok (limitasi ngrok). Logo akan muncul normal di production dengan domain real.

## 🎯 Ads Management

### Posisi Ads yang Tersedia

1. **header** - Di bagian atas halaman (setelah navbar)
2. **footer** - Di bagian bawah halaman (sebelum footer)
3. **sidebar** - Di sidebar kanan (blog pages)
4. **content_top** - Di atas konten utama
5. **content_bottom** - Di bawah konten utama
6. **between_posts** - Di antara posts (setiap 3 post)
7. **in_content** - Di dalam artikel (berdasarkan paragraph number)

### Tipe Ads

- **AdSense** - Google AdSense code
- **Adsera** - Adsera code
- **Manual** - Custom HTML/JavaScript
- **Image** - Upload gambar dengan link

### Display Rules

Filter ads berdasarkan:
- Pages (home, blog_index, blog_detail, dll)
- Specific posts
- Categories

## � Security Features

- CSRF Protection
- XSS Protection
- SQL Injection prevention
- Role-based access control (Spatie Permission)
- Password hashing (bcrypt)
- Secure file upload validation
- Rate limiting
- Trust proxies untuk ngrok/reverse proxy

## 🛠️ Maintenance Commands

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Refresh Permissions
```bash
php artisan permission:cache-reset
php artisan permission:refresh
```

### Update Dependencies
```bash
composer update
npm update
npm run build
```

### Backup Database
```bash
# MySQL
mysqldump -u root -p cms > backup-$(date +%Y%m%d).sql

# SQLite
cp database/database.sqlite database/backup-$(date +%Y%m%d).sqlite
```

## 🐛 Troubleshooting

### Logo/Favicon tidak muncul
```bash
php artisan storage:link
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

Pastikan `APP_URL` di `.env` sudah benar:
```env
APP_URL=https://your-domain.com
```

Hard refresh browser: `Ctrl + Shift + R`

### Permission errors
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### View tidak update
```bash
php artisan view:clear
```

### Email tidak terkirim
1. Cek konfigurasi email di Settings
2. Pastikan menggunakan App Password (bukan password biasa) untuk Gmail
3. Test dengan:
   ```bash
   php artisan tinker
   Mail::raw('Test email', function($msg) {
       $msg->to('test@example.com')->subject('Test');
   });
   ```

### Google Analytics tidak muncul
1. Pastikan credentials JSON valid
2. Pastikan Property ID benar (angka saja)
3. Pastikan service account sudah ditambahkan ke GA4 property
4. Test dengan tombol "Test Koneksi" di Settings
5. Clear cache: `php artisan cache:clear`

## 📝 Helper Functions

### Storage URL Helper
```php
storage_url($path)  // Generate URL untuk file di storage/app/public
```

Contoh:
```php
storage_url('media/image.jpg')        // → https://domain.com/storage/media/image.jpg
storage_url('/storage/media/image.jpg') // → https://domain.com/storage/media/image.jpg
```

### Favicon URL Helper
```php
favicon_url()  // Generate favicon URL dengan cache busting
```

## 🚀 Production Deployment

### 1. Update Environment
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_DATABASE=your-db-name
DB_USERNAME=your-db-user
DB_PASSWORD=your-db-password
```

### 2. Optimize
```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

### 3. Set Permissions
```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 4. Setup Cron (Optional)
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## 📞 Support

Untuk bantuan dan support:
- Email: admin@example.com
- Documentation: Lihat file README ini

## 📝 License

Open-sourced software licensed under the MIT license.

---

**Konter Digital CMS** - Modern CMS untuk Landing Page dan Blog 🚀
