@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <h4 class="mb-0">التحليلات</h4>
    <div class="btn-group">
        <button class="btn btn-outline-primary active">اليوم</button>
        <button class="btn btn-outline-primary">الأسبوع</button>
        <button class="btn btn-outline-primary">الشهر</button>
        <button class="btn btn-outline-primary">السنة</button>
    </div>
</div>
@endsection

@section('content')
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
                        <div class="d-flex align-items-center mb-1">
                            <h3 class="mb-0">1,250</h3>
                            <span class="badge bg-success bg-opacity-10 text-success ms-2">
                                <i class="bi bi-arrow-up"></i>
                                12%
                            </span>
                        </div>
                        <p class="text-muted mb-0">عميل نشط</p>
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
                            <i class="bi bi-coin text-success fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="d-flex align-items-center mb-1">
                            <h3 class="mb-0">45,678</h3>
                            <span class="badge bg-success bg-opacity-10 text-success ms-2">
                                <i class="bi bi-arrow-up"></i>
                                8%
                            </span>
                        </div>
                        <p class="text-muted mb-0">نقطة مكتسبة</p>
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
                            <i class="bi bi-arrow-repeat text-warning fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="d-flex align-items-center mb-1">
                            <h3 class="mb-0">156</h3>
                            <span class="badge bg-danger bg-opacity-10 text-danger ms-2">
                                <i class="bi bi-arrow-down"></i>
                                3%
                            </span>
                        </div>
                        <p class="text-muted mb-0">عملية استبدال</p>
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
                        <div class="d-flex align-items-center mb-1">
                            <h3 class="mb-0">85%</h3>
                            <span class="badge bg-success bg-opacity-10 text-success ms-2">
                                <i class="bi bi-arrow-up"></i>
                                5%
                            </span>
                        </div>
                        <p class="text-muted mb-0">معدل المشاركة</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row g-4 mb-4">
    <!-- Points Activity -->
    <div class="col-12 col-xl-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">نشاط النقاط</h5>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-secondary active">مكتسبة</button>
                        <button class="btn btn-outline-secondary">مستبدلة</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <canvas id="pointsChart" style="height: 300px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Customer Distribution -->
    <div class="col-12 col-xl-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h5 class="card-title mb-0">توزيع العملاء حسب المستوى</h5>
            </div>
            <div class="card-body">
                <canvas id="customerChart" style="height: 300px;"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Stats -->
<div class="row g-4">
    <!-- Top Rewards -->
    <div class="col-12 col-xl-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h5 class="card-title mb-0">المكافآت الأكثر استبدالاً</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0">المكافأة</th>
                                <th class="border-0">الاستبدالات</th>
                                <th class="border-0">النقاط</th>
                                <th class="border-0">النسبة</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 p-2 rounded">
                                            <i class="bi bi-gift text-primary"></i>
                                        </div>
                                        <div class="ms-3">
                                            <h6 class="mb-0">قسيمة شراء 100 ريال</h6>
                                            <small class="text-muted">متجر الإلكترونيات</small>
                                        </div>
                                    </div>
                                </td>
                                <td>45</td>
                                <td>1,000</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 me-2">
                                            <div class="progress" style="height: 5px;">
                                                <div class="progress-bar bg-primary" style="width: 65%"></div>
                                            </div>
                                        </div>
                                        <span>65%</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success bg-opacity-10 p-2 rounded">
                                            <i class="bi bi-percent text-success"></i>
                                        </div>
                                        <div class="ms-3">
                                            <h6 class="mb-0">خصم 25% على الملابس</h6>
                                            <small class="text-muted">متجر الأزياء</small>
                                        </div>
                                    </div>
                                </td>
                                <td>32</td>
                                <td>750</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 me-2">
                                            <div class="progress" style="height: 5px;">
                                                <div class="progress-bar bg-success" style="width: 45%"></div>
                                            </div>
                                        </div>
                                        <span>45%</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Activity -->
    <div class="col-12 col-xl-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h5 class="card-title mb-0">نشاط العملاء</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0">العميل</th>
                                <th class="border-0">النقاط</th>
                                <th class="border-0">المستوى</th>
                                <th class="border-0">النشاط</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
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
                                <td>2,500</td>
                                <td>
                                    <span class="badge bg-warning bg-opacity-10 text-warning">
                                        ذهبي
                                    </span>
                                </td>
                                <td>
                                    <canvas id="activity1" width="100" height="30"></canvas>
                                </td>
                            </tr>
                            <tr>
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
                                <td>1,800</td>
                                <td>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                        فضي
                                    </span>
                                </td>
                                <td>
                                    <canvas id="activity2" width="100" height="30"></canvas>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Points Activity Chart
    new Chart(document.getElementById('pointsChart'), {
        type: 'line',
        data: {
            labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو'],
            datasets: [{
                label: 'النقاط المكتسبة',
                data: [1200, 1900, 3000, 5000, 6000, 4500],
                borderColor: '#0d6efd',
                tension: 0.4,
                fill: true,
                backgroundColor: 'rgba(13, 110, 253, 0.1)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Customer Distribution Chart
    new Chart(document.getElementById('customerChart'), {
        type: 'doughnut',
        data: {
            labels: ['برونزي', 'فضي', 'ذهبي'],
            datasets: [{
                data: [300, 150, 100],
                backgroundColor: ['#6c757d', '#adb5bd', '#ffc107']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            },
            cutout: '60%'
        }
    });

    // Customer Activity Charts
    const activityConfig = {
        type: 'line',
        data: {
            labels: Array(10).fill(''),
            datasets: [{
                data: [3, 5, 4, 6, 5, 7, 6, 8, 7, 9],
                borderColor: '#0d6efd',
                borderWidth: 2,
                pointRadius: 0,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    display: false,
                    min: 0
                },
                x: {
                    display: false
                }
            }
        }
    };

    new Chart(document.getElementById('activity1'), activityConfig);
    new Chart(document.getElementById('activity2'), {
        ...activityConfig,
        data: {
            ...activityConfig.data,
            datasets: [{
                ...activityConfig.data.datasets[0],
                data: [5, 4, 6, 5, 7, 6, 8, 7, 9, 8]
            }]
        }
    });
</script>
@endpush

<style>
.badge {
    font-weight: 500;
    padding: 6px 10px;
}
.progress {
    border-radius: 10px;
}
.progress-bar {
    border-radius: 10px;
}
.table > :not(caption) > * > * {
    padding: 1rem;
}
</style>
@endsection
