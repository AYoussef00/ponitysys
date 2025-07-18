@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h4 class="mb-0">دليل API</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('settings.index') }}">الإعدادات</a></li>
                <li class="breadcrumb-item active">دليل API</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('settings.api.docs.download') }}" class="btn btn-primary">
            <i class="bi bi-download me-2"></i>
            تحميل PDF
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="row g-4">
    <!-- القائمة الجانبية -->
    <div class="col-md-3">
        <div class="card shadow-sm sticky-top" style="top: 20px;">
            <div class="card-header bg-transparent">
                <h6 class="mb-0">محتويات الدليل</h6>
            </div>
            <div class="list-group list-group-flush">
                <a href="#introduction" class="list-group-item list-group-item-action">مقدمة</a>
                <a href="#authentication" class="list-group-item list-group-item-action">المصادقة</a>
                <a href="#endpoints" class="list-group-item list-group-item-action">النقاط النهائية</a>
                <a href="#customers" class="list-group-item list-group-item-action">إدارة العملاء</a>
                <a href="#points" class="list-group-item list-group-item-action">إدارة النقاط</a>
                <a href="#rewards" class="list-group-item list-group-item-action">المكافآت</a>
                <a href="#redemptions" class="list-group-item list-group-item-action">الاستبدالات</a>
                <a href="#webhooks" class="list-group-item list-group-item-action">Webhooks</a>
                <a href="#errors" class="list-group-item list-group-item-action">رموز الخطأ</a>
            </div>
        </div>
    </div>

    <!-- المحتوى الرئيسي -->
    <div class="col-md-9">
        <!-- مقدمة -->
        <div class="card shadow-sm mb-4" id="introduction">
            <div class="card-header bg-transparent">
                <h5 class="mb-0">مقدمة</h5>
            </div>
            <div class="card-body">
                <p>مرحباً بك في دليل API لنظام إدارة الولاء. يوفر هذا الدليل معلومات شاملة حول كيفية استخدام واجهة برمجة التطبيقات لدمج نظام الولاء مع تطبيقاتك.</p>

                <div class="alert alert-info">
                    <h6>المعلومات الأساسية:</h6>
                    <ul class="mb-0">
                        <li><strong>Base URL:</strong> <code>https://pointsys.clarastars.com/api/v1</code></li>
                        <li><strong>Content-Type:</strong> <code>application/json</code></li>
                        <li><strong>الاستجابة:</strong> جميع الاستجابات بصيغة JSON</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- المصادقة -->
        <div class="card shadow-sm mb-4" id="authentication">
            <div class="card-header bg-transparent">
                <h5 class="mb-0">المصادقة</h5>
            </div>
            <div class="card-body">
                <p>يستخدم النظام مصادقة API Key. يجب تضمين مفتاح API في رأس الطلب.</p>

                <div class="mb-3">
                    <h6>طريقة الاستخدام:</h6>
                    <pre><code>Authorization: Bearer YOUR_API_KEY</code></pre>
                </div>

                <div class="mb-3">
                    <h6>مثال cURL:</h6>
                    <pre><code>curl -H "Authorization: Bearer sk_test_1234567890abcdef" \
     -H "Content-Type: application/json" \
     https://pointsys.clarastars.com/api/v1/customers</code></pre>
                </div>

                <div class="alert alert-warning">
                    <strong>ملاحظة:</strong> احتفظ بمفتاح API آمناً ولا تشاركه مع أي شخص.
                </div>
            </div>
        </div>

        <!-- النقاط النهائية -->
        <div class="card shadow-sm mb-4" id="endpoints">
            <div class="card-header bg-transparent">
                <h5 class="mb-0">النقاط النهائية المتاحة</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>الطريقة</th>
                                <th>المسار</th>
                                <th>الوصف</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="badge bg-success">POST</span></td>
                                <td><code>/customers/register</code></td>
                                <td>تسجيل عميل جديد</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-primary">GET</span></td>
                                <td><code>/customers/{id}/balance</code></td>
                                <td>استعلام رصيد النقاط</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-success">POST</span></td>
                                <td><code>/customers/points/add</code></td>
                                <td>إضافة نقاط للعميل</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-primary">GET</span></td>
                                <td><code>/rewards</code></td>
                                <td>عرض المكافآت المتاحة</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-success">POST</span></td>
                                <td><code>/rewards/redeem</code></td>
                                <td>استبدال مكافأة</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- إدارة العملاء -->
        <div class="card shadow-sm mb-4" id="customers">
            <div class="card-header bg-transparent">
                <h5 class="mb-0">إدارة العملاء</h5>
            </div>
            <div class="card-body">
                <h6>تسجيل عميل جديد</h6>
                <div class="mb-3">
                    <strong>POST /api/v1/customers/register</strong>
                </div>

                <div class="mb-3">
                    <h6>المعاملات المطلوبة:</h6>
                    <pre><code>{
    "name": "أحمد محمد",
    "email": "ahmed@example.com",
    "phone": "0501234567"
}</code></pre>
                </div>

                <div class="mb-3">
                    <h6>مثال cURL:</h6>
                    <pre><code>curl -X POST "https://pointsys.clarastars.com/api/v1/customers/register" \
     -H "Authorization: Bearer YOUR_API_KEY" \
     -H "Content-Type: application/json" \
     -d '{
         "name": "أحمد محمد",
         "email": "ahmed@example.com",
         "phone": "0501234567"
     }'</code></pre>
                </div>

                <div class="mb-3">
                    <h6>الاستجابة المتوقعة:</h6>
                    <pre><code>{
    "status": "success",
    "message": "تم تسجيل العميل بنجاح",
    "data": {
        "customer_id": 1,
        "name": "أحمد محمد",
        "email": "ahmed@example.com",
        "phone": "0501234567",
        "points_balance": 0
    }
}</code></pre>
                </div>

                <hr>

                <h6>استعلام رصيد النقاط</h6>
                <div class="mb-3">
                    <strong>GET /api/v1/customers/{id}/balance</strong>
                </div>

                <div class="mb-3">
                    <h6>مثال cURL:</h6>
                    <pre><code>curl -X GET "https://pointsys.clarastars.com/api/v1/customers/1/balance" \
     -H "Authorization: Bearer YOUR_API_KEY"</code></pre>
                </div>

                <div class="mb-3">
                    <h6>الاستجابة المتوقعة:</h6>
                    <pre><code>{
    "status": "success",
    "data": {
        "customer_id": 1,
        "name": "أحمد محمد",
        "points_balance": 150,
        "total_earned": 300,
        "total_redeemed": 150
    }
}</code></pre>
                </div>
            </div>
        </div>

        <!-- إدارة النقاط -->
        <div class="card shadow-sm mb-4" id="points">
            <div class="card-header bg-transparent">
                <h5 class="mb-0">إدارة النقاط</h5>
            </div>
            <div class="card-body">
                <h6>إضافة نقاط للعميل</h6>
                <div class="mb-3">
                    <strong>POST /api/v1/customers/points/add</strong>
                </div>

                <div class="mb-3">
                    <h6>المعاملات المطلوبة:</h6>
                    <pre><code>{
    "customer_id": 1,
    "points": 100,
    "description": "شراء منتج",
    "reference_id": "ORDER_12345"
}</code></pre>
                </div>

                <div class="mb-3">
                    <h6>مثال cURL:</h6>
                    <pre><code>curl -X POST "https://pointsys.clarastars.com/api/v1/customers/points/add" \
     -H "Authorization: Bearer YOUR_API_KEY" \
     -H "Content-Type: application/json" \
     -d '{
         "customer_id": 1,
         "points": 100,
         "description": "شراء منتج",
         "reference_id": "ORDER_12345"
     }'</code></pre>
                </div>

                <div class="mb-3">
                    <h6>الاستجابة المتوقعة:</h6>
                    <pre><code>{
    "status": "success",
    "message": "تم إضافة النقاط بنجاح",
    "data": {
        "transaction_id": 123,
        "customer_id": 1,
        "points_added": 100,
        "new_balance": 250,
        "description": "شراء منتج",
        "reference_id": "ORDER_12345"
    }
}</code></pre>
                </div>
            </div>
        </div>

        <!-- المكافآت -->
        <div class="card shadow-sm mb-4" id="rewards">
            <div class="card-header bg-transparent">
                <h5 class="mb-0">المكافآت</h5>
            </div>
            <div class="card-body">
                <h6>عرض المكافآت المتاحة</h6>
                <div class="mb-3">
                    <strong>GET /api/v1/rewards</strong>
                </div>

                <div class="mb-3">
                    <h6>مثال cURL:</h6>
                    <pre><code>curl -X GET "https://pointsys.clarastars.com/api/v1/rewards" \
     -H "Authorization: Bearer YOUR_API_KEY"</code></pre>
                </div>

                <div class="mb-3">
                    <h6>الاستجابة المتوقعة:</h6>
                    <pre><code>{
    "status": "success",
    "data": [
        {
            "id": 1,
            "title": "خصم 10%",
            "description": "خصم 10% على المشتريات",
            "points_required": 100,
            "type": "discount",
            "value": 10,
            "status": "active"
        },
        {
            "id": 2,
            "title": "هدية مجانية",
            "description": "هدية مجانية مع الطلب",
            "points_required": 200,
            "type": "gift",
            "value": null,
            "status": "active"
        }
    ]
}</code></pre>
                </div>

                <hr>

                <h6>استبدال مكافأة</h6>
                <div class="mb-3">
                    <strong>POST /api/v1/rewards/redeem</strong>
                </div>

                <div class="mb-3">
                    <h6>المعاملات المطلوبة:</h6>
                    <pre><code>{
    "customer_id": 1,
    "reward_id": 1
}</code></pre>
                </div>

                <div class="mb-3">
                    <h6>مثال cURL:</h6>
                    <pre><code>curl -X POST "https://pointsys.clarastars.com/api/v1/rewards/redeem" \
     -H "Authorization: Bearer YOUR_API_KEY" \
     -H "Content-Type: application/json" \
     -d '{
         "customer_id": 1,
         "reward_id": 1
     }'</code></pre>
                </div>

                <div class="mb-3">
                    <h6>الاستجابة المتوقعة:</h6>
                    <pre><code>{
    "status": "success",
    "message": "تم استبدال المكافأة بنجاح",
    "data": {
        "redemption_id": 456,
        "customer_id": 1,
        "reward_id": 1,
        "reward_title": "خصم 10%",
        "points_used": 100,
        "remaining_balance": 150
    }
}</code></pre>
                </div>
            </div>
        </div>

        <!-- Webhooks -->
        <div class="card shadow-sm mb-4" id="webhooks">
            <div class="card-header bg-transparent">
                <h5 class="mb-0">Webhooks</h5>
            </div>
            <div class="card-body">
                <p>يمكنك إعداد Webhooks لتلقي إشعارات فورية عند حدوث أحداث معينة في النظام.</p>

                <h6>الأحداث المتاحة:</h6>
                <ul>
                    <li><code>customer.created</code> - عند تسجيل عميل جديد</li>
                    <li><code>points.added</code> - عند إضافة نقاط</li>
                    <li><code>reward.redeemed</code> - عند استبدال مكافأة</li>
                </ul>

                <div class="mb-3">
                    <h6>مثال على طلب Webhook:</h6>
                    <pre><code>POST https://your-webhook-url.com/webhook
