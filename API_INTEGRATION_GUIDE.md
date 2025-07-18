# دليل ربط التطبيق - PointSys API

## نظرة عامة
هذا الدليل يوضح كيفية ربط التطبيق الآخر مع نظام PointSys لإدارة النقاط والولاء.

## معلومات الاتصال الأساسية

### Base URL
```
https://pointsys.clarastars.com/api/v1
```

### API Key للمستخدم info@rentluxuria.com
```
lux_M01oRXyMzqM3tPDtN4ELFNQ50lRLY25a
```

### Headers المطلوبة
```http
Authorization: Bearer lux_M01oRXyMzqM3tPDtN4ELFNQ50lRLY25a
Content-Type: application/json
Accept: application/json
```

## الـ API Endpoints

### 1. تسجيل عميل جديد
**الرابط**: `POST /api/v1/customers/register`

**الاستخدام**: عندما يسجل مستخدم جديد في التطبيق، يتم تسجيله تلقائياً في نظام النقاط

**cURL Example**:
```bash
curl -X POST https://pointsys.clarastars.com/api/v1/customers/register \
  -H "Authorization: Bearer lux_M01oRXyMzqM3tPDtN4ELFNQ50lRLY25a" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "أحمد محمد",
    "email": "ahmed@example.com",
    "phone": "966500000001"
  }'
```

**JavaScript Example**:
```javascript
const registerCustomer = async (customerData) => {
  try {
    const response = await fetch('https://pointsys.clarastars.com/api/v1/customers/register', {
      method: 'POST',
      headers: {
        'Authorization': 'Bearer lux_M01oRXyMzqM3tPDtN4ELFNQ50lRLY25a',
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({
        name: customerData.name,
        email: customerData.email,
        phone: customerData.phone
      })
    });

    const result = await response.json();
    
    if (response.ok) {
      console.log('تم تسجيل العميل بنجاح:', result);
      return result;
    } else {
      console.error('خطأ في تسجيل العميل:', result);
      throw new Error(result.message);
    }
  } catch (error) {
    console.error('خطأ في الاتصال:', error);
    throw error;
  }
};

// استخدام الدالة
registerCustomer({
  name: 'أحمد محمد',
  email: 'ahmed@example.com',
  phone: '966500000001'
});
```

**PHP Example**:
```php
function registerCustomer($customerData) {
    $url = 'https://pointsys.clarastars.com/api/v1/customers/register';
    $apiKey = 'lux_M01oRXyMzqM3tPDtN4ELFNQ50lRLY25a';
    
    $data = [
        'name' => $customerData['name'],
        'email' => $customerData['email'],
        'phone' => $customerData['phone']
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json',
        'Accept: application/json'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    $result = json_decode($response, true);
    
    if ($httpCode === 201) {
        return $result;
    } else {
        throw new Exception($result['message'] ?? 'خطأ في تسجيل العميل');
    }
}

// استخدام الدالة
try {
    $customer = registerCustomer([
        'name' => 'أحمد محمد',
        'email' => 'ahmed@example.com',
        'phone' => '966500000001'
    ]);
    echo "تم تسجيل العميل بنجاح. ID: " . $customer['customer']['id'];
} catch (Exception $e) {
    echo "خطأ: " . $e->getMessage();
}
```

### 2. إضافة نقاط للعميل
**الرابط**: `POST /api/v1/customers/points/add`

**الاستخدام**: عند إتمام عملية إيجار سيارة أو أي نشاط يستحق نقاط

**cURL Example**:
```bash
curl -X POST https://pointsys.clarastars.com/api/v1/customers/points/add \
  -H "Authorization: Bearer lux_M01oRXyMzqM3tPDtN4ELFNQ50lRLY25a" \
  -H "Content-Type: application/json" \
  -d '{
    "customer_id": 1,
    "points": 100,
    "description": "إيجار سيارة فاخرة",
    "reference_id": "RENT_12345"
  }'
```

