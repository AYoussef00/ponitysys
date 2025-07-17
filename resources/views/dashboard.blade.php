@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h4 class="mb-0">لوحة التحكم</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item active">لوحة التحكم</li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('content')
<style>
.avatar {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
}
</style>

<!-- إحصائيات سريعة -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stats-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-star"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">إجمالي النقاط</h6>
                        <h3 class="mb-0">{{ number_format($stats['total_points']) }}</h3>
                        <small class="@if($stats['points_change'] >= 0) text-success @else text-danger @endif">
                            @if($stats['total_points'] != 0)
                            <i class="bi bi-arrow-@if($stats['points_change'] >= 0)up @else down @endif"></i>
                            {{ abs($stats['points_change']) }}% من الشهر السابق
                            @endif
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
                            <i class="bi bi-gift"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">النقاط المستبدلة</h6>
                        <h3 class="mb-0">{{ number_format($stats['redeemed_points']) }}</h3>
                        <small class="@if($stats['redeemed_change'] >= 0) text-success @else text-danger @endif">
                            @if($stats['redeemed_points'] != 0)
                            <i class="bi bi-arrow-@if($stats['redeemed_change'] >= 0)up @else down @endif"></i>
                            {{ abs($stats['redeemed_change']) }}% من الشهر السابق
                            @endif
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
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">العملاء النشطين</h6>
                        <h3 class="mb-0">{{ number_format($stats['active_customers']) }}</h3>
                        <small class="@if($stats['customers_change'] >= 0) text-success @else text-danger @endif">
                            @if($stats['active_customers'] != 0)
                            <i class="bi bi-arrow-@if($stats['customers_change'] >= 0)up @else down @endif"></i>
                            {{ abs($stats['customers_change']) }}% من الشهر السابق
                            @endif
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
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">متوسط النقاط</h6>
                        <h3 class="mb-0">{{ number_format($stats['avg_points'], 1) }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- الرسوم البيانية للنقاط -->
<div class="row g-4">
    <!-- رسم بياني لتوزيع النقاط -->
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-transparent py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">توزيع النقاط خلال السنة</h5>
                    <div class="btn-group">
                        <button type="button" class="btn btn-light active">شهري</button>
                        <button type="button" class="btn btn-light">ربع سنوي</button>
                        <button type="button" class="btn btn-light">سنوي</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <canvas id="pointsDistributionChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- رسم بياني دائري لفئات النقاط -->
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-transparent py-3">
                <h5 class="mb-0">توزيع فئات النقاط</h5>
            </div>
            <div class="card-body">
                <canvas id="pointsCategoryChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- رسم بياني للمقارنة -->
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-transparent py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">مقارنة النقاط المكتسبة والمستبدلة</h5>
                    <select class="form-select" style="width: auto;">
                        <option>آخر 7 أيام</option>
                        <option>آخر 30 يوم</option>
                        <option>آخر 90 يوم</option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <canvas id="pointsComparisonChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // رسم بياني لتوزيع النقاط
    new Chart(document.getElementById('pointsDistributionChart'), {
        type: 'line',
        data: {
            labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
            datasets: [{
                label: 'النقاط المكتسبة',
                data: @json(array_values($monthlyPoints)),
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1,
                fill: true,
                backgroundColor: 'rgba(75, 192, 192, 0.1)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // رسم بياني دائري لفئات النقاط
    new Chart(document.getElementById('pointsCategoryChart'), {
        type: 'doughnut',
        data: {
            labels: @json($pointsCategories->pluck('category')),
            datasets: [{
                data: @json($pointsCategories->pluck('points')),
                backgroundColor: [
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(255, 99, 132, 0.8)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // رسم بياني للمقارنة
    new Chart(document.getElementById('pointsComparisonChart'), {
        type: 'bar',
        data: {
            labels: @json(collect($weekComparison)->pluck('day_name')),
            datasets: [{
                label: 'النقاط المكتسبة',
                data: @json(collect($weekComparison)->pluck('earned')),
                backgroundColor: 'rgba(75, 192, 192, 0.8)',
                borderColor: 'rgb(75, 192, 192)',
                borderWidth: 1
            }, {
                label: 'النقاط المستبدلة',
                data: @json(collect($weekComparison)->pluck('redeemed')),
                backgroundColor: 'rgba(255, 99, 132, 0.8)',
                borderColor: 'rgb(255, 99, 132)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
                }
            },
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
