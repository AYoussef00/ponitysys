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
    <div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
            <i class="bi bi-plus-circle me-2"></i>
            إضافة عميل جديد
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // تفعيل tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // إعادة فتح modal في حالة وجود أخطاء
    @if($errors->any())
        $('#addCustomerModal').modal('show');
    @endif

    // إغلاق modal عند النجاح
    @if(session('success'))
        $('#addCustomerModal').modal('hide');
    @endif

    // حذف العميل مع تأكيد محسن
    $('.delete-customer-btn').click(function(e) {
        e.preventDefault();

        const customerName = $(this).data('customer-name');
        const customerId = $(this).data('customer-id');
        const form = $(this).closest('form');

        // إظهار تأكيد محسن
        if (confirm(`هل أنت متأكد من حذف العميل "${customerName}"؟\n\nهذا الإجراء لا يمكن التراجع عنه.`)) {
            // إظهار loading
            $(this).prop('disabled', true).html('<i class="bi bi-hourglass-split"></i>');

            // إرسال الطلب
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    // إظهار رسالة نجاح
                    showAlert(`تم حذف العميل "${customerName}" بنجاح`, 'success');

                    // إعادة تحميل الصفحة بعد ثانية
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                },
                error: function(xhr) {
                    // إظهار رسالة خطأ
                    showAlert('حدث خطأ أثناء حذف العميل', 'error');

                    // إعادة تفعيل الزر
                    $('.delete-customer-btn[data-customer-id="' + customerId + '"]')
                        .prop('disabled', false)
                        .html('<i class="bi bi-trash"></i>');
                }
            });
        }
    });

    // function لعرض الرسائل
    function showAlert(message, type) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alertHtml = `<div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>`;

        $('body').append(alertHtml);
        setTimeout(() => {
            $('.alert').alert('close');
        }, 3000);
    }

    // إضافة نقاط للعميل
    $('.add-points-btn').click(function() {
        const customerId = $(this).data('customer-id');
        const customerName = $(this).data('customer-name');
        const customerPoints = $(this).data('customer-points');

        // تحديث بيانات modal
        $('#customerInfo').text(`إضافة نقاط للعميل: ${customerName}`);
        $('#pointsCustomerId').val(customerId);
        $('#currentPoints').text(customerPoints);

        // إعادة تعيين النموذج
        $('#addPointsForm')[0].reset();
    });

    // معالجة إرسال نموذج إضافة النقاط
    $('#addPointsForm').submit(function(e) {
        e.preventDefault();

        const form = $(this);
        const submitBtn = $('#submitPointsBtn');
        const originalText = submitBtn.html();

        // إظهار loading
        submitBtn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> جاري الإضافة...');

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.status === 'success') {
                    showAlert(response.message, 'success');
                    $('#addPointsModal').modal('hide');

                    // إعادة تحميل الصفحة بعد ثانية
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showAlert(response.message || 'حدث خطأ أثناء إضافة النقاط', 'error');
                }
            },
            error: function(xhr) {
                let errorMessage = 'حدث خطأ أثناء إضافة النقاط';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = Object.values(xhr.responseJSON.errors).flat();
                    errorMessage = errors.join('\n');
                }

                showAlert(errorMessage, 'error');
            },
            complete: function() {
                // إعادة تفعيل الزر
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });

    // توليد رقم مرجعي تلقائياً
    $('#pointsReferenceId').on('focus', function() {
        if (!$(this).val()) {
            generateReferenceId();
        }
    });

    // زر توليد الرقم المرجعي
    $('#generateReferenceBtn').click(function() {
        generateReferenceId();
    });

    function generateReferenceId() {
        const timestamp = Date.now();
        const random = Math.floor(Math.random() * 1000);
        const customerId = $('#pointsCustomerId').val();
        $('#pointsReferenceId').val(`POINTS_${customerId}_${timestamp}_${random}`);
    }

        // حساب النقاط الجديدة
    $('#pointsAmount').on('input', function() {
        const currentPoints = parseInt($('#currentPoints').text()) || 0;
        const newPoints = parseInt($(this).val()) || 0;
        const totalPoints = currentPoints + newPoints;

        $('#newPoints').text(totalPoints);

        // تغيير لون النص بناءً على القيمة
        if (newPoints > 0) {
            $('#newPoints').removeClass('text-danger').addClass('text-success');
        } else {
            $('#newPoints').removeClass('text-success').addClass('text-danger');
        }
    });

    // تحديث hint الوصف بناءً على السبب
    $('#pointsReason').on('change', function() {
        const reason = $(this).val();
        const hints = {
            'purchase': 'مثال: شراء منتج بقيمة 100 ريال',
            'referral': 'مثال: إحالة العميل أحمد محمد',
            'birthday': 'مثال: عيد ميلاد العميل',
            'promotion': 'مثال: عرض ترويجي للصيف',
            'compensation': 'مثال: تعويض عن مشكلة سابقة',
            'other': 'أدخل وصف تفصيلي للعملية'
        };

        $('#descriptionHint').text(hints[reason] || 'أدخل وصف تفصيلي للعملية');
    });
});
</script>
@endpush

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle me-2"></i>
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

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
                        <h3 class="mb-0" id="totalCustomers">{{ $customers->count() }}</h3>
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
                        <h3 class="mb-0">{{ $customers->where('status', 'active')->count() }}</h3>
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
                        <h3 class="mb-0">{{ $customers->where('tier', 'gold')->count() }}</h3>
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
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&background=0D8ABC&color=fff"
                                    class="rounded-circle" width="40" height="40" alt="Avatar">
                                <div class="ms-3">
                                    <h6 class="mb-1">{{ $customer->name }}</h6>
                                    <small class="text-muted">{{ $customer->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $customer->phone }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-coin text-warning me-2"></i>
                                {{ number_format($customer->points_balance) }}
                            </div>
                        </td>
                        <td>
                            @php
                                $tierColors = [
                                    'bronze' => 'bg-danger bg-opacity-10 text-danger',
                                    'silver' => 'bg-secondary bg-opacity-10 text-secondary',
                                    'gold' => 'bg-warning bg-opacity-10 text-warning'
                                ];
                                $tierNames = [
                                    'bronze' => 'برونزي',
                                    'silver' => 'فضي',
                                    'gold' => 'ذهبي'
                                ];
                                $tierColor = $tierColors[$customer->tier] ?? 'bg-secondary bg-opacity-10 text-secondary';
                                $tierName = $tierNames[$customer->tier] ?? 'غير محدد';
                            @endphp
                            <span class="badge {{ $tierColor }}">
                                <i class="bi bi-star-fill me-1"></i>
                                {{ $tierName }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-success rounded-circle me-2" style="width: 6px; height: 6px;"></div>
                                {{ $customer->updated_at ? $customer->updated_at->diffForHumans() : 'غير محدد' }}
                            </div>
                        </td>
                        <td>
                            <span class="badge {{ $customer->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $customer->status === 'active' ? 'نشط' : 'غير نشط' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewCustomerModal{{ $customer->id }}">
                                    <i class="bi bi-eye"></i>
                                </button>
                                                                <button class="btn btn-sm btn-outline-warning add-points-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addPointsModal"
                                        data-customer-id="{{ $customer->id }}"
                                        data-customer-name="{{ $customer->name }}"
                                        data-customer-points="{{ $customer->points_balance }}"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="إضافة نقاط للعميل">
                                    <i class="bi bi-plus-circle"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-whatsapp"></i>
                                </button>
                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline;" class="delete-customer-form">
                                    @csrf
                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger delete-customer-btn"
                                        data-customer-name="{{ $customer->name }}"
                                        data-customer-id="{{ $customer->id }}"
                                        title="حذف العميل">
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
            <p class="text-muted mb-0">عرض 1 إلى {{ $customers->count() }} من {{ $customers->count() }} عميل</p>
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
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('customers.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">الاسم</label>
                        <input type="text" class="form-control" name="name" placeholder="أدخل اسم العميل" value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" class="form-control" name="email" placeholder="أدخل البريد الإلكتروني" value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">رقم الجوال</label>
                        <input type="tel" class="form-control" name="phone" placeholder="أدخل رقم الجوال" value="{{ old('phone') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">المستوى</label>
                        <select class="form-select" name="tier" required>
                            <option value="bronze" {{ old('tier') == 'bronze' ? 'selected' : '' }}>برونزي</option>
                            <option value="silver" {{ old('tier') == 'silver' ? 'selected' : '' }}>فضي</option>
                            <option value="gold" {{ old('tier') == 'gold' ? 'selected' : '' }}>ذهبي</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">إضافة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Points Modal -->
<div class="modal fade" id="addPointsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة نقاط للعميل</h5>
                <button type="button" class="btn-close ms-0 me-2" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong id="customerInfo">إضافة نقاط للعميل</strong>
                </div>

                <form id="addPointsForm" action="{{ route('customers.add-points') }}" method="POST">
                    @csrf
                    <input type="hidden" name="customer_id" id="pointsCustomerId">

                                        <div class="mb-3">
                        <label class="form-label">عدد النقاط</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="points" id="pointsAmount"
                                   placeholder="أدخل عدد النقاط" min="1" required>
                            <span class="input-group-text">نقطة</span>
                        </div>
                        <div class="form-text">
                            النقاط الحالية: <span id="currentPoints">0</span> |
                            النقاط الجديدة: <span id="newPoints" class="text-success fw-bold">0</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">سبب إضافة النقاط</label>
                        <select class="form-select" name="reason" id="pointsReason" required>
                            <option value="">اختر السبب</option>
                            <option value="purchase">شراء منتج</option>
                            <option value="referral">إحالة عميل</option>
                            <option value="birthday">عيد ميلاد</option>
                            <option value="promotion">عرض ترويجي</option>
                            <option value="compensation">تعويض</option>
                            <option value="other">أخرى</option>
                        </select>
                    </div>

                                        <div class="mb-3">
                        <label class="form-label">الوصف التفصيلي</label>
                        <textarea class="form-control" name="description" id="pointsDescription"
                                  rows="3" placeholder="أدخل وصف تفصيلي للعملية" required></textarea>
                        <div class="form-text" id="descriptionHint">أدخل وصف تفصيلي للعملية</div>
                    </div>

                                        <div class="mb-3">
                        <label class="form-label">الرقم المرجعي</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="reference_id" id="pointsReferenceId"
                                   placeholder="مثال: ORDER_001" required>
                            <button class="btn btn-outline-secondary" type="button" id="generateReferenceBtn">
                                <i class="bi bi-arrow-clockwise"></i>
                            </button>
                        </div>
                        <div class="form-text">رقم مرجعي فريد للعملية</div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-warning" id="submitPointsBtn">
                            <i class="bi bi-plus-circle me-1"></i>
                            إضافة النقاط
                        </button>
                    </div>
                </form>
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
