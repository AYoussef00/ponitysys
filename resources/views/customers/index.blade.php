@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h4 class="mb-1">العملاء</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active">العملاء</li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('content')
<!-- Action Bar -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="row g-4 align-items-center">
            <div class="col-12 col-lg-6">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control border-start-0 ps-0" placeholder="بحث عن عميل...">
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="d-flex gap-2 justify-content-lg-end">
                    <button class="btn btn-light" type="button">
                        <i class="bi bi-sort-down me-2"></i>
                        ترتيب
                    </button>
                    <button class="btn btn-light" type="button">
                        <i class="bi bi-download me-2"></i>
                        تصدير CSV
                    </button>
                    <button class="btn btn-light" type="button">
                        <i class="bi bi-printer me-2"></i>
                        طباعة
                    </button>
                    <div class="btn-group">
                        <button class="btn btn-light active">
                            <i class="bi bi-grid"></i>
                        </button>
                        <button class="btn btn-light">
                            <i class="bi bi-list"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="row g-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="bi bi-people text-primary fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="text-muted mb-1">إجمالي العملاء</p>
                        <h3 class="mb-0">{{ $customers->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="bi bi-person-check text-success fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="text-muted mb-1">العملاء النشطون</p>
                        <h3 class="mb-0">0</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="bi bi-star text-warning fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="text-muted mb-1">عملاء VIP</p>
                        <h3 class="mb-0">0</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="bi bi-graph-up text-info fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="text-muted mb-1">معدل النمو</p>
                        <h3 class="mb-0">0%</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search & Filters -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="row g-4">
            <div class="col-12 col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control border-start-0 ps-0" placeholder="بحث عن عميل...">
                </div>
            </div>
            <div class="col-12 col-md-2">
                <select class="form-select">
                    <option value="">المستوى</option>
                    <option value="bronze">برونزي</option>
                    <option value="silver">فضي</option>
                    <option value="gold">ذهبي</option>
                </select>
            </div>
            <div class="col-12 col-md-2">
                <select class="form-select">
                    <option value="">الحالة</option>
                    <option value="active">نشط</option>
                    <option value="inactive">غير نشط</option>
                </select>
            </div>
            <div class="col-12 col-md-2">
                <button class="btn btn-outline-primary w-100">
                    <i class="bi bi-funnel"></i>
                    تصفية
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Customers Table -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                            </div>
                        </th>
                        <th class="border-0">العميل</th>
                        <th class="border-0">رقم الجوال</th>
                        <th class="border-0">النقاط</th>
                        <th class="border-0">المستوى</th>
                        <th class="border-0">آخر نشاط</th>
                        <th class="border-0">الحالة</th>
                        <th class="border-0">خيارات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                    <tr>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox">
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name=احمد+محمد&background=0D8ABC&color=fff"
                                    class="rounded-circle" width="40" height="40" alt="Avatar">
                                <div class="ms-3">
                                    <h6 class="mb-1">عبدالرحمن يوسف</h6>
                                    <small class="text-muted">ahmed@example.com</small>
                                </div>
                            </div>
                        </td>
                        <td>0501234567</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-coin text-warning me-2"></i>
                                2,500
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-warning bg-opacity-10 text-warning">
                                <i class="bi bi-star-fill me-1"></i>
                                ذهبي
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-success rounded-circle me-2" style="width: 6px; height: 6px;"></div>
                                قبل 5 دقائق
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-success">نشط</span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewCustomerModal{{ $customer->id }}">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-whatsapp"></i>
                                </button>
                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من حذف هذا العميل؟');">
                                    <i class="bi bi-trash"></i>
                                </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav class="d-flex justify-content-between align-items-center mt-4">
            <p class="text-muted mb-0">عرض 1 إلى 10 من 50 عميل</p>
            <ul class="pagination mb-0">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">السابق</a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">التالي</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<!-- Add Customer Modal -->
<div class="modal fade" id="addCustomerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة عميل جديد</h5>
                <button type="button" class="btn-close ms-0 me-2" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">الاسم</label>
                        <input type="text" class="form-control" placeholder="أدخل اسم العميل">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" class="form-control" placeholder="أدخل البريد الإلكتروني">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">رقم الجوال</label>
                        <input type="tel" class="form-control" placeholder="أدخل رقم الجوال">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">المستوى</label>
                        <select class="form-select">
                            <option value="bronze">برونزي</option>
                            <option value="silver">فضي</option>
                            <option value="gold">ذهبي</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary">إضافة</button>
            </div>
        </div>
    </div>
</div>

<!-- View Customer Modal -->
<div class="modal fade" id="viewCustomerModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تفاصيل العميل</h5>
                <button type="button" class="btn-close ms-0 me-2" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <!-- Customer Info -->
                    <div class="col-12 col-md-4">
                        <div class="text-center">
                            <img src="https://ui-avatars.com/api/?name=احمد+محمد&background=0D8ABC&color=fff"
                                class="rounded-circle mb-3" width="100" height="100" alt="Avatar">
                            <h5 class="mb-1">عبدالرحمن يوسف</h5>
                            <p class="text-muted mb-3">ahmed@example.com</p>
                            <span class="badge bg-warning bg-opacity-10 text-warning">
                                <i class="bi bi-star-fill me-1"></i>
                                عميل ذهبي
                            </span>
                        </div>
                    </div>

                    <!-- Customer Stats -->
                    <div class="col-12 col-md-8">
                        <div class="row g-4">
                            <div class="col-6">
                                <div class="card border-0 bg-primary bg-opacity-10">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-coin text-primary fs-4 me-2"></i>
                                            <div>
                                                <p class="text-muted mb-0">النقاط الحالية</p>
                                                <h4 class="mb-0">2,500</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card border-0 bg-success bg-opacity-10">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-arrow-repeat text-success fs-4 me-2"></i>
                                            <div>
                                                <p class="text-muted mb-0">عمليات الاستبدال</p>
                                                <h4 class="mb-0">12</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <h6 class="mb-3">معلومات الاتصال</h6>
                        <div class="row">
                            <div class="col-6">
                                <p class="text-muted mb-1">رقم الجوال</p>
                                <p class="mb-3">0501234567</p>
                            </div>
                            <div class="col-6">
                                <p class="text-muted mb-1">البريد الإلكتروني</p>
                                <p class="mb-3">ahmed@example.com</p>
                            </div>
                            <div class="col-6">
                                <p class="text-muted mb-1">تاريخ التسجيل</p>
                                <p class="mb-3">2024/01/15</p>
                            </div>
                            <div class="col-6">
                                <p class="text-muted mb-1">آخر نشاط</p>
                                <p class="mb-3">قبل 5 دقائق</p>
                            </div>
                        </div>

                        <hr>

                        <h6 class="mb-3">آخر المعاملات</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead class="bg-light">
                                    <tr>
                                        <th>التاريخ</th>
                                        <th>النوع</th>
                                        <th>النقاط</th>
                                        <th>الحالة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>2024/03/15</td>
                                        <td>شراء</td>
                                        <td>+100</td>
                                        <td>
                                            <span class="badge bg-success">مكتمل</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2024/03/10</td>
                                        <td>استبدال</td>
                                        <td>-500</td>
                                        <td>
                                            <span class="badge bg-warning">قيد المعالجة</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                <button type="button" class="btn btn-success">
                    <i class="bi bi-whatsapp me-1"></i>
                    مراسلة واتساب
                </button>
                <button type="button" class="btn btn-primary">
                    <i class="bi bi-pencil me-1"></i>
                    تعديل
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.badge {
    font-weight: 500;
    padding: 6px 10px;
}
.table > :not(caption) > * > * {
    padding: 1rem;
}
.btn-group > .btn {
    padding: 0.25rem 0.5rem;
}
.form-check-input:checked {
    background-color: var(--bs-primary);
    border-color: var(--bs-primary);
}
</style>
@endsection
