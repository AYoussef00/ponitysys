@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h4 class="mb-0">إحصائيات API</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active">إحصائيات API</li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('content')
<div class="row g-4">
    <!-- إحصائيات عامة -->
    <div class="col-12">
        <div class="row g-3">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="mb-0">{{ $totalApiKeys }}</h3>
                                <p class="mb-0">إجمالي المفاتيح</p>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-key fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="mb-0">{{ $activeApiKeys }}</h3>
                                <p class="mb-0">المفاتيح النشطة</p>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-check-circle fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="mb-0">{{ $testApiKeys }}</h3>
                                <p class="mb-0">مفاتيح تجريبية</p>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-flask fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="mb-0">{{ $liveApiKeys }}</h3>
                                <p class="mb-0">مفاتيح إنتاج</p>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-rocket fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- استخدام API -->
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-transparent">
                <h5 class="mb-0">استخدام API</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded">
                            <h4 class="text-primary mb-1">{{ $recentApiUsage['today'] }}</h4>
                            <p class="text-muted mb-0">اليوم</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded">
                            <h4 class="text-success mb-1">{{ $recentApiUsage['week'] }}</h4>
                            <p class="text-muted mb-0">هذا الأسبوع</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded">
                            <h4 class="text-info mb-1">{{ $recentApiUsage['month'] }}</h4>
                            <p class="text-muted mb-0">هذا الشهر</p>
                        </div>
                    </div>
                </div>

                <!-- رسم بياني بسيط -->
                <div class="mt-4">
                    <h6>نشاط API خلال الأسبوع</h6>
                    <div class="d-flex align-items-end" style="height: 200px;">
                        <div class="flex-fill d-flex flex-column align-items-center">
                            <div class="bg-primary rounded-top" style="width: 30px; height: 60px;"></div>
                            <small class="mt-2">الأحد</small>
                        </div>
                        <div class="flex-fill d-flex flex-column align-items-center">
                            <div class="bg-primary rounded-top" style="width: 30px; height: 80px;"></div>
                            <small class="mt-2">الاثنين</small>
                        </div>
                        <div class="flex-fill d-flex flex-column align-items-center">
                            <div class="bg-primary rounded-top" style="width: 30px; height: 100px;"></div>
                            <small class="mt-2">الثلاثاء</small>
                        </div>
                        <div class="flex-fill d-flex flex-column align-items-center">
                            <div class="bg-primary rounded-top" style="width: 30px; height: 120px;"></div>
                            <small class="mt-2">الأربعاء</small>
                        </div>
                        <div class="flex-fill d-flex flex-column align-items-center">
                            <div class="bg-primary rounded-top" style="width: 30px; height: 90px;"></div>
                            <small class="mt-2">الخميس</small>
                        </div>
                        <div class="flex-fill d-flex flex-column align-items-center">
                            <div class="bg-primary rounded-top" style="width: 30px; height: 70px;"></div>
                            <small class="mt-2">الجمعة</small>
                        </div>
                        <div class="flex-fill d-flex flex-column align-items-center">
                            <div class="bg-primary rounded-top" style="width: 30px; height: 50px;"></div>
                            <small class="mt-2">السبت</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- أكثر الـ APIs استخداماً -->
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-transparent">
                <h5 class="mb-0">أكثر الـ APIs استخداماً</h5>
            </div>
            <div class="card-body">
                @foreach($topApis as $api)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="mb-1">{{ $api['name'] }}</h6>
                        <small class="text-muted">{{ $api['calls'] }} استدعاء</small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-primary">{{ $api['percentage'] }}%</span>
                    </div>
                </div>
                <div class="progress mb-3" style="height: 6px;">
                    <div class="progress-bar" style="width: {{ $api['percentage'] }}%"></div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- سجل النشاط -->
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-transparent">
                <h5 class="mb-0">سجل نشاط API</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>الوقت</th>
                                <th>الـ API</th>
                                <th>المفتاح</th>
                                <th>الحالة</th>
                                <th>الاستجابة</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>منذ 5 دقائق</td>
                                <td>تسجيل عميل جديد</td>
                                <td><code>sk_test_****</code></td>
                                <td><span class="badge bg-success">نجح</span></td>
                                <td>200 OK</td>
                            </tr>
                            <tr>
                                <td>منذ 10 دقائق</td>
                                <td>إضافة نقاط</td>
                                <td><code>sk_live_****</code></td>
                                <td><span class="badge bg-success">نجح</span></td>
                                <td>200 OK</td>
                            </tr>
                            <tr>
                                <td>منذ 15 دقيقة</td>
                                <td>استعلام الرصيد</td>
                                <td><code>sk_test_****</code></td>
                                <td><span class="badge bg-warning">تحذير</span></td>
                                <td>404 Not Found</td>
                            </tr>
                            <tr>
                                <td>منذ 30 دقيقة</td>
                                <td>عرض المكافآت</td>
                                <td><code>sk_live_****</code></td>
                                <td><span class="badge bg-success">نجح</span></td>
                                <td>200 OK</td>
                            </tr>
                            <tr>
                                <td>منذ ساعة</td>
                                <td>استبدال مكافأة</td>
                                <td><code>sk_test_****</code></td>
                                <td><span class="badge bg-danger">فشل</span></td>
                                <td>400 Bad Request</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
