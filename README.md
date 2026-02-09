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
- **Analytics Integration** - Google Analytics, Tag Manager, Facebook Pixel
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
- Dashboard dengan statistics
- Posts, Pages, Categories, Tags management
- Media library
- Menu builder
- User & role management
- Settings configuration
- Ads management
- Contact messages

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

## 🎯 Key Features Implemented

✅ Modern landing page dengan Tailwind CSS
✅ Blog system dengan categories dan tags
✅ SEO optimization
✅ Role & permission system
✅ Media library dengan file manager
✅ Menu builder dengan drag & drop
✅ Contact form dengan email notifications
✅ Settings management via admin panel
✅ Responsive design
✅ Professional admin panel

## 📞 Support

Untuk bantuan dan support, hubungi:
- Email: support@konterdigital.com
- Website: https://konterdigital.com

## 📝 License

Open-sourced software licensed under the MIT license.

---

**Konter Digital CMS** - Modern CMS untuk Landing Page dan Blog 🚀
