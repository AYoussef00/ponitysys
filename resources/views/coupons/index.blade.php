@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h4 class="mb-1">الكوبونات</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active">الكوبونات</li>
            </ol>
        </nav>
    </div>
    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#addCouponModal">
        <i class="bi bi-plus-lg me-2"></i>
        إضافة كوبون
    </button>
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
                            <i class="bi bi-ticket-perforated text-primary fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="text-muted mb-1">إجمالي الكوبونات</p>
                        <h3 class="mb-0">{{ $coupons->total() }}</h3>
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
                            <i class="bi bi-currency-dollar text-success fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="text-muted mb-1">إجمالي الإيرادات</p>
                        <h3 class="mb-0">{{ \App\Models\Coupon::getFormattedTotalRevenue() }}</h3>
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
                        <p class="text-muted mb-1">الكوبونات النشطة</p>
                        <h3 class="mb-0">{{ $coupons->where('status', 'active')->count() }}</h3>
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
                            <i class="bi bi-gift text-warning fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="text-muted mb-1">الكوبونات المجانية</p>
                        <h3 class="mb-0">{{ $coupons->where('is_paid', false)->count() }}</h3>
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
                            <i class="bi bi-clock-history text-danger fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="text-muted mb-1">تنتهي قريباً</p>
                        <h3 class="mb-0">{{ $coupons->where('expires_at', '<=', now()->addDays(7))->count() }}</h3>
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
                            <i class="bi bi-credit-card text-info fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="text-muted mb-1">الكوبونات المدفوعة</p>
                        <h3 class="mb-0">{{ $coupons->where('is_paid', true)->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Action Bar -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="row g-4 align-items-center">
            <div class="col-12 col-lg-6">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control border-start-0 ps-0" placeholder="بحث عن كوبون...">
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="d-flex gap-2 justify-content-lg-end">
                    <select class="form-select w-auto me-2">
                        <option value="">كل الحالات</option>
                        <option value="active">نشط</option>
                        <option value="inactive">غير نشط</option>
                        <option value="expired">منتهي الصلاحية</option>
                    </select>
                    <select class="form-select w-auto me-2">
                        <option value="">كل الأنواع</option>
                        <option value="paid">مدفوع</option>
                        <option value="free">مجاني</option>
                    </select>
                    <button class="btn btn-light" type="button">
                        <i class="bi bi-download me-2"></i>
                        تصدير
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Coupons Table -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>الكود</th>
                        <th>الاسم</th>
                        <th>النوع</th>
                        <th>القيمة</th>
                        <th>السعر</th>
                        <th>تاريخ التفعيل</th>
                        <th>تاريخ الانتهاء</th>
                        <th>تاريخ الإنشاء</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($coupons as $coupon)
                    <tr>
                        <td><code>{{ $coupon->code }}</code></td>
                        <td>{{ $coupon->name }}</td>
                        <td>
                            @if($coupon->type === 'percentage')
                                نسبة مئوية
                            @else
                                مبلغ ثابت
                            @endif
                        </td>
                        <td>
                            @if($coupon->type === 'percentage')
                                {{ $coupon->value }}%
                            @else
                                {{ $coupon->value }} ريال
                            @endif
                        </td>
                        <td>
                            @if($coupon->is_paid && $coupon->price)
                                <span class="badge bg-warning">{{ $coupon->price }} ريال</span>
                            @else
                                <span class="badge bg-success">مجاني</span>
                            @endif
                        </td>
                        <td>
                            @if($coupon->starts_at)
                                {{ $coupon->starts_at->format('Y/m/d') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($coupon->expires_at)
                                {{ $coupon->expires_at->format('Y/m/d') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($coupon->created_at)
                                {{ $coupon->created_at->format('Y/m/d H:i') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($coupon->status === 'active')
                                <span class="badge bg-success">نشط</span>
                            @elseif($coupon->status === 'inactive')
                                <span class="badge bg-secondary">غير نشط</span>
                            @else
                                <span class="badge bg-danger">منتهي</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-light" title="تعديل" data-bs-toggle="modal" data-bs-target="#editCouponModal{{ $coupon->id }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-light" title="{{ $coupon->status === 'active' ? 'إيقاف' : 'تفعيل' }}"
                                    onclick="event.preventDefault(); document.getElementById('toggle-form-{{ $coupon->id }}').submit();">
                                    <i class="bi bi-{{ $coupon->status === 'active' ? 'pause-fill' : 'play-fill' }}"></i>
                                </button>
                                <button class="btn btn-sm btn-light text-danger" title="حذف"
                                    onclick="event.preventDefault(); if(confirm('هل أنت متأكد من حذف هذا الكوبون؟')) document.getElementById('delete-form-{{ $coupon->id }}').submit();">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>

                            <form id="toggle-form-{{ $coupon->id }}" action="{{ route('coupons.toggle', $coupon) }}" method="POST" class="d-none">
                                @csrf
                            </form>

                            <form id="delete-form-{{ $coupon->id }}" action="{{ route('coupons.destroy', $coupon) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4">
                            <div class="d-flex flex-column align-items-center">
                                <i class="bi bi-ticket-perforated text-muted mb-2" style="font-size: 2rem;"></i>
                                <h5 class="mb-1">لا توجد كوبونات</h5>
                                <p class="text-muted">قم بإضافة كوبونات جديدة لعرضها هنا</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $coupons->links() }}
        </div>
    </div>
</div>

<!-- Add Coupon Modal -->
<div class="modal fade" id="addCouponModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('coupons.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">إضافة كوبون جديد</h5>
                    <button type="button" class="btn-close ms-0 me-2" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">كود الكوبون</label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                                placeholder="مثال: WELCOME2024" value="{{ old('code') }}">
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">اسم الكوبون</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                placeholder="مثال: كوبون الترحيب" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">نوع الخصم</label>
                            <select name="type" class="form-select @error('type') is-invalid @enderror">
                                <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>نسبة مئوية</option>
                                <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>مبلغ ثابت</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">قيمة الخصم</label>
                            <input type="number" name="value" step="0.01" class="form-control @error('value') is-invalid @enderror"
                                placeholder="أدخل القيمة" value="{{ old('value') }}">
                            @error('value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">نوع الكوبون</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_paid" value="1" id="isPaidCheck" {{ old('is_paid') ? 'checked' : '' }}>
                                <label class="form-check-label" for="isPaidCheck">
                                    كوبون مدفوع
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6" id="priceField" style="display: none;">
                            <label class="form-label">سعر الكوبون (ريال)</label>
                            <input type="number" name="price" step="0.01" class="form-control @error('price') is-invalid @enderror"
                                placeholder="أدخل السعر" value="{{ old('price') }}">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">تاريخ التفعيل</label>
                            <input type="date" name="starts_at" class="form-control @error('starts_at') is-invalid @enderror"
                                value="{{ old('starts_at') }}">
                            @error('starts_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">تاريخ الانتهاء</label>
                            <input type="date" name="expires_at" class="form-control @error('expires_at') is-invalid @enderror"
                                value="{{ old('expires_at') }}">
                            @error('expires_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">الوصف</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                rows="3" placeholder="أدخل وصف الكوبون">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">إضافة</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($coupons as $coupon)
<div class="modal fade" id="editCouponModal{{ $coupon->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('coupons.update', $coupon) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">تعديل الكوبون</h5>
                    <button type="button" class="btn-close ms-0 me-2" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">كود الكوبون</label>
                            <input type="text" name="code" class="form-control" value="{{ $coupon->code }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">اسم الكوبون</label>
                            <input type="text" name="name" class="form-control" value="{{ $coupon->name }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">نوع الخصم</label>
                            <select name="type" class="form-select">
                                <option value="percentage" {{ $coupon->type === 'percentage' ? 'selected' : '' }}>نسبة مئوية</option>
                                <option value="fixed" {{ $coupon->type === 'fixed' ? 'selected' : '' }}>مبلغ ثابت</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">قيمة الخصم</label>
                            <input type="number" name="value" step="0.01" class="form-control" value="{{ $coupon->value }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">نوع الكوبون</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_paid" value="1" id="isPaidCheck{{ $coupon->id }}" {{ $coupon->is_paid ? 'checked' : '' }}>
                                <label class="form-check-label" for="isPaidCheck{{ $coupon->id }}">
                                    كوبون مدفوع
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6" id="priceField{{ $coupon->id }}" style="display: {{ $coupon->is_paid ? 'block' : 'none' }};">
                            <label class="form-label">سعر الكوبون (ريال)</label>
                            <input type="number" name="price" step="0.01" class="form-control" value="{{ $coupon->price }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">تاريخ التفعيل</label>
                            <input type="date" name="starts_at" class="form-control" value="{{ optional($coupon->starts_at)->format('Y-m-d') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">تاريخ الانتهاء</label>
                            <input type="date" name="expires_at" class="form-control" value="{{ optional($coupon->expires_at)->format('Y-m-d') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">الوصف</label>
                            <textarea name="description" class="form-control" rows="3">{{ $coupon->description }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">الحالة</label>
                            <select name="status" class="form-select">
                                <option value="active" {{ $coupon->status === 'active' ? 'selected' : '' }}>نشط</option>
                                <option value="inactive" {{ $coupon->status === 'inactive' ? 'selected' : '' }}>غير نشط</option>
                                <option value="expired" {{ $coupon->status === 'expired' ? 'selected' : '' }}>منتهي</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<style>
.table th {
    font-weight: 600;
}
.badge {
    font-weight: 500;
    padding: 6px 10px;
}
.modal-header .btn-close {
    margin: 0;
}
.form-label {
    font-weight: 500;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // للكوبون الجديد
    const isPaidCheck = document.getElementById('isPaidCheck');
    const priceField = document.getElementById('priceField');

    if (isPaidCheck) {
        isPaidCheck.addEventListener('change', function() {
            priceField.style.display = this.checked ? 'block' : 'none';
        });
    }

    // للكوبونات الموجودة
    @foreach($coupons as $coupon)
    const isPaidCheck{{ $coupon->id }} = document.getElementById('isPaidCheck{{ $coupon->id }}');
    const priceField{{ $coupon->id }} = document.getElementById('priceField{{ $coupon->id }}');

    if (isPaidCheck{{ $coupon->id }}) {
        isPaidCheck{{ $coupon->id }}.addEventListener('change', function() {
            priceField{{ $coupon->id }}.style.display = this.checked ? 'block' : 'none';
        });
    }
    @endforeach
});
</script>
@endsection
