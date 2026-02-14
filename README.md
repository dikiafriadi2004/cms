# Laravel CMS with Advanced Template System & Ads Management

A modern, feature-rich Content Management System built with Laravel 12, featuring 5 professional templates, advanced ads management, and comprehensive analytics integration. Perfect for businesses and publishers who want beautiful designs with powerful monetization capabilities.

## 🎯 Key Features

### 🎨 Advanced Template System
- **5 Professional Templates** - Default Modern, Minimal Clean, Magazine Bold, Corporate Professional, Elegant Luxury
- **Live Preview** - Preview templates before applying
- **No Fallbacks** - Every template has custom designs for all pages (Home, Blog, Contact, Pages)
- **Responsive Design** - All templates are mobile-friendly
- **Easy Switching** - Change templates instantly from admin panel

### 📝 Content Management
- **Posts & Pages** - Full CRUD with rich text editor and SEO optimization
- **Categories & Tags** - Organize content efficiently
- **Media Library** - Upload, organize, and manage files with drag-and-drop
- **Menu Builder** - Create dynamic navigation menus with drag-and-drop reordering
- **Featured Images** - Support for post and page featured images

### 💰 Advanced Ad Management System
- **Multiple Ad Positions** - Header, content_top, content_bottom, sidebar, between_posts, footer
- **Ad Types** - Code-based (HTML/JS), Image-based, or Link-based ads
- **Ad Analytics** - Track impressions and clicks in real-time with detailed dashboard
- **Ad Scheduling** - Set start and end dates for campaigns
- **Performance Tracking** - Monitor CTR, engagement metrics, and revenue
- **Ad Rotation** - Automatic rotation with configurable weights
- **Template Integration** - Ads work seamlessly across all templates

### 👥 User Management
- **Role-Based Access Control** - Super Admin, Admin, Editor, and Author roles
- **Granular Permissions** - 51 permissions for fine-grained control
- **User Profiles** - Customizable user information and bio
- **Secure Authentication** - Built with Laravel Breeze

### 🔍 SEO & Marketing
- **SEO Optimization** - Meta titles, descriptions, keywords, and Open Graph images
- **XML Sitemap** - Auto-generated sitemap for search engines
- **Social Media Integration** - Open Graph and Twitter Card support
- **SEO Helper Service** - Automatic SEO tag generation
- **Canonical URLs** - Proper canonical URL handling

### 📊 Analytics Integration
- **Google Analytics 4** - Full GA4 integration with tracking code
- **Google Tag Manager** - GTM container support
- **Facebook Pixel** - Facebook tracking integration
- **Analytics API** - Google Analytics Data API integration for dashboard stats
- **Real-time Tracking** - Track visitors, page views, and user behavior

### ⚙️ Comprehensive Settings System
- **10 Settings Tabs** - General, Branding, Template, SEO, Hero, Social, Footer, About Statistics, Mail, Analytics
- **51 Configurable Settings** - Control every aspect of your site
- **File Uploads** - Logo, favicon, hero image, OG image support
- **SMTP Configuration** - Full email configuration from admin panel
- **Hero Section** - Customizable homepage hero with CTA buttons
- **About Statistics** - Display key metrics (users, projects, satisfaction, etc.)

### 📧 Communication
- **Contact Form** - With email notifications and admin management
- **Auto-Reply** - Automatic reply to contact form submissions
- **Contact Management** - Track, read, and reply to messages from admin panel
- **Email Templates** - Professional email templates for notifications

### 🎯 Additional Features
- **Responsive Design** - Mobile-friendly interface across all templates
- **Modern UI** - Built with Tailwind CSS
- **View Counter** - Track post and page views
- **Search Functionality** - Built-in search for posts
- **Pagination** - Configurable pagination for listings

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

# Seed initial data (recommended)
php artisan db:seed
```

**What gets seeded:**
- **Roles & Permissions** - 4 roles (Super Admin, Admin, Editor, Author) with 51 permissions
- **Admin User** - Default admin account (admin@konterdigital.com / password)
- **Settings** - 51 pre-configured settings across 10 categories
- **Categories** - Sample blog categories
- **Tags** - Sample tags for content organization
- **Posts** - 20 sample blog posts with content
- **Menus** - Header and footer navigation menus
- **Ads** - 9 sample ads across different positions

**Or seed individually:**
```bash
php artisan db:seed --class=RolePermissionSeeder
php artisan db:seed --class=AdminUserSeeder
php artisan db:seed --class=SettingSeeder
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=TagSeeder
php artisan db:seed --class=PostSeeder
php artisan db:seed --class=MenuSeeder
php artisan db:seed --class=AdSeeder
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

