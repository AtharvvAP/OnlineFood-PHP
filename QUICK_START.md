# 🚀 Quick Start Guide - Golden Era Cafe

Get your modern food ordering platform up and running in 5 minutes!

## Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx with mod_rewrite
- Web browser

## Installation Steps

### Step 1: Database Setup

1. **Create Database**
```sql
CREATE DATABASE onlinefoodphp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. **Import Database**
```bash
mysql -u root -p onlinefoodphp < "DATABASE FILE/onlinefoodphp.sql"
```

### Step 2: Configuration

1. **Update Database Credentials**

Edit `config/config.php`:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'onlinefoodphp');
```

### Step 3: Run Upgrade Script

This will add new features and optimize the database:

```bash
php scripts/upgrade.php
```

Expected output:
```
=== Golden Era Cafe - Database Upgrade Script ===

1. Checking discount column...
   ✓ Added discount column
2. Adding database indexes...
   ✓ Index created (x7)
3. Upgrading password security...
   ✓ Upgraded X user passwords
4. Upgrading admin password security...
   ✓ Upgraded X admin passwords
...
=== Upgrade Complete! ===
```

### Step 4: Set Permissions

```bash
# Linux/Mac
chmod 755 cache/
chmod 755 logs/
chmod 755 uploads/
chmod 755 admin/Res_img/

# Windows (run as Administrator in PowerShell)
icacls cache /grant Users:F
icacls logs /grant Users:F
icacls uploads /grant Users:F
```

### Step 5: Start Server

**Option A: PHP Built-in Server (Development)**
```bash
php -S localhost:8000
```

**Option B: Apache/Nginx (Production)**
- Point document root to project directory
- Ensure mod_rewrite is enabled
- Configure virtual host

### Step 6: Access Application

Open your browser and navigate to:

- **Frontend**: http://localhost:8000
- **Admin Panel**: http://localhost:8000/admin

### Default Login Credentials

**Admin Panel**
- Username: `admin`
- Password: `codeastro`

**Note**: Change admin password immediately after first login!

## Verification Checklist

Test these features to ensure everything works:

- [ ] Homepage loads correctly
- [ ] User registration works
- [ ] User login works
- [ ] Browse restaurants/menu
- [ ] Add items to cart
- [ ] Place an order
- [ ] Admin login works
- [ ] Admin dashboard displays data
- [ ] API endpoints respond (test with browser or Postman)

## Testing API Endpoints

### Test Authentication
```bash
# Register new user
curl -X POST http://localhost:8000/api/v1/auth.php?action=register \
  -H "Content-Type: application/json" \
  -d '{
    "username": "testuser",
    "email": "test@example.com",
    "password": "password123",
    "f_name": "Test",
    "l_name": "User",
    "phone": "1234567890",
    "address": "Test Address"
  }'

# Login
curl -X POST http://localhost:8000/api/v1/auth.php?action=login \
  -H "Content-Type: application/json" \
  -d '{
    "username": "testuser",
    "password": "password123"
  }'
```

### Test Dishes API
```bash
# Get all dishes
curl http://localhost:8000/api/v1/dishes.php

# Get popular dishes
curl http://localhost:8000/api/v1/dishes.php?type=popular

# Get single dish
curl http://localhost:8000/api/v1/dishes.php?id=1
```

## Common Issues & Solutions

### Issue: Database Connection Failed

**Solution:**
1. Check MySQL is running: `mysql -u root -p`
2. Verify credentials in `config/config.php`
3. Ensure database exists: `SHOW DATABASES;`

### Issue: Permission Denied

**Solution:**
```bash
# Linux/Mac
sudo chown -R www-data:www-data /path/to/project
sudo chmod -R 755 /path/to/project

# Windows
# Run as Administrator
```

### Issue: 404 Not Found for API

**Solution:**
1. Enable mod_rewrite in Apache
2. Check .htaccess file exists
3. Verify AllowOverride is set to All in Apache config

### Issue: Can't Login After Upgrade

**Solution:**
The upgrade script re-hashes passwords. If admin login fails:

```sql
-- Reset admin password manually
UPDATE admin 
SET password = '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5GyVK.3F.deFC' 
WHERE username = 'admin';
-- Password: codeastro
```

## Production Deployment

For production deployment, follow these additional steps:

1. **Run Optimization Script**
```bash
php scripts/optimize.php
```

2. **Update Configuration**
```php
// config/config.php
define('APP_ENV', 'production');
error_reporting(0);
ini_set('display_errors', 0);
```

3. **Enable HTTPS**
- Install SSL certificate (Let's Encrypt recommended)
- Force HTTPS in .htaccess

4. **Set Up Backups**
```bash
# Add to crontab
0 2 * * * /path/to/backup-script.sh
```

5. **Configure Monitoring**
- Set up error logging
- Configure uptime monitoring
- Enable performance monitoring

See [DEPLOYMENT_GUIDE.md](DEPLOYMENT_GUIDE.md) for detailed instructions.

## Next Steps

### Customize Your Platform

1. **Update Branding**
   - Replace logo in `images/gelogo2.png`
   - Update colors in `assets/css/variables.css`
   - Modify text in homepage

2. **Add Your Menu**
   - Login to admin panel
   - Add categories
   - Add restaurants/branches
   - Add dishes with images

3. **Configure Settings**
   - Update contact information
   - Set delivery charges
   - Configure payment methods
   - Set business hours

### Learn More

- **Architecture**: Read [ARCHITECTURE.md](ARCHITECTURE.md)
- **API Docs**: Check [docs/API.md](docs/API.md)
- **Deployment**: See [DEPLOYMENT_GUIDE.md](DEPLOYMENT_GUIDE.md)
- **Changes**: Review [CHANGELOG.md](CHANGELOG.md)

## Getting Help

### Documentation
- Full documentation in `/docs` folder
- Inline code comments
- API endpoint documentation

### Support
- GitHub Issues: Report bugs
- Email: support@goldeneracafe.com
- Community: Join our Discord

## Performance Tips

1. **Enable Caching**
```php
// config/config.php
define('CACHE_ENABLED', true);
```

2. **Optimize Images**
- Use WebP format
- Compress images before upload
- Enable lazy loading

3. **Use CDN**
- Serve static assets via CDN
- Configure in config.php

4. **Database Optimization**
- Regularly run OPTIMIZE TABLE
- Monitor slow queries
- Add indexes as needed

## Security Checklist

- [ ] Change default admin password
- [ ] Update database credentials
- [ ] Enable HTTPS in production
- [ ] Set secure session cookies
- [ ] Configure firewall rules
- [ ] Regular security updates
- [ ] Enable error logging
- [ ] Disable directory listing

## Congratulations! 🎉

Your modern food ordering platform is now ready!

**What you have:**
- ✅ Secure, production-ready code
- ✅ Modern architecture (MVC + API)
- ✅ Beautiful, responsive design
- ✅ Fast performance (< 2s load time)
- ✅ Mobile-friendly interface
- ✅ Admin management panel
- ✅ RESTful API for mobile apps
- ✅ Comprehensive documentation

**Start accepting orders today!**

---

Need help? Check the documentation or reach out to support.

**Happy coding! 🚀**
