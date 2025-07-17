@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h4 class="mb-1">المكافآت</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active">المكافآت</li>
            </ol>
        </nav>
    </div>
    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#addRewardModal">
        <i class="bi bi-plus-lg me-2"></i>
        إضافة مكافأة
    </button>
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
                    <input type="text" class="form-control border-start-0 ps-0" placeholder="بحث عن مكافأة...">
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
                            <i class="bi bi-gift text-primary fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="text-muted mb-1">إجمالي المكافآت</p>
                        <h3 class="mb-0">{{ \App\Models\Reward::count() }}</h3>
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
                        <p class="text-muted mb-1">المكافآت النشطة</p>
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
                            <i class="bi bi-arrow-repeat text-warning fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="text-muted mb-1">عمليات الاستبدال</p>
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
                            <i class="bi bi-people text-info fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="text-muted mb-1">المستفيدون</p>
                        <h3 class="mb-0">0</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Rewards Grid -->
<div class="row g-4">
    @foreach($rewards as $reward)
    <div class="col-12 col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="position-relative">
                <div class="card-img-top d-flex align-items-center justify-content-center bg-light">
                    <i class="bi bi-gift-fill text-primary" style="font-size: 4rem;"></i>
                </div>
                <span class="badge bg-success position-absolute top-0 end-0 m-3">{{ $reward->status === 'active' ? 'نشط' : 'غير نشط' }}</span>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">{{ $reward->title }}</h5>
                    <span class="badge bg-primary">{{ $reward->points_required }} نقطة</span>
                </div>
                <p class="card-text text-muted">{{ $reward->description }}</p>
                <div class="mb-3">
                    <small class="text-muted">المتاح: {{ $reward->quantity }} من {{ $reward->quantity }}</small>
                    <div class="progress mt-1" style="height: 5px;">
                        <div class="progress-bar bg-success" style="width: 100%"></div>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <form action="{{ route('rewards.destroy', $reward->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من حذف هذه المكافأة؟');">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                    <button class="btn btn-sm btn-primary flex-grow-1">
                        <i class="bi bi-pencil me-1"></i>
                        تعديل
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Add Reward Modal -->
<div class="modal fade" id="addRewardModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة مكافأة جديدة</h5>
                <button type="button" class="btn-close ms-0 me-2" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">عنوان المكافأة</label>
                        <input type="text" class="form-control" placeholder="أدخل عنوان المكافأة">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الوصف</label>
                        <textarea class="form-control" rows="3" placeholder="أدخل وصف المكافأة"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">النقاط المطلوبة</label>
                        <input type="number" class="form-control" placeholder="أدخل عدد النقاط">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الكمية المتوفرة</label>
                        <input type="number" class="form-control" placeholder="أدخل الكمية">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">تاريخ الانتهاء</label>
                        <input type="date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الصورة</label>
                        <input type="file" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الحالة</label>
                        <select class="form-select">
                            <option value="active">نشط</option>
                            <option value="inactive">غير نشط</option>
                            <option value="draft">مسودة</option>
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
.card-img-top {
    height: 200px;
    object-fit: cover;
}
</style>
@endsection