Content-Type: application/json

{
    "event": "customer.created",
    "timestamp": "2024-01-15T10:30:00Z",
    "data": {
        "customer_id": 1,
        "name": "أحمد محمد",
        "email": "ahmed@example.com"
    }
}</code></pre>
                </div>

                <div class="alert alert-info">
                    <strong>ملاحظة:</strong> يجب أن يستجيب Webhook URL برمز 200 OK لتأكيد استلام الإشعار.
                </div>
            </div>
        </div>

        <!-- رموز الخطأ -->
        <div class="card shadow-sm mb-4" id="errors">
            <div class="card-header bg-transparent">
                <h5 class="mb-0">رموز الخطأ</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>رمز الحالة</th>
                                <th>الوصف</th>
                                <th>الحل</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="badge bg-danger">400</span></td>
                                <td>طلب غير صحيح</td>
                                <td>تحقق من صحة البيانات المرسلة</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-danger">401</span></td>
                                <td>غير مصرح</td>
                                <td>تحقق من صحة مفتاح API</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-danger">403</span></td>
                                <td>محظور</td>
                                <td>ليس لديك صلاحية للوصول لهذا المورد</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-danger">404</span></td>
                                <td>غير موجود</td>
                                <td>المورد المطلوب غير موجود</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-danger">422</span></td>
                                <td>بيانات غير صالحة</td>
                                <td>تحقق من صحة البيانات المرسلة</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-danger">500</span></td>
                                <td>خطأ في الخادم</td>
                                <td>تواصل مع الدعم الفني</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mb-3">
                    <h6>مثال على استجابة خطأ:</h6>
                    <pre><code>{
    "status": "error",
    "message": "بيانات غير صالحة",
    "errors": {
        "email": ["البريد الإلكتروني مطلوب"],
        "phone": ["رقم الهاتف غير صحيح"]
    }
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
pre {
    background-color: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 0.375rem;
    padding: 1rem;
    margin-bottom: 1rem;
}

code {
    background-color: #f8f9fa;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
    font-size: 0.875em;
}

.sticky-top {
    z-index: 1020;
}
</style>

<script>
// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Highlight active section in sidebar
window.addEventListener('scroll', function() {
    const sections = document.querySelectorAll('[id]');
    const navLinks = document.querySelectorAll('.list-group-item');

    let current = '';
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        if (pageYOffset >= sectionTop - 100) {
            current = section.getAttribute('id');
        }
    });

    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === '#' + current) {
            link.classList.add('active');
        }
    });
});
</script>
@endsection
