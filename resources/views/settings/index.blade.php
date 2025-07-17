@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h4 class="mb-1">الإعدادات</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active">الإعدادات</li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('content')
<!-- Settings Navigation Tabs -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <ul class="nav nav-pills nav-justified" id="settingsTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="general-tab" data-bs-toggle="pill" data-bs-target="#general" type="button" role="tab">
                    <i class="bi bi-gear-fill me-2"></i>
                    الإعدادات العامة
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="notifications-tab" data-bs-toggle="pill" data-bs-target="#notifications" type="button" role="tab">
                    <i class="bi bi-bell-fill me-2"></i>
                    الإشعارات
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="points-tab" data-bs-toggle="pill" data-bs-target="#points" type="button" role="tab">
                    <i class="bi bi-star-fill me-2"></i>
                    نظام النقاط
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="security-tab" data-bs-toggle="pill" data-bs-target="#security" type="button" role="tab">
                    <i class="bi bi-shield-lock-fill me-2"></i>
                    الأمان
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="api-tab" data-bs-toggle="pill" data-bs-target="#api" type="button" role="tab">
                    <i class="bi bi-code-slash me-2"></i>
                    API والتكامل
                </button>
            </li>
        </ul>
    </div>
</div>

<div class="tab-content" id="settingsTabContent">
    <!-- General Settings Tab -->
    <div class="tab-pane fade show active" id="general" role="tabpanel">
        <div class="row g-4">
            <!-- Company Profile -->
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0 py-3">
                        <div class="d-flex align-items-center">

                            <div class="flex-grow-1 me-3">
                                <h5 class="mb-1">معلومات المؤسسة</h5>
                                <p class="text-muted mb-0 small">تحديث المعلومات الأساسية للمؤسسة</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row g-4">
                                <!-- Logo Upload -->
                                <div class="col-12">
                                    <div class="d-flex align-items-center">
                                        <div class="position-relative">
                                            <div class="avatar-preview rounded-3" style="width: 120px; height: 120px;">
                                                <img src="{{ asset('images/logo-placeholder.png') }}" class="rounded-3 w-100 h-100 object-fit-cover" alt="Company Logo">
                                            </div>
                                            <label for="logo-upload" class="btn btn-sm btn-primary position-absolute bottom-0 end-0 m-2">
                                                <i class="bi bi-pencil"></i>
                                            </label>
                                            <input type="file" id="logo-upload" class="d-none">
                                        </div>
                                        <div class="me-4">
                                            <h6 class="mb-1">شعار المؤسسة</h6>
                                            <p class="text-muted mb-0 small">يفضل استخدام صورة بحجم 200×200 بكسل</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Company Information -->
                                <div class="col-md-6">
                                    <label class="form-label">اسم المؤسسة</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-building"></i>
                                        </span>
                                        <input type="text" class="form-control" value="شركة النجاح">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">البريد الإلكتروني</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-envelope"></i>
                                        </span>
                                        <input type="email" class="form-control" value="info@example.com">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">رقم الهاتف</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-phone"></i>
                                        </span>
                                        <input type="tel" class="form-control" value="0512345678">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">الموقع الإلكتروني</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-globe"></i>
                                        </span>
                                        <input type="url" class="form-control" value="https://example.com">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">العنوان</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-geo-alt"></i>
                                        </span>
                                        <textarea class="form-control" rows="2">شارع الملك فهد، الرياض، المملكة العربية السعودية</textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Theme Settings -->
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0 py-3">
                        <div class="d-flex align-items-center">

                            <div class="flex-grow-1 me-3">
                                <h5 class="mb-1">تخصيص المظهر</h5>
                                <p class="text-muted mb-0 small">تخصيص مظهر النظام حسب تفضيلاتك</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label d-block">نمط العرض</label>
                                <div class="btn-group w-100" role="group">
                                    <input type="radio" class="btn-check" name="theme" id="light" checked>
                                    <label class="btn btn-outline-primary" for="light">
                                        <i class="bi bi-sun-fill me-2"></i>
                                        فاتح
                                    </label>

                                    <input type="radio" class="btn-check" name="theme" id="dark">
                                    <label class="btn btn-outline-primary" for="dark">
                                        <i class="bi bi-moon-fill me-2"></i>
                                        داكن
                                    </label>

                                    <input type="radio" class="btn-check" name="theme" id="auto">
                                    <label class="btn btn-outline-primary" for="auto">
                                        <i class="bi bi-circle-half me-2"></i>
                                        تلقائي
                                    </label>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications Tab -->
    <div class="tab-pane fade" id="notifications" role="tabpanel">
        <div class="row g-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0 py-3">
                        <div class="d-flex align-items-center">

                            <div class="flex-grow-1 me-3">
                                <h5 class="mb-1">إعدادات الإشعارات</h5>
                                <p class="text-muted mb-0 small">تخصيص إعدادات الإشعارات والتنبيهات</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="vstack gap-4">
                            <!-- Notification Methods -->
                            <div>
                                <h6 class="mb-3">طريقة الإشعار</h6>
                                <div class="d-flex gap-4 flex-wrap">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="emailNotif" checked>
                                        <label class="form-check-label" for="emailNotif">
                                            <i class="bi bi-envelope-fill me-2 text-muted"></i>
                                            البريد الإلكتروني
                                        </label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="smsNotif" checked>
                                        <label class="form-check-label" for="smsNotif">
                                            <i class="bi bi-chat-fill me-2 text-muted"></i>
                                            رسائل SMS
                                        </label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="pushNotif">
                                        <label class="form-check-label" for="pushNotif">
                                            <i class="bi bi-app-indicator-fill me-2 text-muted"></i>
                                            إشعارات الموقع
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Notification Types -->
                            <div>
                                <h6 class="mb-3">نوع الإشعارات</h6>
                                <div class="vstack gap-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-0">عميل جديد</p>
                                            <small class="text-muted">إشعار عند تسجيل عميل جديد</small>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="newCustomer" checked>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-0">مكافأة جديدة</p>
                                            <small class="text-muted">إشعار عند إضافة مكافأة جديدة</small>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="newReward" checked>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-0">تحديث النقاط</p>
                                            <small class="text-muted">إشعار عند تحديث نقاط العملاء</small>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="pointsUpdate" checked>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-0">طلب استبدال مكافأة</p>
                                            <small class="text-muted">إشعار عند طلب استبدال مكافأة</small>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="rewardClaim">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Points System Tab -->
    <div class="tab-pane fade" id="points" role="tabpanel">
        <div class="row g-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0 py-3">
                        <div class="d-flex align-items-center">

                            <div class="flex-grow-1 me-3">
                                <h5 class="mb-1">نظام النقاط</h5>
                                <p class="text-muted mb-0 small">تخصيص إعدادات نظام النقاط والمكافآت</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <!-- Points Rate -->
                            <div class="col-md-6">
                                <label class="form-label">معدل النقاط</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" value="1">
                                    <span class="input-group-text bg-light">نقطة لكل ريال</span>
                                </div>
                            </div>

                            <!-- Minimum Points -->
                            <div class="col-md-6">
                                <label class="form-label">الحد الأدنى للنقاط</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" value="100">
                                    <span class="input-group-text bg-light">نقطة</span>
                                </div>
                            </div>

                            <!-- Membership Levels -->
                            <div class="col-12">
                                <label class="form-label">مستويات العضوية</label>
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>المستوى</th>
                                                <th>النقاط المطلوبة</th>
                                                <th>نسبة المكافأة</th>
                                                <th>المميزات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-circle-fill text-secondary me-2"></i>
                                                        عادي
                                                    </div>
                                                </td>
                                                <td>0</td>
                                                <td>1%</td>
                                                <td>المميزات الأساسية</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-circle-fill text-primary me-2"></i>
                                                        فضي
                                                    </div>
                                                </td>
                                                <td>1000</td>
                                                <td>2%</td>
                                                <td>خصم إضافي 5%</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-circle-fill text-warning me-2"></i>
                                                        ذهبي
                                                    </div>
                                                </td>
                                                <td>5000</td>
                                                <td>3%</td>
                                                <td>خصم إضافي 10% + خدمة VIP</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Security Tab -->
    <div class="tab-pane fade" id="security" role="tabpanel">
        <div class="row g-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0 py-3">
                        <div class="d-flex align-items-center">

                            <div class="flex-grow-1 me-3">
                                <h5 class="mb-1">إعدادات الأمان</h5>
                                <p class="text-muted mb-0 small">تحديث إعدادات الأمان والخصوصية</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="vstack gap-4">
                            <!-- Password Change -->
                            <div>
                                <h6 class="mb-3">تغيير كلمة المرور</h6>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="bi bi-key"></i>
                                            </span>
                                            <input type="password" class="form-control" placeholder="كلمة المرور الحالية">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="bi bi-lock"></i>
                                            </span>
                                            <input type="password" class="form-control" placeholder="كلمة المرور الجديدة">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="bi bi-lock-fill"></i>
                                            </span>
                                            <input type="password" class="form-control" placeholder="تأكيد كلمة المرور">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Two-Factor Authentication -->
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-1">المصادقة الثنائية</h6>
                                        <p class="text-muted mb-0 small">تأمين حسابك بخطوة إضافية</p>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="twoFactor">
                                    </div>
                                </div>
                                <div class="alert alert-info d-flex align-items-center" role="alert">
                                    <i class="bi bi-info-circle-fill me-2"></i>
                                    <div>
                                        المصادقة الثنائية تضيف طبقة حماية إضافية لحسابك
                                    </div>
                                </div>
                            </div>

                            <!-- Session Management -->
                            <div>
                                <h6 class="mb-3">إدارة الجلسات</h6>
                                <div class="list-group">
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1">Chrome - Windows</h6>
                                                <small class="text-muted">الرياض، المملكة العربية السعودية</small>
                                            </div>
                                            <span class="badge bg-success">نشط الآن</span>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1">Safari - iPhone</h6>
                                                <small class="text-muted">آخر نشاط: منذ 2 ساعة</small>
                                            </div>
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-x-lg"></i>
                                                إنهاء
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- API Integration Tab -->
    <div class="tab-pane fade" id="api" role="tabpanel">
        <div class="row g-4">
            <!-- API Keys -->
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0 py-3">
                        <div class="d-flex align-items-center">

                            <div class="flex-grow-1 me-3">
                                <h5 class="mb-1">مفاتيح API</h5>
                                <p class="text-muted mb-0 small">إدارة مفاتيح API للوصول إلى النظام</p>
                            </div>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newApiKeyModal">
                                <i class="bi bi-plus-lg me-2"></i>
                                إنشاء مفتاح جديد
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="vstack gap-4">
                            <!-- Live API Key -->
                            <div>
                                <label class="form-label">مفتاح API للإنتاج</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="sk_live_***********************" readonly>
                                    <button class="btn btn-outline-primary" type="button">
                                        <i class="bi bi-clipboard me-2"></i>
                                        نسخ
                                    </button>
                                    <button class="btn btn-outline-danger" type="button">
                                        <i class="bi bi-arrow-repeat me-2"></i>
                                        إعادة توليد
                                    </button>
                                </div>
                                <small class="text-danger">* لا تشارك هذا المفتاح مع أي شخص</small>
                            </div>

                            <!-- Test API Key -->
                            <div>
                                <label class="form-label">مفتاح API للتجربة</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="sk_test_***********************" readonly>
                                    <button class="btn btn-outline-primary" type="button">
                                        <i class="bi bi-clipboard me-2"></i>
                                        نسخ
                                    </button>
                                    <button class="btn btn-outline-danger" type="button">
                                        <i class="bi bi-arrow-repeat me-2"></i>
                                        إعادة توليد
                                    </button>
                                </div>
                                <small class="text-muted">استخدم هذا المفتاح للتجربة والاختبار</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- API Documentation -->
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0 py-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="mb-1">الدليل الإرشادي للتكامل</h5>
                                <p class="text-muted mb-0 small">دليل شامل لربط نظامك مع واجهة برمجة التطبيقات</p>
                            </div>
                            <a href="{{ route('settings.api.docs.download') }}" class="btn btn-primary">
                                <i class="bi bi-download me-2"></i>
                                تحميل الدليل الإرشادي
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <!-- Integration Steps -->


                            <!-- What's in the Guide -->

                        </div>
                    </div>
                </div>
            </div>

            <!-- Webhooks -->
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0 py-3">
                        <div class="d-flex align-items-center">

                            <div class="flex-grow-1 me-3">
                                <h5 class="mb-1">Webhooks</h5>
                                <p class="text-muted mb-0 small">إعداد إشعارات تلقائية للأحداث</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label">رابط Webhook</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-link-45deg"></i>
                                    </span>
                                    <input type="url" class="form-control" placeholder="https://your-app.com/webhook">
                                </div>
                                <small class="text-muted">سنرسل إشعارات لهذا الرابط عند حدوث أي تغييرات</small>
                            </div>

                            <div class="col-12">
                                <label class="form-label">أحداث Webhook</label>
                                <div class="vstack gap-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-0">إضافة نقاط</p>
                                            <small class="text-muted">عند إضافة نقاط لأي عميل</small>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" checked>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-0">استبدال مكافأة</p>
                                            <small class="text-muted">عند استبدال أي مكافأة</small>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" checked>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-0">تسجيل عميل جديد</p>
                                            <small class="text-muted">عند إضافة عميل جديد</small>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Floating Save Button -->
