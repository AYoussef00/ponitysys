@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <h4 class="mb-0">الاستبدالات</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
        <i class="bi bi-funnel"></i>
        تصفية النتائج
    </button>
</div>
@endsection

@section('content')
<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="bi bi-arrow-repeat text-primary fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">إجمالي الاستبدالات</h6>
                        <h3 class="mb-0">156</h3>
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
                            <i class="bi bi-check-circle text-success fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">الاستبدالات المكتملة</h6>
                        <h3 class="mb-0">124</h3>
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
                            <i class="bi bi-clock-history text-warning fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">قيد الانتظار</h6>
                        <h3 class="mb-0">22</h3>
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
                        <div class="bg-danger bg-opacity-10 p-3 rounded">
                            <i class="bi bi-x-circle text-danger fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">الاستبدالات الملغاة</h6>
                        <h3 class="mb-0">10</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Redemptions Table -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <!-- Search -->
        <div class="row mb-4">
            <div class="col-12 col-md-8">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control border-start-0 ps-0" placeholder="بحث عن استبدال...">
                </div>
            </div>
            <div class="col-12 col-md-4 mt-3 mt-md-0">
                <select class="form-select">
                    <option value="">جميع الحالات</option>
                    <option value="completed">مكتمل</option>
                    <option value="pending">قيد الانتظار</option>
                    <option value="cancelled">ملغي</option>
                </select>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0">رقم الاستبدال</th>
                        <th class="border-0">العميل</th>
                        <th class="border-0">المكافأة</th>
                        <th class="border-0">النقاط</th>
                        <th class="border-0">التاريخ</th>
                        <th class="border-0">الحالة</th>
                        <th class="border-0">خيارات</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#RED123</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name=احمد+محمد&background=0D8ABC&color=fff"
                                    class="rounded-circle" width="35" height="35" alt="Avatar">
                                <div class="ms-3">
                                    <h6 class="mb-0">عبدالرحمن يوسف</h6>
                                    <small class="text-muted">ahmed@example.com</small>
                                </div>
                            </div>
                        </td>
                        <td>قسيمة شراء بقيمة 100 ريال</td>
                        <td>1,000</td>
                        <td>2024/03/15</td>
                        <td>
                            <span class="badge bg-success bg-opacity-10 text-success">
                                مكتمل
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewModal">
                                <i class="bi bi-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>#RED124</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name=سارة+احمد&background=0D8ABC&color=fff"
                                    class="rounded-circle" width="35" height="35" alt="Avatar">
                                <div class="ms-3">
                                    <h6 class="mb-0">سارة أحمد</h6>
                                    <small class="text-muted">sara@example.com</small>
                                </div>
                            </div>
                        </td>
                        <td>خصم 25% على الملابس</td>
                        <td>750</td>
                        <td>2024/03/14</td>
                        <td>
                            <span class="badge bg-warning bg-opacity-10 text-warning">
                                قيد الانتظار
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewModal">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav class="mt-4">
            <ul class="pagination justify-content-center mb-0">
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

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تصفية النتائج</h5>
                <button type="button" class="btn-close ms-0 me-2" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">الفترة الزمنية</label>
                        <select class="form-select">
                            <option value="today">اليوم</option>
                            <option value="week">آخر أسبوع</option>
                            <option value="month">آخر شهر</option>
                            <option value="custom">تخصيص</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">حالة الاستبدال</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="completed" checked>
                            <label class="form-check-label" for="completed">مكتمل</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="pending" checked>
                            <label class="form-check-label" for="pending">قيد الانتظار</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="cancelled">
                            <label class="form-check-label" for="cancelled">ملغي</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">نوع المكافأة</label>
                        <select class="form-select">
                            <option value="">جميع المكافآت</option>
                            <option value="voucher">قسائم شراء</option>
                            <option value="discount">خصومات</option>
                            <option value="product">منتجات مجانية</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary">تطبيق</button>
            </div>
        </div>
    </div>
</div>

<!-- View Redemption Modal -->
<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تفاصيل الاستبدال #RED123</h5>
                <button type="button" class="btn-close ms-0 me-2" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <h6 class="mb-3">معلومات العميل</h6>
                    <div class="d-flex align-items-center">
                        <img src="https://ui-avatars.com/api/?name=احمد+محمد&background=0D8ABC&color=fff"
                            class="rounded-circle" width="50" height="50" alt="Avatar">
                        <div class="ms-3">
                            <h6 class="mb-1">عبدالرحمن يوسف</h6>
                            <p class="mb-0 text-muted">ahmed@example.com</p>
                            <p class="mb-0 text-muted">0501234567</p>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <h6 class="mb-3">تفاصيل المكافأة</h6>
                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <h6 class="card-title mb-2">قسيمة شراء بقيمة 100 ريال</h6>
                            <p class="card-text mb-2">متجر الإلكترونيات</p>
                            <p class="card-text mb-0">
                                <span class="badge bg-primary">1000 نقطة</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <h6 class="mb-3">معلومات الاستبدال</h6>
                    <div class="row">
                        <div class="col-6">
                            <p class="text-muted mb-1">رقم الاستبدال</p>
                            <p class="mb-3">#RED123</p>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-1">تاريخ الاستبدال</p>
                            <p class="mb-3">2024/03/15</p>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-1">الحالة</p>
                            <span class="badge bg-success bg-opacity-10 text-success">
                                مكتمل
                            </span>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-1">رمز القسيمة</p>
                            <p class="mb-0">VOUCHER123</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                <button type="button" class="btn btn-primary">
                    <i class="bi bi-printer"></i>
                    طباعة
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
</style>
@endsection
