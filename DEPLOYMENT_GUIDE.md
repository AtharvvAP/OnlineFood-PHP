# 🚀 Deployment Guide - Golden Era Cafe

## Production Deployment Checklist

### 1. Pre-Deployment

#### Security Hardening
```php
// config/config.php - Production Settings
error_reporting(0);
ini_set('display_errors', 0);
define('APP_ENV', 'production');

// Enable HTTPS only
ini_set('session.cookie_secure', 1);
```

#### Environment Configuration
```bash
# Create .env file
DB_HOST=your-production-host
DB_USER=your-db-user
DB_PASS=your-secure-password
DB_NAME=onlinefoodphp
APP_URL=https://yourdomain.com
SMTP_HOST=smtp.gmail.com
SMTP_USER=your-email@gmail.com
SMTP_PASS=your-app-password
```

#### Database Optimization
```sql
-- Add indexes
CREATE INDEX idx_dishes_restaurant ON dishes(rs_id);
CREATE INDEX idx_orders_user ON users_orders(u_id);
CREATE INDEX idx_orders_status ON users_orders(status);
CREATE INDEX idx_orders_date ON users_orders(date);
CREATE INDEX idx_users_username ON users(username);
CREATE INDEX idx_users_email ON users(email);

-- Optimize tables
OPTIMIZE TABLE users;
OPTIMIZE TABLE dishes;
OPTIMIZE TABLE users_orders;
OPTIMIZE TABLE restaurant;
```

### 2. Server Requirements

#### Minimum Requirements
- **PHP**: 7.4 or higher
- **MySQL**: 5.7 or higher
- **Apache**: 2.4+ with mod_rewrite
- **Memory**: 512MB RAM minimum
- **Storage**: 10GB minimum

#### Recommended Requirements
- **PHP**: 8.0+
- **MySQL**: 8.0+
- **Memory**: 2GB RAM
- **Storage**: 50GB SSD
- **SSL Certificate**: Let's Encrypt or commercial

### 3. Apache Configuration

#### .htaccess (Root Directory)
```apache
# Enable Rewrite Engine
RewriteEngine On

# Force HTTPS
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# API Routing
RewriteRule ^api/v1/(.*)$ api/v1/$1 [L]

# Security Headers
<IfModule mod_headers.c>
    Header set X-Content-Type-Options "nosniff"
    Header set X-Frame-Options "SAMEORIGIN"
    Header set X-XSS-Protection "1; mode=block"
    Header set Referrer-Policy "strict-origin-when-cross-origin"
    Header set Content-Security-Policy "default-src 'self'; script-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data: https:;"
</IfModule>

# Disable Directory Browsing
Options -Indexes

# Protect sensitive files
<FilesMatch "^\.">
    Order allow,deny
    Deny from all
</FilesMatch>

# PHP Security
php_flag display_errors Off
php_flag log_errors On
php_value error_log /var/log/php_errors.log
</apache>
```

#### Virtual Host Configuration
```apache
<VirtualHost *:443>
    ServerName yourdomain.com
    ServerAlias www.yourdomain.com
    DocumentRoot /var/www/golden-era-cafe
    
    SSLEngine on
    SSLCertificateFile /path/to/cert.pem
    SSLCertificateKeyFile /path/to/key.pem
    
    <Directory /var/www/golden-era-cafe>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    # Logging
    ErrorLog ${APACHE_LOG_DIR}/golden-era-error.log
    CustomLog ${APACHE_LOG_DIR}/golden-era-access.log combined
</VirtualHost>
```

### 4. Nginx Configuration (Alternative)

```nginx
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name yourdomain.com www.yourdomain.com;
    
    root /var/www/golden-era-cafe;
    index index.php index.html;
    
    ssl_certificate /path/to/cert.pem;
    ssl_certificate_key /path/to/key.pem;
    
    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    
    # PHP Processing
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    # API Routes
    location /api/ {
        try_files $uri $uri/ /api/index.php?$query_string;
    }
    
    # Static Files
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
    
    # Deny access to sensitive files
    location ~ /\. {
        deny all;
    }
}
```

### 5. File Permissions

```bash
# Set ownership
sudo chown -R www-data:www-data /var/www/golden-era-cafe

# Set directory permissions
find /var/www/golden-era-cafe -type d -exec chmod 755 {} \;

# Set file permissions
find /var/www/golden-era-cafe -type f -exec chmod 644 {} \;

# Writable directories
chmod 775 /var/www/golden-era-cafe/uploads
chmod 775 /var/www/golden-era-cafe/admin/Res_img
chmod 775 /var/www/golden-era-cafe/logs
```

### 6. Database Migration

```bash
# Backup existing database
mysqldump -u root -p onlinefoodphp > backup_$(date +%Y%m%d).sql

# Import to production
mysql -u production_user -p production_db < onlinefoodphp.sql

# Run optimization
mysql -u production_user -p production_db < database_optimization.sql
```

### 7. SSL Certificate (Let's Encrypt)

```bash
# Install Certbot
sudo apt-get update
sudo apt-get install certbot python3-certbot-apache

# Obtain certificate
sudo certbot --apache -d yourdomain.com -d www.yourdomain.com

# Auto-renewal
sudo certbot renew --dry-run
```

