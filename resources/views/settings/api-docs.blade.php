@extends('layouts.app')

@section('content')
<div class="container-fluid" dir="rtl">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">دليل استخدام API</h5>
                </div>
                <div class="card-body">
                    <!-- التبويبات -->
                    <ul class="nav nav-tabs" id="apiTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview" role="tab">
                                نظرة عامة
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="authentication-tab" data-toggle="tab" href="#authentication" role="tab">
                                المصادقة
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="customers-tab" data-toggle="tab" href="#customers" role="tab">
                                إدارة العملاء
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="points-tab" data-toggle="tab" href="#points" role="tab">
                                إدارة النقاط
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="rewards-tab" data-toggle="tab" href="#rewards" role="tab">
                                المكافآت
                            </a>
                        </li>
                    </ul>

                    <!-- محتوى التبويبات -->
                    <div class="tab-content mt-3" id="apiTabsContent">
                        <!-- قسم نظرة عامة -->
                        <div class="tab-pane fade show active" id="overview" role="tabpanel">
                            <div class="api-section">
                                <h6 class="font-weight-bold mb-4">تصميم النظام</h6>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card mb-4">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0">١. تسجيل العميل</h6>
                                            </div>
                                            <div class="card-body">
                                                <ol class="pr-3">
                                                    <li>العميل يقوم بالتسجيل في تطبيق الشركة</li>
                                                    <li>التطبيق يرسل بيانات العميل عبر API</li>
                                                    <li>يتم إنشاء حساب للعميل مع رصيد نقاط صفر</li>
                                                    <li>يتم إرسال webhook للشركة لتأكيد التسجيل</li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card mb-4">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0">٢. إضافة النقاط</h6>
                                            </div>
                                            <div class="card-body">
                                                <ol class="pr-3">
                                                    <li>العميل يقوم بعملية شراء في متجر الشركة</li>
                                                    <li>نظام الشركة يرسل تفاصيل العملية عبر API</li>
                                                    <li>يتم إضافة النقاط لحساب العميل</li>
                                                    <li>يتم إرسال webhook بتحديث الرصيد</li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card mb-4">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0">٣. استبدال النقاط</h6>
                                            </div>
                                            <div class="card-body">
                                                <ol class="pr-3">
                                                    <li>العميل يختار مكافأة للاستبدال</li>
                                                    <li>التطبيق يرسل طلب الاستبدال عبر API</li>
                                                    <li>يتم التحقق من رصيد النقاط وخصمها</li>
                                                    <li>يتم إرسال webhook بتفاصيل الاستبدال</li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card mb-4">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0">٤. المزامنة والتحديثات</h6>
                                            </div>
                                            <div class="card-body">
                                                <ol class="pr-3">
                                                    <li>يمكن الاستعلام عن رصيد النقاط في أي وقت</li>
                                                    <li>يتم إرسال webhooks فورية لكل العمليات</li>
                                                    <li>دعم للبيئة التجريبية والإنتاج</li>
                                                    <li>تتبع كامل لسجل العمليات والتغييرات</li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-info mt-4">
                                    <h6 class="font-weight-bold">ملاحظات هامة:</h6>
                                    <ul class="mb-0 pr-3">
                                        <li>جميع الطلبات تحتاج إلى مفتاح API صالح</li>
                                        <li>يجب استخدام HTTPS لجميع الطلبات</li>
                                        <li>يتم دعم النسخة الأولى من API (v1)</li>
                                        <li>جميع التواريخ بتنسيق UTC</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- قسم المصادقة -->
                        <div class="tab-pane fade" id="authentication" role="tabpanel">
                            <div class="api-section">
                                <h6 class="font-weight-bold">المصادقة</h6>
                                <p>لاستخدام الـ API، يجب إرسال مفتاح API في ترويسة الطلب:</p>
                                <div class="bg-light p-3 rounded">
                                    <code>Authorization: Bearer YOUR_API_KEY</code>
                                </div>
                            </div>
                        </div>

                        <!-- قسم إدارة العملاء -->
                        <div class="tab-pane fade" id="customers" role="tabpanel">
                            <div class="api-section">
                                <h6 class="font-weight-bold">تسجيل عميل جديد</h6>
                                <div class="endpoint">
                                    <span class="badge badge-success">POST</span>
                                    <code>/api/v1/customers/register</code>
                                </div>
                                <p>المعلمات المطلوبة:</p>
                                <pre class="bg-light p-3 rounded">
{
    "name": "اسم العميل",
    "phone": "رقم الهاتف",
    "email": "البريد الإلكتروني"
}</pre>
                            </div>
                        </div>

                        <!-- قسم إدارة النقاط -->
                        <div class="tab-pane fade" id="points" role="tabpanel">
                            <div class="api-section mb-4">
                                <h6 class="font-weight-bold">إضافة نقاط</h6>
                                <div class="endpoint">
                                    <span class="badge badge-success">POST</span>
                                    <code>/api/v1/customers/points/add</code>
                                </div>
                                <p>المعلمات المطلوبة:</p>
                                <pre class="bg-light p-3 rounded">
{
    "customer_id": "رقم العميل",
    "points": "عدد النقاط",
    "description": "وصف العملية",
    "reference_id": "رقم مرجعي للعملية"
}</pre>
                            </div>

                            <div class="api-section">
                                <h6 class="font-weight-bold">الاستعلام عن الرصيد</h6>
                                <div class="endpoint">
                                    <span class="badge badge-primary">GET</span>
                                    <code>/api/v1/customers/{customer_id}/balance</code>
                                </div>
                            </div>
                        </div>

                        <!-- قسم المكافآت -->
                        <div class="tab-pane fade" id="rewards" role="tabpanel">
                            <div class="api-section">
                                <h6 class="font-weight-bold">استبدال النقاط بمكافأة</h6>
                                <div class="endpoint">
                                    <span class="badge badge-success">POST</span>
                                    <code>/api/v1/customers/points/redeem</code>
                                </div>
                                <p>المعلمات المطلوبة:</p>
                                <pre class="bg-light p-3 rounded">
{
    "customer_id": "رقم العميل",
    "reward_id": "رقم المكافأة"
}</pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.endpoint {
    margin: 15px 0;
    padding: 10px;
    background-color: #f8f9fa;
    border-radius: 5px;
}

.endpoint .badge {
    margin-left: 10px;
}

.api-section {
    margin-bottom: 30px;
}

pre {
    direction: ltr;
    text-align: left;
}

code {
    direction: ltr;
    display: inline-block;
}

.card-header {
    background-color: rgba(0, 0, 0, 0.03);
}

.alert ul {
    list-style-type: none;
}

.alert ul li:before {
    content: "•";
    margin-left: 8px;
    color: #17a2b8;
}
</style>
@endsection
