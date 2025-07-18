# دليل استخدام Seeders - PointSys

## نظرة عامة
هذا الدليل يوضح كيفية استخدام الـ seeders المختلفة لإضافة بيانات تجريبية للنظام.

## الـ Seeders المتاحة

### 1. AdminSeeder
**الوصف**: إنشاء المستخدم الإداري الأساسي
**البيانات**:
- البريد الإلكتروني: `admin@admin.com`
- كلمة المرور: `admin123`
- الاسم: `Admin`

**الاستخدام**:
```bash
php artisan db:seed --class=AdminSeeder
```

### 2. RentLuxuriaSeeder
**الوصف**: إنشاء المستخدم `info@rentluxuria.com`
**البيانات**:
- البريد الإلكتروني: `info@rentluxuria.com`
- كلمة المرور: `luxuria123`
- الاسم: `Luxuria Cars Rental`

**الاستخدام**:
```bash
php artisan db:seed --class=RentLuxuriaSeeder
```

### 3. CompleteRentLuxuriaSeeder
**الوصف**: إنشاء حساب Luxuria Cars Rental كاملاً مع جميع البيانات
**يشمل**:
- إنشاء/تحديث المستخدم
- إنشاء 10 عملاء
- إنشاء 5 مكافآت
- إنشاء معاملات تجريبية
- إنشاء 3 مفاتيح API

**الاستخدام**:
```bash
php artisan db:seed --class=CompleteRentLuxuriaSeeder
```

### 4. AddTransactionsSeeder
**الوصف**: إضافة معاملات إضافية للمستخدم الموجود
**الاستخدام**:
```bash
php artisan db:seed --class=AddTransactionsSeeder
```

## تشغيل جميع الـ Seeders

### الطريقة الأولى: تشغيل DatabaseSeeder
```bash
php artisan db:seed
```
هذا سيشغل:
- AdminSeeder
- RentLuxuriaSeeder

### الطريقة الثانية: تشغيل seeder محدد
```bash
php artisan db:seed --class=CompleteRentLuxuriaSeeder
```

### الطريقة الثالثة: تشغيل عدة seeders
```bash
php artisan db:seed --class=AdminSeeder
php artisan db:seed --class=CompleteRentLuxuriaSeeder
```

## بيانات المستخدمين الجاهزة

### المستخدم الإداري
- **البريد الإلكتروني**: `admin@admin.com`
- **كلمة المرور**: `admin123`
- **الاسم**: `Admin`

### مستخدم Luxuria Cars Rental
- **البريد الإلكتروني**: `info@rentluxuria.com`
- **كلمة المرور**: `luxuria123`
- **الاسم**: `Luxuria Cars Rental`

## البيانات التجريبية

### العملاء (Luxuria Cars Rental)
1. أحمد محمد - `customer1@luxuria.com`
2. فاطمة علي - `customer2@luxuria.com`
3. محمد عبدالله - `customer3@luxuria.com`
4. سارة أحمد - `customer4@luxuria.com`
5. علي حسن - `customer5@luxuria.com`
6. نور الدين - `customer6@luxuria.com`
7. مريم خالد - `customer7@luxuria.com`
8. عبدالرحمن يوسف - `customer8@luxuria.com`
9. ليلى أحمد - `customer9@luxuria.com`
10. حسن محمد - `customer10@luxuria.com`

### المكافآت (Luxuria Cars Rental)
1. خصم 10% على الإيجار (500 نقطة)
2. إيجار مجاني ليوم واحد (1000 نقطة)
3. ترقية مجانية (750 نقطة)
4. خصم 20% على الإيجار الأسبوعي (1500 نقطة)
5. إضافة سائق مجاني (800 نقطة)

### مفاتيح API (Luxuria Cars Rental)
1. Luxuria Mobile App (production)
2. Luxuria Website (production)
3. Luxuria Testing (test)

## ملاحظات مهمة

### الأمان
- جميع كلمات المرور مشفرة باستخدام Laravel Hash
- البيانات التجريبية آمنة للاستخدام في البيئة التجريبية

### التكرار
- الـ seeders تتحقق من وجود البيانات قبل إنشائها
- لا يتم إنشاء بيانات مكررة
- يمكن تشغيل الـ seeders عدة مرات بأمان

### التخصيص
- يمكن تعديل الـ seeders لإضافة بيانات مختلفة
- يمكن إضافة seeders جديدة لشركات أخرى

## استكشاف الأخطاء

### خطأ: Duplicate entry
**السبب**: البيانات موجودة بالفعل
**الحل**: الـ seeders تتعامل مع هذا تلقائياً

### خطأ: Column already exists
**السبب**: مشكلة في قاعدة البيانات
**الحل**: تشغيل `php artisan migrate:fresh --seed`

### خطأ: Class not found
**السبب**: الـ seeder غير موجود
**الحل**: التأكد من وجود الملف في `database/seeders/`

## أمثلة استخدام

### إنشاء حساب جديد لشركة
```bash
# 1. إنشاء المستخدم
php artisan tinker
User::create([
    'name' => 'شركة جديدة',
    'email' => 'info@newcompany.com',
    'password' => Hash::make('password123'),
    'email_verified_at' => now(),
]);

# 2. إنشاء بيانات تجريبية
# (يمكن إنشاء seeder مخصص)
```

### إضافة عملاء جدد
```bash
php artisan tinker
$user = User::where('email', 'info@rentluxuria.com')->first();
Customer::create([
    'user_id' => $user->id,
    'name' => 'عميل جديد',
    'phone' => '966500000011',
    'email' => 'newcustomer@luxuria.com',
    'points_balance' => 0,
    'tier' => 'bronze',
    'status' => 'active'
]);
```

## الدعم
للمساعدة في استخدام الـ seeders:
- راجع ملفات الـ seeders في `database/seeders/`
- استخدم `php artisan tinker` للتفاعل المباشر مع قاعدة البيانات
- راجع التوثيق في `README.md` 
