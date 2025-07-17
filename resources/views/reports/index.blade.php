@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h4 class="mb-0">التقارير</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active">التقارير</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-light" title="تصدير" data-bs-toggle="modal" data-bs-target="#exportModal">
            <i class="bi bi-download me-1"></i>
            تصدير
        </button>
        <button class="btn btn-light" title="طباعة" onclick="window.print()">
            <i class="bi bi-printer me-1"></i>
            طباعة
        </button>
    </div>
</div>
@endsection

@section('content')
<div class="row g-4">
    <!-- فلاتر التقارير -->
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <form class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">نوع التقرير</label>
                        <select class="form-select" name="type">
                            <option value="sales">المبيعات</option>
                            <option value="customers">العملاء</option>
                            <option value="points">النقاط</option>
                            <option value="redemptions">الاستبدالات</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">من تاريخ</label>
                        <input type="date" class="form-control" name="start_date">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">إلى تاريخ</label>
                        <input type="date" class="form-control" name="end_date">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search me-1"></i>
                            عرض التقرير
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- إحصائيات سريعة -->
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stats-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">إجمالي المبيعات</h6>
                        <h3 class="mb-0">0 ر.س</h3>
                        <small class="text-success">
                            <i class="bi bi-arrow-up"></i>
                            0% من الشهر السابق
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stats-icon bg-success bg-opacity-10 text-success">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">العملاء الجدد</h6>
                        <h3 class="mb-0">0</h3>
                        <small class="text-success">
                            <i class="bi bi-arrow-up"></i>
                            0% من الشهر السابق
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stats-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-star"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">النقاط الممنوحة</h6>
                        <h3 class="mb-0">0</h3>
                        <small class="text-success">
                            <i class="bi bi-arrow-up"></i>
                            0% من الشهر السابق
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stats-icon bg-info bg-opacity-10 text-info">
                            <i class="bi bi-gift"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">الاستبدالات</h6>
                        <h3 class="mb-0">0</h3>
                        <small class="text-danger">
                            <i class="bi bi-arrow-down"></i>
                            0% من الشهر السابق
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- الرسم البياني -->
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-transparent py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">تحليل المبيعات</h5>
                    <div class="btn-group">
                        <button type="button" class="btn btn-light active">يومي</button>
                        <button type="button" class="btn btn-light">أسبوعي</button>
                        <button type="button" class="btn btn-light">شهري</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <canvas id="salesChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- جدول التفاصيل -->
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-transparent py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">تفاصيل المبيعات</h5>
                    <div class="d-flex gap-2">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" class="form-control border-0 bg-light" placeholder="بحث...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>رقم الفاتورة</th>
                                <th>العميل</th>
                                <th>التاريخ</th>
                                <th>المبلغ</th>
                                <th>النقاط</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#INV-001</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name=احمد+محمد&background=4e73df&color=ffffff"
                                             class="rounded-circle me-2" width="32" height="32" alt="Customer Avatar">
                                        <div>
                                            <h6 class="mb-0">عبدالرحمن يوسف</h6>
                                            <small class="text-muted">#CUS-001</small>
                                        </div>
                                    </div>
                                </td>
                                <td>2024-03-15</td>
                                <td>500 ر.س</td>
                                <td>+50</td>
                                <td>
                                    <span class="badge bg-success">مكتملة</span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-light">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-light">
                                            <i class="bi bi-download"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0">
                <nav aria-label="Page navigation">
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
    </div>
</div>

<!-- Modal تصدير التقرير -->
<div class="modal fade" id="exportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تصدير التقرير</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">تنسيق الملف</label>
                        <select class="form-select">
                            <option value="excel">Excel</option>
                            <option value="pdf">PDF</option>
                            <option value="csv">CSV</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">نطاق التقرير</label>
                        <select class="form-select">
                            <option value="all">كل البيانات</option>
                            <option value="filtered">البيانات المفلترة</option>
                            <option value="selected">العناصر المحددة</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary">تصدير</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو'],
            datasets: [{
                label: 'المبيعات',
                data: [12, 19, 3, 5, 2, 3],
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
@endpush
@endsection