### 8. Performance Optimization

#### PHP Configuration (php.ini)
```ini
; Production Settings
display_errors = Off
log_errors = On
error_log = /var/log/php_errors.log

; Performance
memory_limit = 256M
max_execution_time = 30
max_input_time = 60
post_max_size = 20M
upload_max_filesize = 10M

; OPcache
opcache.enable = 1
opcache.memory_consumption = 128
opcache.interned_strings_buffer = 8
opcache.max_accelerated_files = 10000
opcache.revalidate_freq = 2
opcache.fast_shutdown = 1
```

#### MySQL Configuration (my.cnf)
```ini
[mysqld]
# Performance
innodb_buffer_pool_size = 1G
innodb_log_file_size = 256M
innodb_flush_log_at_trx_commit = 2
innodb_flush_method = O_DIRECT

# Query Cache
query_cache_type = 1
query_cache_size = 64M
query_cache_limit = 2M

# Connections
max_connections = 200
```

### 9. Monitoring Setup

#### Install Monitoring Tools
```bash
# Install New Relic (optional)
wget -O - https://download.newrelic.com/548C16BF.gpg | sudo apt-key add -
sudo apt-get install newrelic-php5

# Install monitoring scripts
sudo apt-get install sysstat htop
```

#### Log Rotation
```bash
# /etc/logrotate.d/golden-era-cafe
/var/www/golden-era-cafe/logs/*.log {
    daily
    rotate 14
    compress
    delaycompress
    notifempty
    create 0640 www-data www-data
    sharedscripts
}
```

### 10. Backup Strategy

#### Automated Backup Script
```bash
#!/bin/bash
# backup.sh

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backups/golden-era-cafe"
DB_NAME="onlinefoodphp"
DB_USER="backup_user"
DB_PASS="backup_password"

# Create backup directory
mkdir -p $BACKUP_DIR

# Database backup
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME | gzip > $BACKUP_DIR/db_$DATE.sql.gz

# Files backup
tar -czf $BACKUP_DIR/files_$DATE.tar.gz /var/www/golden-era-cafe

# Remove old backups (keep 30 days)
find $BACKUP_DIR -type f -mtime +30 -delete

echo "Backup completed: $DATE"
```

#### Cron Job
```bash
# Add to crontab
0 2 * * * /usr/local/bin/backup.sh >> /var/log/backup.log 2>&1
```

### 11. CDN Integration (Optional)

#### Cloudflare Setup
1. Add domain to Cloudflare
2. Update nameservers
3. Enable SSL/TLS (Full)
4. Enable Auto Minify (JS, CSS, HTML)
5. Enable Brotli compression
6. Set caching rules

### 12. Post-Deployment Testing

#### Checklist
- [ ] SSL certificate valid
- [ ] All pages load correctly
- [ ] API endpoints working
- [ ] Database connections stable
- [ ] File uploads working
- [ ] Email notifications working
- [ ] Payment gateway (if integrated)
- [ ] Mobile responsiveness
- [ ] Performance (GTmetrix/PageSpeed)
- [ ] Security scan (OWASP ZAP)

#### Testing Commands
```bash
# Test SSL
openssl s_client -connect yourdomain.com:443

# Test response time
curl -w "@curl-format.txt" -o /dev/null -s https://yourdomain.com

# Check PHP version
php -v

# Check MySQL connection
mysql -u user -p -e "SELECT 1"
```

### 13. Rollback Plan

```bash
# Restore database
mysql -u root -p onlinefoodphp < backup_YYYYMMDD.sql

# Restore files
tar -xzf files_YYYYMMDD.tar.gz -C /

# Clear cache
php artisan cache:clear  # if using Laravel
# or
rm -rf /var/www/golden-era-cafe/cache/*
```

### 14. Maintenance Mode

```php
// maintenance.php
<?php
http_response_code(503);
header('Retry-After: 3600');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Maintenance Mode</title>
    <style>
        body { font-family: Arial; text-align: center; padding: 50px; }
        h1 { color: #FF6B35; }
    </style>
</head>
<body>
    <h1>🔧 Under Maintenance</h1>
    <p>We're making improvements. Please check back soon!</p>
</body>
</html>
```

### 15. Support & Troubleshooting

#### Common Issues

**Database Connection Failed**
```bash
# Check MySQL status
sudo systemctl status mysql

# Check credentials
mysql -u username -p

# Check firewall
sudo ufw status
```

**Permission Denied**
```bash
# Fix permissions
sudo chown -R www-data:www-data /var/www/golden-era-cafe
sudo chmod -R 755 /var/www/golden-era-cafe
```

**500 Internal Server Error**
```bash
# Check error logs
tail -f /var/log/apache2/error.log
tail -f /var/log/php_errors.log
```

---

## 🎉 Deployment Complete!

Your Golden Era Cafe platform is now live and optimized for production use.

**Next Steps:**
1. Monitor logs for first 24 hours
2. Set up analytics (Google Analytics)
3. Configure backup verification
4. Schedule regular security audits
5. Plan for scaling as traffic grows

**Support:** For issues, check logs first, then consult documentation.
