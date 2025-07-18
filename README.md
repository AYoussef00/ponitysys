# PointSys - نظام إدارة الولاء

نظام متكامل لإدارة برامج الولاء والنقاط للشركات والمتاجر.

## المميزات الرئيسية

### 🔐 نظام متعدد المستخدمين (Multi-Tenancy)
- كل شركة لها حساب منفصل
- عزل كامل للبيانات بين الشركات
- إدارة مستقلة للعملاء والنقاط والمكافآت

### 📱 واجهة برمجة التطبيقات (API)
- RESTful API كامل
- مصادقة باستخدام API Keys
- دعم للبيئة التجريبية والإنتاج
- Webhooks للتكامل مع الأنظمة الخارجية

### 🎯 إدارة العملاء
- تسجيل العملاء
- تتبع رصيد النقاط
- إدارة المستويات (Tiers)
- سجل كامل للمعاملات

### 🏆 نظام المكافآت
- إنشاء مكافآت متنوعة
- استبدال النقاط بالمكافآت
- إدارة الكميات والتواريخ

### 📊 التحليلات والتقارير
- لوحة تحكم تفاعلية
- إحصائيات مفصلة
- تقارير قابلة للتصدير
- رسوم بيانية

### ⚙️ الإعدادات المتقدمة
- إدارة مفاتيح API
- إعدادات Webhooks
- تكامل مع التطبيقات المحمولة
- دليل API شامل

## التثبيت والإعداد

### المتطلبات
- PHP 8.1 أو أحدث
- Laravel 10.x
- MySQL 5.7 أو أحدث
- Composer
- Node.js & NPM

### خطوات التثبيت

1. **استنساخ المشروع**
```bash
git clone https://github.com/AYoussef00/ponitysys.git
cd ponitysys
```

2. **تثبيت التبعيات**
```bash
composer install
npm install
```

3. **إعداد البيئة**
```bash
cp .env.example .env
php artisan key:generate
```

4. **تكوين قاعدة البيانات**
```bash
# تعديل ملف .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pointsys
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. **تشغيل الـ Migrations**
```bash
php artisan migrate
```

6. **إضافة البيانات الأولية**
```bash
php artisan db:seed
```

7. **بناء الأصول**
```bash
npm run build
```

8. **تشغيل الخادم**
```bash
php artisan serve
```

## استخدام API

### Base URL
```
https://pointsys.clarastars.com/api/v1
```

### المصادقة
```bash
Authorization: Bearer YOUR_API_KEY
```

### أمثلة الاستخدام

#### تسجيل عميل جديد
```bash
curl -X POST https://pointsys.clarastars.com/api/v1/customers/register \
  -H "Authorization: Bearer YOUR_API_KEY" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "أحمد محمد",
    "email": "ahmed@example.com",
    "phone": "0501234567"
  }'
```

#### إضافة نقاط
```bash
curl -X POST https://pointsys.clarastars.com/api/v1/customers/points/add \
  -H "Authorization: Bearer YOUR_API_KEY" \
  -H "Content-Type: application/json" \
  -d '{
    "customer_id": 1,
    "points": 100,
    "description": "شراء منتج",
    "reference_id": "ORDER_12345"
  }'
```

#### استعلام الرصيد
```bash
curl -X GET https://pointsys.clarastars.com/api/v1/customers/1/balance \
  -H "Authorization: Bearer YOUR_API_KEY"
```

## هيكل المشروع

```
loyaltySaas/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/           # API Controllers
│   │   │   └── ...            # Web Controllers
│   │   └── Middleware/        # Custom Middleware
│   └── Models/                # Eloquent Models
├── database/
│   ├── migrations/            # Database Migrations
│   └── seeders/              # Database Seeders
├── resources/
│   ├── views/                # Blade Templates
│   ├── css/                  # Stylesheets
│   └── js/                   # JavaScript
├── routes/
│   ├── api.php              # API Routes
│   └── web.php              # Web Routes
└── public/                  # Public Assets
```

## المساهمة

1. Fork المشروع
2. إنشاء branch جديد (`git checkout -b feature/AmazingFeature`)
3. Commit التغييرات (`git commit -m 'Add some AmazingFeature'`)
4. Push إلى Branch (`git push origin feature/AmazingFeature`)
5. فتح Pull Request

## الترخيص

هذا المشروع مرخص تحت رخصة MIT - انظر ملف [LICENSE](LICENSE) للتفاصيل.

## الدعم

للدعم الفني أو الاستفسارات:
- البريد الإلكتروني: support@clarastars.com
- الموقع: https://pointsys.clarastars.com

## التحديثات

### الإصدار 1.0.0
- إطلاق النظام الأساسي
- دعم Multi-tenancy
- API كامل
- واجهة إدارة متقدمة
- نظام تقارير شامل