**JavaScript Example**:
```javascript
const addPoints = async (customerId, points, description, referenceId) => {
  try {
    const response = await fetch('https://pointsys.clarastars.com/api/v1/customers/points/add', {
      method: 'POST',
      headers: {
        'Authorization': 'Bearer lux_M01oRXyMzqM3tPDtN4ELFNQ50lRLY25a',
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({
        customer_id: customerId,
        points: points,
        description: description,
        reference_id: referenceId
      })
    });

    const result = await response.json();
    
    if (response.ok) {
      console.log('تم إضافة النقاط بنجاح:', result);
      return result;
    } else {
      console.error('خطأ في إضافة النقاط:', result);
      throw new Error(result.message);
    }
  } catch (error) {
    console.error('خطأ في الاتصال:', error);
    throw error;
  }
};

// استخدام الدالة
addPoints(1, 100, 'إيجار سيارة فاخرة', 'RENT_12345');
```

### 3. استعلام رصيد العميل
**الرابط**: `GET /api/v1/customers/{customerId}/balance`

**الاستخدام**: لعرض رصيد النقاط للعميل

**cURL Example**:
```bash
curl -X GET https://pointsys.clarastars.com/api/v1/customers/1/balance \
  -H "Authorization: Bearer lux_M01oRXyMzqM3tPDtN4ELFNQ50lRLY25a"
```

**JavaScript Example**:
```javascript
const getCustomerBalance = async (customerId) => {
  try {
    const response = await fetch(`https://pointsys.clarastars.com/api/v1/customers/${customerId}/balance`, {
      method: 'GET',
      headers: {
        'Authorization': 'Bearer lux_M01oRXyMzqM3tPDtN4ELFNQ50lRLY25a',
        'Accept': 'application/json'
      }
    });

    const result = await response.json();
    
    if (response.ok) {
      console.log('رصيد العميل:', result);
      return result;
    } else {
      console.error('خطأ في استعلام الرصيد:', result);
      throw new Error(result.message);
    }
  } catch (error) {
    console.error('خطأ في الاتصال:', error);
    throw error;
  }
};

// استخدام الدالة
getCustomerBalance(1);
```

### 4. عرض المكافآت المتاحة
**الرابط**: `GET /api/v1/rewards`

**الاستخدام**: لعرض المكافآت التي يمكن للعميل استبدالها

**cURL Example**:
```bash
curl -X GET https://pointsys.clarastars.com/api/v1/rewards \
  -H "Authorization: Bearer lux_M01oRXyMzqM3tPDtN4ELFNQ50lRLY25a"
```

### 5. استبدال مكافأة
**الرابط**: `POST /api/v1/rewards/redeem`

**الاستخدام**: عندما يريد العميل استبدال نقاطه بمكافأة

**cURL Example**:
```bash
curl -X POST https://pointsys.clarastars.com/api/v1/rewards/redeem \
  -H "Authorization: Bearer lux_M01oRXyMzqM3tPDtN4ELFNQ50lRLY25a" \
  -H "Content-Type: application/json" \
  -d '{
    "customer_id": 1,
    "reward_id": 1
  }'
```

## سيناريوهات الاستخدام

### السيناريو الأول: تسجيل مستخدم جديد
```javascript
// عند تسجيل مستخدم جديد في التطبيق
const newUser = {
  name: 'أحمد محمد',
  email: 'ahmed@example.com',
  phone: '966500000001'
};

// 1. تسجيل المستخدم في قاعدة البيانات المحلية
const localUser = await saveUserToLocalDB(newUser);

// 2. تسجيل المستخدم في نظام النقاط
try {
  const pointsUser = await registerCustomer(newUser);
  
  // 3. حفظ customer_id في قاعدة البيانات المحلية
  await updateUserWithPointsId(localUser.id, pointsUser.customer.id);
  
  console.log('تم تسجيل المستخدم في نظام النقاط بنجاح');
} catch (error) {
  console.error('فشل في تسجيل المستخدم في نظام النقاط:', error);
  // يمكن الاستمرار بدون نظام النقاط
}
```

### السيناريو الثاني: إتمام عملية إيجار
```javascript
// عند إتمام عملية إيجار سيارة
const rental = {
  customerId: 1,
  amount: 500,
  days: 3,
  carType: 'luxury'
};

// حساب النقاط (مثال: 1 ريال = 1 نقطة)
const points = Math.floor(rental.amount);

