@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h4 class="mb-0">المعاملات</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active">المعاملات</li>
            </ol>
        </nav>
    </div>
    <div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
            <i class="bi bi-plus-lg"></i>
            إضافة معاملة
        </button>
    </div>
</div>
@endsection

@section('content')
<div class="row g-4">
    <!-- إحصائيات المعاملات -->
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
                        <h6 class="mb-1">إجمالي المعاملات</h6>
                        <h3 class="mb-0">{{ number_format($totalTransactions) }}</h3>
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
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">معدل النمو</h6>
                        <h3 class="mb-0">{{ ($growthRate >= 0 ? '+' : '') . $growthRate . '%' }}</h3>
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
                            <i class="bi bi-clock-history"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">معاملات معلقة</h6>
                        <h3 class="mb-0">{{ number_format($pendingTransactions) }}</h3>
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
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">العملاء النشطين</h6>
                        <h3 class="mb-0">{{ number_format($activeCustomers) }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- جدول المعاملات -->
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-transparent py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">قائمة المعاملات</h5>
                    <div class="d-flex gap-2">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" class="form-control border-0 bg-light" placeholder="بحث...">
                        </div>
                        <button class="btn btn-light" title="تصدير">
                            <i class="bi bi-download"></i>
                        </button>
                        <button class="btn btn-light" title="تحديث">
                            <i class="bi bi-arrow-clockwise"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>العميل</th>
                                <th>نوع المعاملة</th>
                                <th>المبلغ</th>
                                <th>النقاط</th>
                                <th>التاريخ</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($transaction->customer->name) }}&background=4e73df&color=ffffff"
                                             class="rounded-circle me-2" width="32" height="32" alt="Customer Avatar">
                                        <div>
                                            <h6 class="mb-0">{{ $transaction->customer->name }}</h6>
                                            <small class="text-muted">#CUS-{{ str_pad($transaction->customer->id, 3, '0', STR_PAD_LEFT) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $transaction->type == 'purchase' ? 'شراء' : 'استبدال نقاط' }}</td>
                                <td>{{ $transaction->amount }} ر.س</td>
                                <td>{{ $transaction->points }}</td>
                                <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <span class="badge bg-success">مكتملة</span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-sm btn-light">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-sm btn-light">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('هل أنت متأكد من حذف المعاملة؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light text-danger">
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

<!-- Modal إضافة معاملة -->
<div class="modal fade" id="addTransactionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة معاملة جديدة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('transactions.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">العميل</label>
                        <select name="customer_id" class="form-select" required>
                            <option value="" disabled selected>اختر العميل</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">نوع المعاملة</label>
                        <select name="type" class="form-select" required>
                            <option selected disabled>اختر نوع المعاملة</option>
                            <option value="purchase">شراء</option>
                            <option value="redeem">استبدال نقاط</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">المبلغ</label>
                        <div class="input-group">
                            <input type="number" name="amount" class="form-control" placeholder="أدخل المبلغ" required>
                            <span class="input-group-text">ر.س</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">النقاط</label>
                        <div class="input-group">
                            <input type="number" name="points" class="form-control" placeholder="أدخل النقاط" required>
                            <span class="input-group-text">نقاط</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ملاحظات</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="أدخل أي ملاحظات إضافية"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