<div class="position-fixed bottom-0 start-50 translate-middle-x mb-4" style="z-index: 1000;">
    <button class="btn btn-primary btn-lg shadow-lg px-4">
        <i class="bi bi-save me-2"></i>
        حفظ التغييرات
    </button>
</div>

<style>
/* Custom Styles */
.card {
    transition: all 0.3s ease;
    border-radius: 1rem;
}

.card:hover {
    transform: translateY(-2px);
}

.nav-pills .nav-link {
    color: var(--bs-gray-700);
    padding: 1rem;
    border-radius: 0.75rem;
    transition: all 0.3s ease;
}

.nav-pills .nav-link:hover {
    background-color: var(--bs-gray-100);
}

.nav-pills .nav-link.active {
    background-color: var(--bs-primary);
    color: white;
}

.form-check-input:checked {
    background-color: var(--bs-primary);
    border-color: var(--bs-primary);
}

.input-group-text {
    border: none;
}

.form-control {
    border-radius: 0.5rem;
}

.input-group > .form-control {
    border-start-start-radius: 0.5rem;
    border-end-start-radius: 0.5rem;
}

.input-group > .input-group-text {
    border-start-end-radius: 0.5rem;
    border-end-end-radius: 0.5rem;
}

.avatar-preview {
    overflow: hidden;
    position: relative;
}

.avatar-preview img {
    object-fit: cover;
}

.btn-group {
    border-radius: 0.5rem;
    overflow: hidden;
}

.btn-group .btn {
    border: 1px solid var(--bs-primary);
}

.table {
    vertical-align: middle;
}

.alert {
    border-radius: 0.5rem;
}

.list-group-item {
    border-radius: 0.5rem !important;
    margin-bottom: 0.5rem;
    border: 1px solid var(--bs-gray-200);
}

.badge {
    padding: 0.5em 1em;
    border-radius: 2rem;
}

/* RTL Specific Adjustments */
.me-2 {
    margin-left: 0.5rem !important;
    margin-right: 0 !important;
}

.me-3 {
    margin-left: 1rem !important;
    margin-right: 0 !important;
}

.ms-3 {
    margin-right: 1rem !important;
    margin-left: 0 !important;
}

.bg-purple {
    background-color: #6f42c1;
}

.text-purple {
    color: #6f42c1;
}

pre {
    margin-bottom: 0;
}

pre code {
    white-space: pre-wrap;
}

.badge {
    font-size: 0.75rem;
    padding: 0.35em 0.65em;
}
</style>

@endsection