**Email:** `admin@konterdigital.com`  
**Password:** `password`

**⚠️ IMPORTANT:** Change the password immediately after first login for security!

Navigate to `/admin` to access the admin panel.

## 🎨 Template System

### Available Templates

1. **Default Modern** - Gradient colorful design with animations (Blue gradient)
2. **Minimal Clean** - Ultra minimalist black & white design
3. **Magazine Bold** - Bold editorial style with red/orange accents
4. **Corporate Professional** - Trust-building blue design for business
5. **Elegant Luxury** - Sophisticated gold/amber design with serif fonts

### Changing Templates

1. Login to admin panel
2. Go to **Settings → Template**
3. Click **Preview Template** to see live preview
4. Select your preferred template
5. Click **Save Template Settings**

All templates include:
- Custom Home page design
- Custom Blog listing page
- Custom Blog post page
- Custom Contact page
- Custom static pages
- Full SEO support
- Ads integration
- Analytics tracking

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
1. **For Tracking (Frontend):**
   - Get your GA4 Measurement ID (G-XXXXXXXXXX)
   - Add to Settings → Analytics → Google Analytics ID

2. **For API Integration (Dashboard Stats):**
   - Create a service account in Google Cloud Console
   - Enable Google Analytics Data API
   - Download the JSON credentials file
   - Add service account email to GA4 property with Viewer role
   - Upload credentials via Settings → Analytics
   - Add Property ID (9-digit number)
   - Test connection

### Template Configuration
1. Go to **Settings → Template**
2. Preview available templates
3. Select your preferred design
4. Save settings

### Hero Section Configuration
1. Go to **Settings → Hero Section**
2. Configure title, subtitle, badge text
3. Upload hero image (350x700px recommended)
4. Set CTA button text and URL
5. Save settings

### About Statistics Configuration
1. Go to **Settings → About Statistics**
2. Configure 4 statistics with numbers and labels
3. Preview how they look
4. Save settings

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
2. Navigate to **Settings**
3. Use the 10 available tabs:
   - **General** - Site name, description, contact info
   - **Branding** - Logo and favicon
   - **Template** - Choose and preview templates
   - **SEO** - Meta tags and Open Graph image
   - **Hero Section** - Homepage hero content
   - **Social Media** - Social links and WhatsApp
   - **Footer** - Copyright and about text
   - **About Statistics** - Display key metrics
   - **Mail** - SMTP configuration
   - **Analytics** - GA4, GTM, Facebook Pixel

### Creating Custom Pages
1. Go to **Admin → Pages**
2. Click **Create New Page**
3. Add content with rich text editor
4. Configure SEO settings (meta title, description, keywords)
5. Upload featured image (optional)
6. Set as homepage (optional)
7. Publish when ready

### Managing Ads
1. Go to **Admin → Ads**
2. Click **Create New Ad**
3. Choose ad type:
   - **Code-based** - HTML/JavaScript ad code
   - **Image-based** - Upload image with link
   - **Link-based** - Simple text link
4. Select position (header, content_top, content_bottom, sidebar, between_posts, footer)
5. Set schedule (optional)
6. Configure rotation weight (optional)
7. Monitor performance in **Ad Analytics**

### Managing Blog Posts
1. Go to **Admin → Posts**
2. Create posts with categories and tags
3. Add featured images
4. Configure SEO for each post
5. Schedule publishing
6. Track views and engagement

### Managing Menus
1. Go to **Admin → Menus**
2. Create header and footer menus
3. Add menu items (pages, posts, custom links)
4. Drag and drop to reorder
5. Create nested menu items

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
6. **Template Caching** - Views are cached in production

## 📸 Screenshots & Features

### Admin Panel
- Modern, clean interface with Tailwind CSS
- Responsive design works on all devices
- Intuitive navigation and user-friendly forms
- Real-time statistics and charts

### Template System
- Live preview before applying
- Instant template switching
- No coding required
- All templates include SEO and ads support

### Ad Management
- Visual ad position selector
- Real-time performance tracking
- Click-through rate monitoring
- Revenue tracking capabilities

### Settings Management
- 10 organized tabs for easy navigation
- Live preview for templates
- File upload support for images
- Form validation and error handling

## 🔧 Advanced Configuration

### Custom Template Development
If you want to create your own template:

1. Create folder: `resources/views/frontend/templates/your-template/`
2. Create required views:
   - `home.blade.php` - Homepage
   - `blog/index.blade.php` - Blog listing
   - `blog/show.blade.php` - Single post
   - `contact.blade.php` - Contact page
   - `page.blade.php` - Static pages
