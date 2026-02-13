# Laravel CMS with Advanced Ads Management

A modern, feature-rich Content Management System built with Laravel 12, designed specifically for businesses and publishers who want to monetize their content through strategic ad placements.

## 🎯 Key Features

### Content Management
- **Posts & Pages** - Full CRUD with rich text editor and SEO optimization
- **Categories & Tags** - Organize content efficiently
- **Media Library** - Upload, organize, and manage files with drag-and-drop
- **Menu Builder** - Create dynamic navigation menus with drag-and-drop reordering

### Ad Management System
- **Multiple Ad Positions** - Header, sidebar, footer, in-content, and more
- **Ad Analytics** - Track impressions and clicks in real-time
- **Ad Scheduling** - Set start and end dates for campaigns
- **Performance Tracking** - Monitor CTR and engagement metrics

### User Management
- **Role-Based Access Control** - Admin, Editor, and Author roles
- **Granular Permissions** - 50+ permissions for fine-grained control
- **User Profiles** - Customizable user information and bio
- **Secure Authentication** - Built with Laravel Breeze

### SEO & Marketing
- **SEO Optimization** - Meta titles, descriptions, and keywords
- **XML Sitemap** - Auto-generated sitemap for search engines
- **Robots.txt** - Customizable robots.txt configuration
- **Social Media Integration** - Open Graph and Twitter Card support

### Additional Features
- **Contact Form** - With email notifications and admin management
- **Responsive Design** - Mobile-friendly interface
- **Dark Mode Ready** - Modern UI with Tailwind CSS
- **Google Analytics** - Integration ready

## 📋 Requirements

- PHP >= 8.2
- MySQL >= 8.0 or PostgreSQL >= 13
- Composer
- Web Server (Apache/Nginx)
- SSL Certificate (recommended for production)

## 🚀 Installation

### 1. Clone the Repository
```bash
git clone <your-repository-url>
cd cms
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` file and configure:
- Database credentials
- Mail server settings
- Application URL
- Other environment-specific settings

### 4. Database Setup
```bash
# Run migrations
php artisan migrate

# Seed initial data (optional but recommended)
php artisan db:seed
```

### 5. Storage Setup
```bash
php artisan storage:link
```

### 6. Set Permissions
```bash
# Linux/Mac
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Windows - Run as Administrator
icacls storage /grant Users:F /T
icacls bootstrap\cache /grant Users:F /T
```

### 7. Cache Configuration (Production)
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🔐 First Login

After running the seeders, you can login with the default admin account:

**Note:** The default credentials are created during seeding. Please change the password immediately after first login for security.

Navigate to `/admin` to access the admin panel.

## ⚙️ Configuration

### Mail Configuration
Configure your mail settings in `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Database Configuration
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### Google Analytics (Optional)
1. Create a service account in Google Cloud Console
2. Download the JSON credentials file
3. Upload via Admin Settings panel
4. Configure property ID

## 📁 Project Structure

```
cms/
├── app/
│   ├── Http/Controllers/     # Application controllers
│   ├── Models/               # Eloquent models
│   ├── Services/             # Business logic services
│   └── View/Components/      # Blade components
├── config/                   # Configuration files
├── database/
│   ├── migrations/           # Database migrations
│   └── seeders/              # Database seeders
├── public/                   # Public assets
├── resources/
│   ├── views/                # Blade templates
│   ├── css/                  # Stylesheets
│   └── js/                   # JavaScript files
└── routes/                   # Application routes
```

## 🎨 Customization

### Changing Site Settings
1. Login to admin panel
2. Navigate to Settings
3. Update site name, logo, contact info, etc.

### Creating Custom Pages
1. Go to Admin > Pages
2. Click "Create New Page"
3. Add content and configure SEO
4. Publish when ready

### Managing Ads
1. Go to Admin > Ads
2. Create new ad with position and content
3. Set schedule (optional)
4. Monitor performance in Analytics

## 🔒 Security Best Practices

1. **Change Default Credentials** - Immediately after installation
2. **Use HTTPS** - Always use SSL in production
3. **Keep Updated** - Regularly update dependencies
4. **Backup Regularly** - Implement automated backup strategy
5. **Environment Variables** - Never commit `.env` file
6. **File Permissions** - Set appropriate permissions on storage
7. **Database Security** - Use strong passwords and restrict access

## 🚀 Deployment

### Production Checklist
- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Configure production database
- [ ] Configure production mail server
- [ ] Set up SSL certificate
- [ ] Run `composer install --optimize-autoloader --no-dev`
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Set proper file permissions
- [ ] Change default admin password
- [ ] Configure backup strategy

### Web Server Configuration

#### Nginx Example
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/cms/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## 🛠️ Maintenance

### Clearing Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Running Queue Workers
```bash
php artisan queue:work --daemon
```

### Backup Database
```bash
# MySQL
mysqldump -u username -p database_name > backup.sql

# PostgreSQL
pg_dump database_name > backup.sql
```

## 📊 Performance Optimization

1. **Enable Caching** - Use Redis or Memcached for better performance
2. **Queue Jobs** - Process heavy tasks asynchronously
3. **Optimize Images** - Compress images before upload
4. **CDN Integration** - Serve static assets via CDN
5. **Database Indexing** - Already optimized in migrations

## 🐛 Troubleshooting

### Common Issues

**Issue: 500 Internal Server Error**
- Check file permissions on `storage` and `bootstrap/cache`
- Check Laravel logs in `storage/logs/laravel.log`
- Ensure `.env` file exists and is configured correctly

**Issue: Database Connection Error**
- Verify database credentials in `.env`
- Ensure database server is running
- Check database user permissions

**Issue: File Upload Fails**
- Check `storage` folder permissions
- Verify `php.ini` upload limits
- Ensure storage link is created

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🤝 Support

For issues, questions, or contributions, please contact your development team or system administrator.

## 🎯 Target Audience

This CMS is perfect for:
- **Publishers** - Monetize content with strategic ad placements
- **Businesses** - Manage corporate websites with ad revenue
- **Bloggers** - Professional blogging platform with monetization
- **Digital Agencies** - Manage multiple client websites
- **E-commerce** - Content marketing with ad integration

## 🔄 Updates

Keep your installation up to date:
```bash
git pull origin main
composer install
php artisan migrate
php artisan cache:clear
```

---

**Built with ❤️ using Laravel 12**