// إضافة النقاط للعميل
try {
  await addPoints(
    rental.customerId,
    points,
    `إيجار سيارة ${rental.carType} لمدة ${rental.days} أيام`,
    `RENT_${Date.now()}`
  );
  
  console.log(`تم إضافة ${points} نقطة للعميل`);
} catch (error) {
  console.error('فشل في إضافة النقاط:', error);
}
```

### السيناريو الثالث: عرض رصيد النقاط
```javascript
// في صفحة الملف الشخصي
const showCustomerProfile = async (customerId) => {
  try {
    const balance = await getCustomerBalance(customerId);
    
    document.getElementById('points-balance').textContent = balance.points_balance;
    document.getElementById('customer-tier').textContent = balance.tier;
    
  } catch (error) {
    console.error('فشل في جلب رصيد النقاط:', error);
    document.getElementById('points-balance').textContent = 'غير متاح';
  }
};
```

## إعدادات الأمان

### 1. تخزين API Key
```javascript
// في ملف الإعدادات
const API_CONFIG = {
  BASE_URL: 'https://pointsys.clarastars.com/api/v1',
  API_KEY: 'lux_M01oRXyMzqM3tPDtN4ELFNQ50lRLY25a',
  HEADERS: {
    'Authorization': 'Bearer lux_M01oRXyMzqM3tPDtN4ELFNQ50lRLY25a',
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }
};
```

### 2. معالجة الأخطاء
```javascript
const handleApiError = (error, context) => {
  console.error(`خطأ في ${context}:`, error);
  
  if (error.status === 401) {
    console.error('خطأ في API Key');
    // إعادة توجيه لصفحة الإعدادات
  } else if (error.status === 404) {
    console.error('العميل غير موجود');
    // إنشاء العميل
  } else if (error.status === 500) {
    console.error('خطأ في الخادم');
    // إعادة المحاولة لاحقاً
  }
};
```

### 3. Retry Logic
```javascript
const apiCallWithRetry = async (apiFunction, maxRetries = 3) => {
  for (let i = 0; i < maxRetries; i++) {
    try {
      return await apiFunction();
    } catch (error) {
      if (i === maxRetries - 1) {
        throw error;
      }
      
      // انتظار قبل إعادة المحاولة
      await new Promise(resolve => setTimeout(resolve, 1000 * (i + 1)));
    }
  }
};
```

## اختبار الـ API

### 1. اختبار الاتصال
```bash
curl -X GET https://pointsys.clarastars.com/api/v1/rewards \
  -H "Authorization: Bearer lux_M01oRXyMzqM3tPDtN4ELFNQ50lRLY25a"
```

### 2. اختبار تسجيل عميل
```bash
curl -X POST https://pointsys.clarastars.com/api/v1/customers/register \
  -H "Authorization: Bearer lux_M01oRXyMzqM3tPDtN4ELFNQ50lRLY25a" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "عميل تجريبي",
    "email": "test@example.com",
    "phone": "966500000999"
  }'
```

### 3. اختبار إضافة نقاط
```bash
curl -X POST https://pointsys.clarastars.com/api/v1/customers/points/add \
  -H "Authorization: Bearer lux_M01oRXyMzqM3tPDtN4ELFNQ50lRLY25a" \
  -H "Content-Type: application/json" \
  -d '{
    "customer_id": 1,
    "points": 50,
    "description": "اختبار إضافة نقاط",
    "reference_id": "TEST_001"
  }'
```

## ملاحظات مهمة

### 1. الأمان
- لا تشارك API Key مع أي شخص
- استخدم HTTPS دائماً
- تحقق من صحة البيانات قبل الإرسال

### 2. الأداء
- استخدم caching للبيانات الثابتة
- لا تكرر الطلبات غير الضرورية
- استخدم async/await للطلبات المتزامنة

### 3. التوثيق
- سجل جميع الطلبات والأخطاء
- احتفظ بنسخة من البيانات المهمة
- راقب استخدام الـ API

## الدعم
للمساعدة في التكامل:
- راجع ملف `API_DOCUMENTATION.md`
- اختبر الـ API باستخدام cURL
- تحقق من السجلات في حالة وجود أخطاء 
