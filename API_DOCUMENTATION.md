# API Documentation - نظام النقاط

## Base URL
```
https://pointsys.clarastars.com/api/v1
```

## 1. تسجيل عميل جديد
**POST** `/customers/register`

### البيانات المطلوبة:
```json
{
    "name": "اسم العميل",
    "email": "email@example.com",
    "phone": "رقم الهاتف"
}
```

### الاستجابة:
```json
{
    "status": "success",
    "message": "تم تسجيل العميل بنجاح",
    "data": {
        "customer_id": 123,
        "name": "اسم العميل",
        "points_balance": 0,
        "status": "active"
    }
}
```

---

## 2. إضافة نقاط للعميل
**POST** `/customers/points/add`

### البيانات المطلوبة:
```json
{
    "customer_id": 123,
    "points": 100,
    "description": "شراء منتج",
    "reference_id": "ORDER_12345"
}
```

### الاستجابة:
```json
{
    "status": "success",
    "message": "تم إضافة النقاط بنجاح",
    "data": {
        "customer_id": 123,
        "points_added": 100,
        "new_balance": 100,
        "transaction_id": 456
    }
}
```

---

## 3. استعلام رصيد النقاط
**GET** `/customers/{customer_id}/balance`

### الاستجابة:
```json
{
    "status": "success",
    "data": {
        "customer_id": 123,
        "name": "اسم العميل",
        "points_balance": 100,
        "status": "active",
        "total_earned": 150,
        "total_redeemed": 50
    }
}
```

---

## 4. عرض المكافآت المتاحة
**GET** `/rewards`

### الاستجابة:
```json
{
    "status": "success",
    "data": [
        {
            "id": 1,
            "title": "خصم 10%",
            "description": "خصم 10% على المشتريات",
            "points_required": 100,
            "quantity": 50,
            "expires_at": "2025-12-31"
        }
    ]
}
```

---

## 5. استبدال نقاط بمكافأة
**POST** `/rewards/redeem`

### البيانات المطلوبة:
```json
{
    "customer_id": 123,
    "reward_id": 1
}
```

### الاستجابة:
```json
{
    "status": "success",
    "message": "تم استبدال النقاط بنجاح",
    "data": {
        "redemption_id": 789,
        "points_spent": 100,
        "new_balance": 0,
        "reward": {
            "id": 1,
            "title": "خصم 10%",
            "description": "خصم 10% على المشتريات"
        }
    }
}
```

---

## أمثلة استخدام (cURL)

### تسجيل عميل جديد:
```bash
curl -X POST https://pointsys.clarastars.com/api/v1/customers/register \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_API_KEY" \
  -d '{
    "name": "أحمد محمد",
    "email": "ahmed@example.com",
    "phone": "0501234567"
  }'
```

### إضافة نقاط:
```bash
curl -X POST https://pointsys.clarastars.com/api/v1/customers/points/add \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_API_KEY" \
  -d '{
    "customer_id": 1,
    "points": 100,
    "description": "شراء منتج",
    "reference_id": "ORDER_12345"
  }'
```

### استعلام الرصيد:
```bash
curl -X GET https://pointsys.clarastars.com/api/v1/customers/1/balance \
  -H "Authorization: Bearer YOUR_API_KEY"
```

### عرض المكافآت:
```bash
curl -X GET https://pointsys.clarastars.com/api/v1/rewards \
  -H "Authorization: Bearer YOUR_API_KEY"
```

### استبدال مكافأة:
```bash
curl -X POST https://pointsys.clarastars.com/api/v1/rewards/redeem \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_API_KEY" \
  -d '{
    "customer_id": 1,
    "reward_id": 1
  }'
``` 
