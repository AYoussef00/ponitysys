# دليل النشر - PointSys

## متطلبات الخادم

### المتطلبات الأساسية
- **PHP**: 8.1 أو أحدث
- **MySQL**: 5.7 أو أحدث
- **Web Server**: Apache 2.4+ أو Nginx 1.18+
- **SSL Certificate**: شهادة SSL صالحة
- **Composer**: 2.0 أو أحدث

### إضافات PHP المطلوبة
```bash
php-bcmath
php-curl
php-dom
php-gd
php-mbstring
php-mysql
php-xml
php-zip
```

## خطوات النشر

### 1. إعداد الخادم

#### Apache Configuration
```apache
<VirtualHost *:80>
    ServerName pointsys.clarastars.com
    Redirect permanent / https://pointsys.clarastars.com/
</VirtualHost>

<VirtualHost *:443>
    ServerName pointsys.clarastars.com
    DocumentRoot /var/www/pointsys/public
    
    SSLEngine on
    SSLCertificateFile /path/to/certificate.crt
    SSLCertificateKeyFile /path/to/private.key
    
    <Directory /var/www/pointsys/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/pointsys_error.log
    CustomLog ${APACHE_LOG_DIR}/pointsys_access.log combined
</VirtualHost>
```

#### Nginx Configuration
```nginx
server {
    listen 80;
    server_name pointsys.clarastars.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name pointsys.clarastars.com;
    
    ssl_certificate /path/to/certificate.crt;
    ssl_certificate_key /path/to/private.key;
    
    root /var/www/pointsys/public;
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### 2. رفع الملفات

```bash
# إنشاء مجلد المشروع
sudo mkdir -p /var/www/pointsys
sudo chown -R $USER:www-data /var/www/pointsys

# رفع الملفات
git clone https://github.com/AYoussef00/ponitysys.git /var/www/pointsys
cd /var/www/pointsys

# تعيين الصلاحيات
sudo chown -R www-data:www-data /var/www/pointsys
sudo chmod -R 755 /var/www/pointsys
sudo chmod -R 775 /var/www/pointsys/storage
sudo chmod -R 775 /var/www/pointsys/bootstrap/cache
```

### 3. إعداد البيئة

```bash
# نسخ ملف البيئة
cp .env.example .env

# تعديل ملف .env
nano .env
```

#### إعدادات ملف .env للإنتاج
```env
APP_NAME="PointSys - نظام النقاط"
APP_ENV=production
APP_KEY=base64:your-generated-key
APP_DEBUG=false
APP_URL=https://pointsys.clarastars.com

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pointsys_production
DB_USERNAME=pointsys_user
DB_PASSWORD=strong_password_here

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email@pointsys.clarastars.com
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@pointsys.clarastars.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 4. إعداد قاعدة البيانات

```bash
# إنشاء قاعدة البيانات
mysql -u root -p
CREATE DATABASE pointsys_production;
CREATE USER 'pointsys_user'@'localhost' IDENTIFIED BY 'strong_password_here';
GRANT ALL PRIVILEGES ON pointsys_production.* TO 'pointsys_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;

# تشغيل الـ migrations
php artisan migrate --force

# إضافة البيانات الأولية
php artisan db:seed --force
```

### 5. تثبيت التبعيات

```bash
# تثبيت PHP dependencies
composer install --optimize-autoloader --no-dev

# تثبيت Node.js dependencies
npm install

# بناء الأصول
npm run build
```

### 6. تحسين الأداء

```bash
# توليد مفتاح التطبيق
php artisan key:generate

# تحسين التكوين
php artisan config:cache
php artisan route:cache
php artisan view:cache

# تحسين التطبيق
php artisan optimize
```

### 7. إعداد Cron Jobs

```bash
# إضافة Cron Job للـ Laravel Scheduler
crontab -e

# إضافة السطر التالي
* * * * * cd /var/www/pointsys && php artisan schedule:run >> /dev/null 2>&1
```

### 8. إعداد Supervisor (اختياري)

```bash
# إنشاء ملف Supervisor
sudo nano /etc/supervisor/conf.d/pointsys.conf
```

```ini
[program:pointsys-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/pointsys/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/pointsys/storage/logs/worker.log
stopwaitsecs=3600
```

```bash
# تشغيل Supervisor
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start pointsys-worker:*
```

## الصيانة والتحديثات

### التحديث التلقائي
```bash
#!/bin/bash
# update-pointsys.sh

cd /var/www/pointsys

# إيقاف التطبيق
php artisan down

# جلب التحديثات
git pull origin main

# تثبيت التبعيات
composer install --optimize-autoloader --no-dev
npm install
npm run build

# تشغيل الـ migrations
php artisan migrate --force

# تحسين التطبيق
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# إعادة تشغيل التطبيق
php artisan up

# إعادة تشغيل Supervisor
sudo supervisorctl restart pointsys-worker:*
```

### النسخ الاحتياطي
```bash
#!/bin/bash
# backup-pointsys.sh

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backups/pointsys"

# إنشاء مجلد النسخ الاحتياطي
mkdir -p $BACKUP_DIR

# نسخ قاعدة البيانات
mysqldump -u pointsys_user -p pointsys_production > $BACKUP_DIR/database_$DATE.sql

# نسخ الملفات
tar -czf $BACKUP_DIR/files_$DATE.tar.gz /var/www/pointsys

# حذف النسخ الاحتياطية القديمة (أكثر من 30 يوم)
find $BACKUP_DIR -name "*.sql" -mtime +30 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +30 -delete
```

## المراقبة والأمان

### مراقبة السجلات
```bash
# مراقبة سجلات Laravel
tail -f /var/www/pointsys/storage/logs/laravel.log

# مراقبة سجلات Apache
tail -f /var/log/apache2/pointsys_error.log

# مراقبة سجلات Nginx
tail -f /var/log/nginx/pointsys_error.log
```

### إعدادات الأمان
```bash
# تعيين صلاحيات آمنة
sudo chown -R www-data:www-data /var/www/pointsys
sudo chmod -R 755 /var/www/pointsys
sudo chmod -R 775 /var/www/pointsys/storage
sudo chmod -R 775 /var/www/pointsys/bootstrap/cache

# حماية ملف .env
sudo chmod 600 /var/www/pointsys/.env
```

### SSL/TLS
```bash
# تجديد شهادة SSL تلقائياً (Let's Encrypt)
sudo certbot renew --dry-run

# إضافة إلى Cron
0 12 * * * /usr/bin/certbot renew --quiet
```

## استكشاف الأخطاء

### مشاكل شائعة

#### خطأ في قاعدة البيانات
```bash
# فحص الاتصال
php artisan tinker --execute="echo DB::connection()->getPdo() ? 'OK' : 'FAILED';"

# إعادة تشغيل الـ migrations
php artisan migrate:fresh --seed
```

#### خطأ في الصلاحيات
```bash
# إصلاح الصلاحيات
sudo chown -R www-data:www-data /var/www/pointsys
sudo chmod -R 755 /var/www/pointsys
sudo chmod -R 775 /var/www/pointsys/storage
```

#### خطأ في الـ Cache
```bash
# مسح جميع الـ caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

## الدعم

للدعم الفني أو الاستفسارات:
- البريد الإلكتروني: support@clarastars.com
- الموقع: https://pointsys.clarastars.com
- التوثيق: https://pointsys.clarastars.com/docs 