3. Add template to `TemplateService::getAvailableTemplates()`
4. Template will appear in admin settings

### Custom Ad Positions
To add new ad positions:

1. Add position to `Ad` model's `$positions` array
2. Update ad views to include new position
3. Add position to templates where needed
4. Position will appear in ad creation form

### Email Template Customization
Email templates are located in:
- `resources/views/emails/` - Email layouts
- `app/Mail/` - Mail classes

Customize as needed for your brand.

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
- **Publishers** - Monetize content with strategic ad placements across 5 professional templates
- **Businesses** - Manage corporate websites with customizable templates and ad revenue
- **Bloggers** - Professional blogging platform with beautiful designs and monetization
- **Digital Agencies** - Manage multiple client websites with template flexibility
- **Content Creators** - Focus on content while the CMS handles design and monetization
- **Startups** - Launch quickly with ready-to-use templates and built-in features

## ✨ What Makes This CMS Special?

1. **5 Professional Templates** - No need to hire designers, choose from 5 ready-to-use designs
2. **Complete Feature Set** - Everything you need out of the box (SEO, Analytics, Ads, Contact)
3. **No Fallbacks** - Every template has custom designs for every page type
4. **Live Preview** - See templates before applying them
5. **Easy Customization** - 51 settings configurable from admin panel
6. **Advanced Analytics** - Track everything from visitors to ad performance
7. **Modern Tech Stack** - Built with Laravel 12 and Tailwind CSS
8. **Production Ready** - Includes seeders, migrations, and sample data

## 📈 Admin Dashboard Features

- **Overview Statistics** - Visitors, page views, posts, pages, ads
- **Recent Posts** - Quick access to latest content
- **Recent Contacts** - Manage contact form submissions
- **Ad Analytics** - Track ad performance with charts
- **User Management** - Manage users and roles
- **Settings Management** - Configure everything from one place

## 🎨 Template Characteristics

| Template | Color Scheme | Typography | Best For |
|----------|-------------|------------|----------|
| Default Modern | Blue Gradient | Sans-serif, Modern | Tech, Startup, Modern Business |
| Minimal Clean | Black & White | Sans-serif, Bold | Portfolio, Agency, Minimalist |
| Magazine Bold | Red/Orange | Sans-serif, Extra Bold | News, Blog, Media |
| Corporate Professional | Dark Blue | Sans-serif, Professional | Corporate, Finance, B2B |
| Elegant Luxury | Gold/Amber | Serif (Playfair), Elegant | Luxury, Premium, Fashion |

## 🔄 Updates

Keep your installation up to date:
```bash
git pull origin main
composer install
php artisan migrate
php artisan cache:clear
```

## ❓ Frequently Asked Questions

### Q: Can I use my own custom domain?
**A:** Yes, just update `APP_URL` in `.env` and configure your web server.

### Q: How do I change the default admin credentials?
**A:** Login with default credentials, go to Profile, and change your password.

### Q: Can I add more templates?
**A:** Yes! Follow the Custom Template Development guide in Advanced Configuration section.

### Q: Do all templates support ads?
**A:** Yes, all 5 templates have full ads integration across all positions.

### Q: How do I backup my data?
**A:** Backup your database and `storage/app/public` folder regularly.

### Q: Can I use this for multiple websites?
**A:** Yes, install separate instances for each website.

### Q: Is the CMS SEO-friendly?
**A:** Yes, includes meta tags, Open Graph, XML sitemap, and SEO helper service.

### Q: Can I customize the templates?
**A:** Yes, all template files are in `resources/views/frontend/templates/`.

### Q: How do I add Google Analytics?
**A:** Go to Settings → Analytics and add your GA4 Measurement ID.

### Q: Can I disable ads on specific pages?
**A:** Yes, configure ad visibility rules in the ad management system.

## 🆘 Getting Help

If you encounter issues:

1. Check `storage/logs/laravel.log` for error details
2. Review the Troubleshooting section above
3. Ensure all requirements are met
4. Verify `.env` configuration
5. Clear all caches: `php artisan optimize:clear`

## 🎓 Learning Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
- [Google Analytics Data API](https://developers.google.com/analytics/devguides/reporting/data/v1)

## 🏆 Credits

Built with these amazing packages:
- Laravel 12 - PHP Framework
- Tailwind CSS - Utility-first CSS
- Spatie Laravel Permission - Role & Permission management
- Spatie Laravel Analytics - Google Analytics integration
- TinyMCE - Rich text editor

---

**Built with ❤️ using Laravel 12 & Tailwind CSS**

**Version:** 1.0.0  
**Last Updated:** February 2026
