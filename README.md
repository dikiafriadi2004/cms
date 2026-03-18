# 🚀 CMS Laravel - Content Management System

Modern, powerful, and SEO-optimized Content Management System built with Laravel 11.

![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)
![License](https://img.shields.io/badge/License-MIT-green.svg)

---

## ✨ Features

### Content Management
- 📝 **Posts Management** - Create, edit, and publish blog posts with rich text editor
- 📄 **Pages Management** - Static pages with custom templates
- 🏷️ **Categories & Tags** - Organize content efficiently
- 📁 **Media Library** - Upload and manage images with folder organization
- 🎨 **Multiple Templates** - Choose from Elegant, Magazine, or Minimal themes

### SEO & Marketing
- � **SEO Optimization** - Meta tags, Open Graph, Twitter Cards
- 📊 **Google Analytics Integration** - Track your website performance
- 🗺️ **Sitemap & Robots.txt** - Automatic generation
- 📈 **SEO Score Calculator** - Real-time SEO analysis
- 🎯 **Ads Management** - Display and track advertisements

### User Management
- 👥 **User Management** - Create and manage users
- 🔐 **Role & Permission System** - Granular access control (Spatie Permission)
- 🔒 **Account Status** - Activate/deactivate user accounts
- 👤 **User Profiles** - Avatar, bio, and personal information

### Communication
- 📧 **Contact Form** - With email notifications and auto-reply
- 💬 **Contact Management** - View and reply to messages
- � **Email  Queue** - Background email processing

### System
- 🎛️ **Settings Management** - Configure site settings from admin panel
- 🍔 **Menu Builder** - Drag & drop menu creation
- 🔄 **Backup System** - Automated daily backups
- 🛡️ **Security Headers** - XSS, CSRF, Clickjacking protection
- ⚡ **Caching** - Optimized performance with caching

---

## 📋 Requirements

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL/MariaDB or SQLite
- Web Server (Apache/Nginx)

---

## 🔧 Installation

### Quick Start

```bash
# 1. Clone repository
git clone https://github.com/yourusername/cms-laravel.git
cd cms-laravel

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Configure database in .env
# For SQLite (default):
DB_CONNECTION=sqlite

# For MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_DATABASE=your_database
# DB_USERNAME=your_username
# DB_PASSWORD=your_password

# 5. Run migrations and seeders
php artisan migrate --seed

# 6. Create storage link
php artisan storage:link

# 7. Build assets (generates public/css/app.css & public/js/app.js)
npm run build

# 8. Start server
php artisan serve
```

Visit: `http://localhost:8000`

### Default Admin Credentials

After running seeders:
- Email: `admin@example.com`
- Password: `password`

**⚠️ IMPORTANT:** Change password immediately after first login!

---

## 📚 Usage

### Admin Panel
Access admin panel at: `http://localhost:8000/admin`

### Creating Content
1. Login to admin panel
2. Navigate to **Posts** or **Pages**
3. Click **Create New**
4. Fill in content with rich text editor
5. Set SEO metadata
6. Publish or save as draft

### Managing Users
1. Go to **Users** in admin panel
2. Create new user with email and password
3. Assign role (Admin, Editor, Author, etc.)
4. Set permissions

### Configuring Settings
1. Navigate to **Settings**
2. Configure:
   - Site information
   - Email settings
   - Social media links
   - Google Analytics
   - Templates

---

## 🔐 Security

### Features Implemented
- ✅ CSRF Protection
- ✅ XSS Protection
- ✅ SQL Injection Protection (Eloquent ORM)
- ✅ Rate Limiting (Login, Contact Form, API)
- ✅ Security Headers (X-Frame-Options, CSP, etc.)
- ✅ User Account Status Validation
- ✅ Role-Based Access Control

### Best Practices
- Change default admin password
- Use strong passwords
- Enable 2FA for Gmail SMTP
- Keep Laravel and dependencies updated
- Use HTTPS in production
- Configure proper file permissions

---

## ⚙️ Configuration

### Configuration Philosophy

This CMS uses a **two-tier configuration system**:

1. **`.env` File** - For technical/server configurations (database, cache, queue)
2. **Admin Panel > Settings** - For user-editable content (site info, social media, SEO)

### Technical Configuration (.env)

Edit `.env` for server-level settings:

```env
# Application
APP_NAME=Laravel
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yoursite.com

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Mail (or configure via Admin Panel)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls

# Queue
QUEUE_CONNECTION=database

# Backup
BACKUP_ENABLED=true
BACKUP_DISK=local
BACKUP_NOTIFICATION_EMAIL=admin@example.com
```

**Gmail Users:** Enable 2-Step Verification and create App Password at [Google Account Settings](https://myaccount.google.com/apppasswords)

### Content Configuration (Admin Panel)

Configure via **Admin Panel > Settings**:

#### General Settings
- Site Name
- Site Description
- Site Keywords

#### Contact Information
- Contact Email
- Contact Phone
- Contact Address

#### Social Media Links
- Facebook URL
- Twitter URL
- Instagram URL
- LinkedIn URL

#### SEO Settings
- Default Meta Title
- Default Meta Description
- OG Image Upload

#### Email Settings
- SMTP Configuration (alternative to .env)
- From Address
- From Name

#### Google Analytics
1. Create service account in Google Cloud Console
2. Download credentials JSON
3. Go to Settings > Analytics
4. Paste credentials JSON
5. Enter GA4 Property ID
6. Test connection

#### Template Selection
- Choose from 5 templates: Default, Elegant, Magazine, Minimal, Corporate
- Preview before applying

### Queue Worker

For background jobs (emails, etc.):
```bash
php artisan queue:work
```

### Backup

Run backup manually:
```bash
php artisan backup:run
```

Disable auto backup:
```env
BACKUP_ENABLED=false
```

---

## 🧪 Testing

Run tests:
```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/PostTest.php

# Run with coverage
php artisan test --coverage
```

---

## 📦 Deployment

### Production Checklist
- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Configure proper database
- [ ] Setup queue worker (supervisor)
- [ ] Setup cron job for scheduled tasks
- [ ] Enable caching
- [ ] Configure backup
- [ ] Setup SSL certificate
- [ ] Change default admin password

### Optimization Commands
```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

### Cron Job Setup
Add to crontab:
```bash
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

### Queue Worker (Supervisor)
Create `/etc/supervisor/conf.d/laravel-worker.conf`:
```ini
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path-to-project/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/path-to-project/storage/logs/worker.log
```

Then:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*
```

### Backup Configuration

Auto backup runs daily at 02:00. To disable:

Edit `routes/console.php`:
```php
// Comment these lines to disable auto backup
// Schedule::command('backup:clean')->daily()->at('01:00');
// Schedule::command('backup:run')->daily()->at('02:00');
```

Or use `.env`:
```env
BACKUP_ENABLED=false
```

Manual backup:
```bash
php artisan backup:run
```

---

## 🛠️ Troubleshooting

### Common Issues

**1. Permission Denied**
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

**2. 500 Internal Server Error**
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

**3. Queue Not Processing**
```bash
php artisan queue:restart
php artisan queue:work
```

**4. Assets Not Loading**
```bash
npm run build
php artisan storage:link
```

**5. Backup Storage Full**

To disable auto backup, edit `routes/console.php`:
```php
// Comment these lines
// Schedule::command('backup:clean')->daily()->at('01:00');
// Schedule::command('backup:run')->daily()->at('02:00');
```

Or limit backup size in `config/backup.php`:
```php
'delete_oldest_backups_when_using_more_megabytes_than' => 500, // 500MB limit
```

**6. Email Not Sending**

Configure SMTP in `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
```

For Gmail: Enable 2-Step Verification and create App Password at [Google Account Settings](https://myaccount.google.com/apppasswords)

Then start queue worker:
```bash
php artisan queue:work
```

---

## 📖 Documentation

- [Laravel Documentation](https://laravel.com/docs)
- [Spatie Permission](https://spatie.be/docs/laravel-permission)
- [Spatie Backup](https://spatie.be/docs/laravel-backup)
- [Quill Editor](https://quilljs.com/)

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

### How to Contribute

1. **Fork the repository**
2. **Create feature branch**
   ```bash
   git checkout -b feature/AmazingFeature
   ```
3. **Commit your changes**
   ```bash
   git commit -m 'Add some AmazingFeature'
   ```
4. **Push to branch**
   ```bash
   git push origin feature/AmazingFeature
   ```
5. **Open Pull Request**

### Development Guidelines

- Follow PSR-12 coding standards
- Write tests for new features
- Update documentation as needed
- Keep commits atomic and descriptive
- Test thoroughly before submitting PR

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/PostTest.php

# Run with coverage
php artisan test --coverage
```

---

## 📝 License

This project is licensed under the MIT License.

---

## 👨‍💻 Author

**Your Name**
- Website: [yourwebsite.com](https://yourwebsite.com)
- Email: your.email@example.com
- GitHub: [@yourusername](https://github.com/yourusername)

---

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) - The PHP Framework
- [Tailwind CSS](https://tailwindcss.com) - CSS Framework
- [Alpine.js](https://alpinejs.dev) - JavaScript Framework
- [Spatie](https://spatie.be) - Laravel Packages
- [Quill](https://quilljs.com) - Rich Text Editor

---

## 📞 Support

If you have any questions or need help, please:
- Open an issue on GitHub
- Email: support@example.com
- Documentation: [docs.yoursite.com](https://docs.yoursite.com)

---

**Made with ❤️ using Laravel**
