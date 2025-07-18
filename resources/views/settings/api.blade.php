@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h4 class="mb-0">إعدادات API والتكامل</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active">الإعدادات</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('settings.api.docs.guide') }}" class="btn btn-outline-primary me-2">
            <i class="bi bi-book me-2"></i>
            دليل API
        </a>
        <a href="{{ route('settings.api.docs.download') }}" class="btn btn-primary">
            <i class="bi bi-download me-2"></i>
            تحميل الدليل
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="row g-4">
    <!-- مفاتيح API -->
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-transparent py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">مفاتيح API</h5>
                    <div>
                        <button class="btn btn-outline-secondary me-2" id="testCreateBtn">
                            <i class="bi bi-bug me-2"></i>
                            اختبار إنشاء
                        </button>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createApiKeyModal">
                            <i class="bi bi-plus-lg me-2"></i>
                            إنشاء مفتاح جديد
                        </button>
                    </div>
                </div>
                <p class="text-muted mb-0 mt-2">إدارة مفاتيح API للوصول إلى النظام</p>
                </div>
                <div class="card-body">
                <div id="apiKeysList">
                    @if($apiKeys->count() > 0)
                    <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th width="25%">الاسم</th>
                                        <th width="35%">المفتاح</th>
                                        <th width="15%">النوع</th>
                                        <th width="25%">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($apiKeys as $key)
                                <tr>
                                    <td>{{ $key->name }}</td>
                                    <td>
                                                @php
                                                    $maskedKey = substr($key->key, 0, 8) . '****' . substr($key->key, -4);
                                                @endphp
                                                <div class="d-flex align-items-center">
                                                    <code class="me-2">{{ $maskedKey }}</code>
                                                    <button class="btn btn-sm btn-outline-primary copy-btn" data-key="{{ $key->key }}" title="نسخ المفتاح">
                                                        <i class="bi bi-clipboard"></i>
                                                        <span class="d-none d-sm-inline ms-1">نسخ</span>
                                        </button>
                                                </div>
                                    </td>
                                    <td>
                                                <span class="badge bg-{{ $key->type === 'live' ? 'success' : 'warning' }}">{{ $key->type === 'live' ? 'إنتاج' : 'تجريبي' }}</span>
                                    </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-sm btn-outline-warning regenerate-btn" data-id="{{ $key->id }}" title="إعادة توليد المفتاح">
                                                        <i class="bi bi-arrow-clockwise"></i>
                                                        <span class="d-none d-sm-inline ms-1">إعادة توليد</span>
                                        </button>
                                                    <button class="btn btn-sm btn-outline-danger delete-btn" data-id="{{ $key->id }}" title="حذف المفتاح">
                                                        <i class="bi bi-trash"></i>
                                                        <span class="d-none d-sm-inline ms-1">حذف</span>
                                        </button>
                                                </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="text-muted mb-3">
                                <i class="bi bi-key" style="font-size: 3rem;"></i>
                            </div>
                            <h5 class="text-muted">لا توجد مفاتيح API</h5>
                            <p class="text-muted">قم بإنشاء مفتاح API جديد للبدء في استخدام النظام</p>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createApiKeyModal">
                                <i class="bi bi-plus-lg me-2"></i>
                                إنشاء مفتاح جديد
                            </button>
                        </div>
                    @endif
                </div>
                    </div>
                </div>
            </div>

    <!-- تجربة الـ APIs -->
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-transparent py-3">
                <h5 class="mb-0">تجربة الـ APIs</h5>
                <p class="text-muted mb-0 mt-2">اختبر الـ APIs مباشرة من هنا</p>
                <div class="alert alert-info mt-3 mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>ملاحظة:</strong> سيتم استخدام مفتاح API تجريبي تلقائياً في جميع الاختبارات.
                    <br><small class="text-muted">جميع العمليات تتم في الوقت الفعلي وتُحفظ في قاعدة البيانات</small>
                </div>
                </div>
                <div class="card-body">
                <div class="row g-4">
                    <!-- تسجيل عميل جديد -->
                    <div class="col-md-6">
                        <div class="border rounded p-3">
                            <h6 class="mb-3">تسجيل عميل جديد</h6>
                            <form id="testRegisterForm">
                                <div class="mb-3">
                                    <label class="form-label">اسم العميل</label>
                                    <input type="text" class="form-control" name="name" value="علي أحمد" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">البريد الإلكتروني</label>
                                    <input type="email" class="form-control" name="email" value="ali@example.com" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">رقم الهاتف</label>
                                    <input type="text" class="form-control" name="phone" value="0501111111" required>
                                </div>
                                <button type="submit" class="btn btn-primary">اختبار التسجيل</button>
                            </form>
                            <div id="registerResult" class="mt-3"></div>
                        </div>
                        </div>

                    <!-- إضافة نقاط -->
                    <div class="col-md-6">
                        <div class="border rounded p-3">
                            <h6 class="mb-3">إضافة نقاط للعميل</h6>
                            <form id="testAddPointsForm">
                                <div class="mb-3">
                                    <label class="form-label">معرف العميل</label>
                                    <input type="number" class="form-control" name="customer_id" value="1" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">النقاط</label>
                                    <input type="number" class="form-control" name="points" value="100" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">الوصف</label>
                                    <input type="text" class="form-control" name="description" value="شراء منتج" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">المرجع</label>
                                    <input type="text" class="form-control" name="reference_id" value="ORDER_TEST_001" required>
                                </div>
                                <button type="submit" class="btn btn-primary">اختبار إضافة النقاط</button>
                            </form>
                            <div id="addPointsResult" class="mt-3"></div>
                            </div>
                            </div>

                    <!-- استعلام الرصيد -->
                    <div class="col-md-6">
                        <div class="border rounded p-3">
                            <h6 class="mb-3">استعلام رصيد النقاط</h6>
                            <form id="testBalanceForm">
                                <div class="mb-3">
                                    <label class="form-label">معرف العميل</label>
                                    <input type="number" class="form-control" name="customer_id" value="1" required>
                                </div>
                                <button type="submit" class="btn btn-primary">اختبار الاستعلام</button>
                            </form>
                            <div id="balanceResult" class="mt-3"></div>
                            </div>
                        </div>

                    <!-- عرض المكافآت -->
                    <div class="col-md-6">
                        <div class="border rounded p-3">
                            <h6 class="mb-3">عرض المكافآت المتاحة</h6>
                            <button type="button" class="btn btn-primary" id="testRewardsBtn">اختبار عرض المكافآت</button>
                            <div id="rewardsResult" class="mt-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Webhooks -->
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-transparent py-3">
                <h5 class="mb-0">Webhooks</h5>
                <p class="text-muted mb-0 mt-2">إعداد إشعارات تلقائية للأحداث</p>
            </div>
            <div class="card-body">
                <form id="webhookForm">
                    <div class="mb-3">
                        <label class="form-label">رابط Webhook</label>
                        <input type="url" class="form-control" name="url" value="https://your-app.com/webhook" required>
                        <small class="text-muted">سنرسل إشعارات لهذا الرابط عند حدوث أي تغييرات</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الأحداث</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="events[]" value="customer.created" checked>
                            <label class="form-check-label">تسجيل عميل جديد</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="events[]" value="points.added" checked>
                            <label class="form-check-label">إضافة نقاط</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="events[]" value="reward.redeemed" checked>
                            <label class="form-check-label">استبدال مكافأة</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal إنشاء مفتاح API -->
<div class="modal fade" id="createApiKeyModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-key me-2"></i>
                    إنشاء مفتاح API جديد
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="createApiKeyForm">
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-tag me-1"></i>
                            اسم المفتاح
                        </label>
                        <input type="text" class="form-control" name="name" placeholder="مثال: مفتاح للتطبيق الجديد" minlength="2" maxlength="255" required>
                        <div class="form-text">اختر اسماً وصفياً للمفتاح لسهولة التعرف عليه</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-gear me-1"></i>
                            نوع المفتاح
                        </label>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="type" value="test" checked required>
                            <label class="form-check-label">
                                <span class="badge bg-warning me-2">تجريبي</span>
                                تجريبي (Test) - للاختبار والتطوير
                            </label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="type" value="live" required>
                            <label class="form-check-label">
                                <span class="badge bg-success me-2">إنتاج</span>
                                إنتاج (Live) - للاستخدام الفعلي
                            </label>
                        </div>
                        <div class="form-text">المفاتيح التجريبية آمنة للاختبار، والمفاتيح الإنتاجية للاستخدام الفعلي</div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i>
                    إلغاء
                </button>
                <button type="button" class="btn btn-primary" id="createApiKey">
                    <i class="bi bi-plus-lg me-1"></i>
                    إنشاء
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
console.log('API Settings JavaScript loaded successfully');
console.log('CSRF Token from meta:', $('meta[name="csrf-token"]').attr('content'));

$(document).ready(function() {
    console.log('Document ready - API Settings page');

    // زر اختبار إنشاء مفتاح API
    $('#testCreateBtn').click(function() {
        console.log('Test create button clicked');

        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        console.log('CSRF Token for test:', csrfToken);

        if (!csrfToken) {
            alert('خطأ: لا يوجد CSRF token');
            return;
        }

        const testData = {
            name: 'مفتاح اختبار ' + new Date().getTime(),
            type: 'test',
            _token: csrfToken
        };

        console.log('Sending test data:', testData);

        $.ajax({
            url: '{{ route("settings.api.keys.create") }}',
            type: 'POST',
            data: testData,
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                console.log('Test success:', response);
                alert('نجح الاختبار! تم إنشاء المفتاح: ' + response.data.name);
                location.reload();
            },
            error: function(xhr) {
                console.log('Test error:', xhr);
                alert('فشل الاختبار: ' + (xhr.responseJSON?.message || 'خطأ غير معروف'));
            }
        });
    });

    // إنشاء مفتاح API جديد
    $('#createApiKey').click(function() {
        console.log('Create API Key button clicked');

        // التحقق من صحة البيانات
        const name = $('#createApiKeyForm input[name="name"]').val().trim();
        const type = $('#createApiKeyForm input[name="type"]:checked').val();

                if (!name || name.length < 2) {
            showAlert('يرجى إدخال اسم المفتاح (حرفين على الأقل)', 'error');
            $('#createApiKeyForm input[name="name"]').focus();
            return;
        }

        if (!type || !['test', 'live'].includes(type)) {
            showAlert('يرجى اختيار نوع المفتاح (تجريبي أو إنتاج)', 'error');
            return;
        }

        const formData = new FormData($('#createApiKeyForm')[0]);
        const $btn = $(this);
        const originalText = $btn.text();

        // Debug: طباعة البيانات
        console.log('Form data:', {
            name: name,
            type: type
        });

        // إظهار loading
        $btn.html('<i class="bi bi-hourglass-split"></i> جاري الإنشاء...').prop('disabled', true);

        // إضافة CSRF token إلى FormData
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        if (!csrfToken) {
            showAlert('خطأ في CSRF token - يرجى إعادة تحميل الصفحة', 'error');
            $btn.text(originalText).prop('disabled', false);
            return;
        }
        formData.append('_token', csrfToken);

        // Debug: طباعة CSRF token
        console.log('CSRF Token:', csrfToken);

        $.ajax({
            url: '{{ route("settings.api.keys.create") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            beforeSend: function() {
                console.log('Sending request to:', '{{ route("settings.api.keys.create") }}');
                console.log('CSRF Token:', $('meta[name="csrf-token"]').attr('content'));
            },
                        success: function(response) {
                console.log('Success response:', response);
                if (response.status === 'success' && response.data) {
                    // إغلاق modal
                    $('#createApiKeyModal').modal('hide');

                    // إعادة تعيين النموذج
                    $('#createApiKeyForm')[0].reset();

                    // إضافة المفتاح الجديد إلى الجدول
                    const newKey = response.data;
                    console.log('New key data:', newKey);

                    if (!newKey.key || !newKey.name || !newKey.type) {
                        showAlert('بيانات المفتاح غير مكتملة', 'error');
                        $btn.text(originalText).prop('disabled', false);
                        return;
                    }

                    const maskedKey = newKey.key.substring(0, 8) + '****' + newKey.key.substring(newKey.key.length - 4);
                    const badgeClass = newKey.type === 'live' ? 'success' : 'warning';
                    const badgeText = newKey.type === 'live' ? 'إنتاج' : 'تجريبي';

                    const newRow = `
                        <tr>
                            <td>${newKey.name}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <code class="me-2">${maskedKey}</code>
                                    <button class="btn btn-sm btn-outline-primary copy-btn" data-key="${newKey.key}" title="نسخ المفتاح">
                                        <i class="bi bi-clipboard"></i>
                                        <span class="d-none d-sm-inline ms-1">نسخ</span>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-${badgeClass}">${badgeText}</span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-outline-warning regenerate-btn" data-id="${newKey.id}" title="إعادة توليد المفتاح">
                                        <i class="bi bi-arrow-clockwise"></i>
                                        <span class="d-none d-sm-inline ms-1">إعادة توليد</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger delete-btn" data-id="${newKey.id}" title="حذف المفتاح">
                                        <i class="bi bi-trash"></i>
                                        <span class="d-none d-sm-inline ms-1">حذف</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;

                    // إضافة الصف الجديد إلى الجدول
                    if ($('#apiKeysList tbody').length > 0) {
                        $('#apiKeysList tbody').append(newRow);
                    } else {
                        // إذا لم يكن هناك جدول، إنشاء واحد جديد
                        $('#apiKeysList').html(`
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="25%">الاسم</th>
                                            <th width="35%">المفتاح</th>
                                            <th width="15%">النوع</th>
                                            <th width="25%">الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${newRow}
                                    </tbody>
                                </table>
                            </div>
                        `);
                    }

                    showAlert(`🎉 تم إنشاء المفتاح "${newKey.name}" بنجاح! يمكنك الآن نسخ المفتاح واستخدامه`, 'success');
                } else {
                    console.log('Response status not success:', response);
                    showAlert('حدث خطأ أثناء إنشاء المفتاح', 'error');
                }

                // إعادة تعيين الزر
                $btn.text(originalText).prop('disabled', false);
            },
            error: function(xhr) {
                console.log('Error response:', xhr);
                let errorMsg = 'حدث خطأ أثناء إنشاء المفتاح';

                if (xhr.status === 419) {
                    errorMsg = 'خطأ في CSRF token - يرجى إعادة تحميل الصفحة';
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                } else if (xhr.status === 422) {
                    errorMsg = 'بيانات غير صحيحة - يرجى التحقق من المدخلات';
                }

                console.log('Error message:', errorMsg);
                showAlert(errorMsg, 'error');
                $btn.text(originalText).prop('disabled', false);
            }
        });
    });

        // اختبار تسجيل عميل جديد
    $('#testRegisterForm').submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        // إظهار loading
        $('#registerResult').html('<div class="alert alert-info">جاري الاختبار...</div>');

        // Debug: طباعة البيانات المرسلة
        console.log('Sending registration data:', {
            name: formData.get('name'),
            email: formData.get('email'),
            phone: formData.get('phone')
        });

        // الحصول على مفتاح API تجريبي
        let testApiKey = $('.copy-btn[data-key*="sk_test_"]').first().data('key');

        // إذا لم يتم العثور على مفتاح تجريبي، استخدم مفتاح افتراضي للاختبار
        if (!testApiKey) {
            testApiKey = 'sk_test_1234567890abcdef';
            console.log('Using default test API key');
        }

        // حفظ البيانات للاستخدام في النتيجة
        const customerData = {
            name: formData.get('name'),
            email: formData.get('email'),
            phone: formData.get('phone')
        };

        $.ajax({
            url: 'https://pointsys.clarastars.com/api/v1/customers/register',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'Authorization': 'Bearer ' + testApiKey,
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                console.log('Sending request to:', 'https://pointsys.clarastars.com/api/v1/customers/register');
                console.log('Using API key:', testApiKey);
                console.log('Customer data:', customerData);
            },
            success: function(response) {
                console.log('Registration successful:', response);

                $('#registerResult').html(`
                    <div class="alert alert-success">
                        <h6 class="alert-heading">✅ تم تسجيل العميل بنجاح!</h6>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>معرف العميل:</strong> <span class="badge bg-primary fs-6">${response.data.customer_id}</span></p>
                                <p><strong>اسم العميل:</strong> <span class="fw-bold">${customerData.name}</span></p>
                                <p><strong>البريد الإلكتروني:</strong> ${customerData.email}</p>
                                <p><strong>رقم الهاتف:</strong> ${customerData.phone}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>الرصيد:</strong> <span class="badge bg-success fs-6">${response.data.points_balance} نقطة</span></p>
                                <p><strong>المستوى:</strong> <span class="badge bg-info">${response.data.tier}</span></p>
                                <p><strong>الحالة:</strong> <span class="badge bg-success">نشط</span></p>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">تم استخدام مفتاح API تجريبي تلقائياً</small>
                            <button class="btn btn-sm btn-outline-primary" onclick="copyToClipboard('${response.data.customer_id}')">
                                نسخ معرف العميل
                            </button>
                        </div>
                    </div>
                `);

                // تحديث معرف العميل في نموذج إضافة النقاط
                $('input[name="customer_id"]').val(response.data.customer_id);

                // تحديث معرف العميل في نموذج استعلام الرصيد
                $('#testBalanceForm input[name="customer_id"]').val(response.data.customer_id);

                // إظهار رسالة نجاح إضافية
                showAlert(`🎉 تم تسجيل العميل "${response.data.name}" بنجاح! معرف العميل: ${response.data.customer_id} - يمكنك الآن اختبار إضافة النقاط`, 'success');
            },
            error: function(xhr) {
                console.log('Registration failed:', xhr);
                const errors = xhr.responseJSON?.errors || {};
                let errorMsg = 'حدث خطأ في الاختبار';
                if (xhr.responseJSON?.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                $('#registerResult').html(`
                    <div class="alert alert-danger">
                        <h6 class="alert-heading">❌ فشل في تسجيل العميل</h6>
                        <hr>
                        <p><strong>الخطأ:</strong> ${errorMsg}</p>
                        ${Object.keys(errors).length > 0 ? '<hr><p><strong>تفاصيل الأخطاء:</strong></p><ul>' + Object.values(errors).flat().map(err => `<li>${err}</li>`).join('') + '</ul>' : ''}
                        <hr>
                        <small class="text-muted">يرجى التحقق من البيانات وإعادة المحاولة</small>
                    </div>
                `);

                // إظهار رسالة خطأ إضافية
                showAlert(`❌ فشل في تسجيل العميل: ${errorMsg}`, 'error');
            }
        });
    });

    // اختبار إضافة نقاط
    $('#testAddPointsForm').submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        // إظهار loading
        $('#addPointsResult').html('<div class="alert alert-info">جاري الاختبار...</div>');

        // الحصول على مفتاح API تجريبي
        let testApiKey = $('.copy-btn[data-key*="sk_test_"]').first().data('key');

        // إذا لم يتم العثور على مفتاح تجريبي، استخدم مفتاح افتراضي للاختبار
        if (!testApiKey) {
            testApiKey = 'sk_test_1234567890abcdef';
            console.log('Using default test API key');
        }

        $.ajax({
            url: 'https://pointsys.clarastars.com/api/v1/customers/points/add',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'Authorization': 'Bearer ' + testApiKey,
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#addPointsResult').html(`
                    <div class="alert alert-success">
                        <h6 class="alert-heading">✅ نجح الاختبار!</h6>
                        <hr>
                        <p><strong>معرف العميل:</strong> <span class="badge bg-primary">${response.data.customer_id}</span></p>
                        <p><strong>النقاط المضافة:</strong> <span class="badge bg-success">+${response.data.points_added} نقطة</span></p>
                        <p><strong>الرصيد الجديد:</strong> <span class="badge bg-warning">${response.data.new_balance} نقطة</span></p>
                        <p><strong>معرف المعاملة:</strong> <span class="badge bg-secondary">${response.data.transaction_id}</span></p>
                        <hr>
                        <small class="text-muted">تم استخدام مفتاح API تجريبي تلقائياً</small>
                    </div>
                `);

                // تحديث معرف العميل في نموذج استعلام الرصيد
                $('#testBalanceForm input[name="customer_id"]').val(response.data.customer_id);

                // إظهار رسالة نجاح إضافية
                showAlert('تم إضافة النقاط بنجاح! يمكنك الآن اختبار استعلام الرصيد', 'success');
            },
            error: function(xhr) {
                const errors = xhr.responseJSON?.errors || {};
                let errorMsg = xhr.responseJSON?.message || 'حدث خطأ في الاختبار';
                $('#addPointsResult').html(`
                    <div class="alert alert-danger">
                        <h6 class="alert-heading">❌ فشل الاختبار</h6>
                        <hr>
                        <p>${errorMsg}</p>
                        ${Object.keys(errors).length > 0 ? '<hr><ul>' + Object.values(errors).flat().map(err => `<li>${err}</li>`).join('') + '</ul>' : ''}
                    </div>
                `);
            }
        });
    });

    // اختبار استعلام الرصيد
    $('#testBalanceForm').submit(function(e) {
        e.preventDefault();
        const customerId = $(this).find('[name="customer_id"]').val();

        // إظهار loading
        $('#balanceResult').html('<div class="alert alert-info">جاري الاختبار...</div>');

        // الحصول على مفتاح API تجريبي
        let testApiKey = $('.copy-btn[data-key*="sk_test_"]').first().data('key');

        // إذا لم يتم العثور على مفتاح تجريبي، استخدم مفتاح افتراضي للاختبار
        if (!testApiKey) {
            testApiKey = 'sk_test_1234567890abcdef';
            console.log('Using default test API key');
        }

        $.ajax({
            url: `https://pointsys.clarastars.com/api/v1/customers/${customerId}/balance`,
            type: 'GET',
            headers: {
                'Authorization': 'Bearer ' + testApiKey
            },
            success: function(response) {
                $('#balanceResult').html(`
                    <div class="alert alert-success">
                        <h6 class="alert-heading">✅ نجح الاختبار!</h6>
                        <hr>
                        <p><strong>معرف العميل:</strong> <span class="badge bg-primary">${response.data.customer_id}</span></p>
                        <p><strong>اسم العميل:</strong> ${response.data.name}</p>
                        <p><strong>الرصيد الحالي:</strong> <span class="badge bg-success">${response.data.points_balance} نقطة</span></p>
                        <p><strong>إجمالي المكتسب:</strong> <span class="badge bg-info">${response.data.total_earned} نقطة</span></p>
                        <p><strong>إجمالي المستبدل:</strong> <span class="badge bg-warning">${response.data.total_redeemed} نقطة</span></p>
                        <hr>
                        <small class="text-muted">تم استخدام مفتاح API تجريبي تلقائياً</small>
                    </div>
                `);

                // إظهار رسالة نجاح إضافية
                showAlert('تم استعلام الرصيد بنجاح!', 'success');
            },
            error: function(xhr) {
                const errors = xhr.responseJSON?.errors || {};
                let errorMsg = xhr.responseJSON?.message || 'حدث خطأ في الاختبار';
                $('#balanceResult').html(`
                    <div class="alert alert-danger">
                        <h6 class="alert-heading">❌ فشل الاختبار</h6>
                        <hr>
                        <p>${errorMsg}</p>
                        ${Object.keys(errors).length > 0 ? '<hr><ul>' + Object.values(errors).flat().map(err => `<li>${err}</li>`).join('') + '</ul>' : ''}
                    </div>
                `);
            }
        });
    });

    // اختبار عرض المكافآت
    $('#testRewardsBtn').click(function() {
        // إظهار loading
        $('#rewardsResult').html('<div class="alert alert-info">جاري الاختبار...</div>');

        // الحصول على مفتاح API تجريبي
        let testApiKey = $('.copy-btn[data-key*="sk_test_"]').first().data('key');

        // إذا لم يتم العثور على مفتاح تجريبي، استخدم مفتاح افتراضي للاختبار
        if (!testApiKey) {
            testApiKey = 'sk_test_1234567890abcdef';
            console.log('Using default test API key');
        }

        $.ajax({
            url: 'https://pointsys.clarastars.com/api/v1/rewards',
            type: 'GET',
            headers: {
                'Authorization': 'Bearer ' + testApiKey
            },
            success: function(response) {
                let rewardsHtml = '<div class="alert alert-success"><h6 class="alert-heading">✅ نجح الاختبار!</h6><hr>';
                if (response.data.length > 0) {
                    rewardsHtml += '<p><strong>المكافآت المتاحة:</strong></p><ul>';
                    response.data.forEach(function(reward) {
                        rewardsHtml += `<li><strong>${reward.title}</strong> - <span class="badge bg-primary">${reward.points_required} نقطة</span><br><small class="text-muted">${reward.description}</small></li>`;
                    });
                    rewardsHtml += '</ul>';
                } else {
                    rewardsHtml += '<p>لا توجد مكافآت متاحة</p>';
                }
                rewardsHtml += '<hr><small class="text-muted">تم استخدام مفتاح API تجريبي تلقائياً</small></div>';
                $('#rewardsResult').html(rewardsHtml);

                // إظهار رسالة نجاح إضافية
                showAlert('تم عرض المكافآت بنجاح!', 'success');
            },
            error: function(xhr) {
                const errors = xhr.responseJSON?.errors || {};
                let errorMsg = xhr.responseJSON?.message || 'حدث خطأ في الاختبار';
                $('#rewardsResult').html(`
                    <div class="alert alert-danger">
                        <h6 class="alert-heading">❌ فشل الاختبار</h6>
                        <hr>
                        <p>${errorMsg}</p>
                        ${Object.keys(errors).length > 0 ? '<hr><ul>' + Object.values(errors).flat().map(err => `<li>${err}</li>`).join('') + '</ul>' : ''}
                    </div>
                `);
            }
        });
    });

    // نسخ المفتاح
    $(document).on('click', '.copy-btn', function() {
        const key = $(this).data('key');
        const $btn = $(this);
        const originalHtml = $btn.html();

        // إظهار loading على الزر
        $btn.html('<i class="bi bi-check-lg"></i>').prop('disabled', true);

        navigator.clipboard.writeText(key).then(() => {
            showAlert('تم نسخ المفتاح بنجاح', 'success');

            // إعادة الزر إلى حالته الأصلية بعد ثانيتين
            setTimeout(() => {
                $btn.html(originalHtml).prop('disabled', false);
            }, 2000);
        }).catch(() => {
            showAlert('فشل في نسخ المفتاح', 'error');
            $btn.html(originalHtml).prop('disabled', false);
        });
    });

        // إعادة توليد المفتاح - طريقة مبسطة
    $(document).on('click', '.regenerate-btn', function() {
        const keyId = $(this).data('id');
        const keyName = $(this).closest('tr').find('td:first').text();

        if (confirm(`هل أنت متأكد من إعادة توليد المفتاح "${keyName}"؟\n\n⚠️ تحذير: سيتم إنشاء مفتاح جديد وسيتوقف المفتاح القديم عن العمل!`)) {
            const $btn = $(this);
            const originalHtml = $btn.html();
            $btn.html('<i class="bi bi-hourglass-split"></i>').prop('disabled', true);

            $.ajax({
                url: `/settings/api/keys/${keyId}/regenerate`,
                type: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        // تحديث المفتاح في الجدول
                        const $row = $btn.closest('tr');
                        const newKey = response.data.key;
                        const maskedKey = newKey.substring(0, 8) + '****' + newKey.substring(newKey.length - 4);

                        $row.find('td:nth-child(2) code').text(maskedKey);
                        $row.find('.copy-btn').data('key', newKey);

                        $btn.html(originalHtml).prop('disabled', false);
                        showAlert(`تم إعادة توليد المفتاح "${keyName}" بنجاح`, 'success');
                    } else {
                        showAlert('حدث خطأ أثناء إعادة توليد المفتاح', 'error');
                        $btn.html(originalHtml).prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'حدث خطأ أثناء إعادة توليد المفتاح';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    showAlert(errorMsg, 'error');
                    $btn.html(originalHtml).prop('disabled', false);
                }
            });
        }
    });

            // حذف المفتاح - طريقة مبسطة
    $(document).on('click', '.delete-btn', function() {
        const keyId = $(this).data('id');
        const keyName = $(this).closest('tr').find('td:first').text();

        if (confirm(`هل أنت متأكد من حذف المفتاح "${keyName}"؟\n\n⚠️ تحذير: لا يمكن التراجع عن هذا الإجراء!`)) {
            const $btn = $(this);
            const originalHtml = $btn.html();
            $btn.html('<i class="bi bi-hourglass-split"></i>').prop('disabled', true);

            $.ajax({
                url: `/settings/api/keys/${keyId}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        $btn.closest('tr').fadeOut(300, function() {
                            $(this).remove();
                            if ($('#apiKeysList tbody tr').length === 0) {
                                $('#apiKeysList').html(`
                                    <div class="text-center py-5">
                                        <div class="text-muted mb-3">
                                            <i class="bi bi-key" style="font-size: 3rem;"></i>
                                        </div>
                                        <h5 class="text-muted">لا توجد مفاتيح API</h5>
                                        <p class="text-muted">قم بإنشاء مفتاح API جديد للبدء في استخدام النظام</p>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createApiKeyModal">
                                            <i class="bi bi-plus-lg me-2"></i>
                                            إنشاء مفتاح جديد
                                        </button>
                                    </div>
                                `);
                            }
                        });
                        showAlert(`تم حذف المفتاح "${keyName}" بنجاح`, 'success');
                    } else {
                        showAlert('حدث خطأ أثناء حذف المفتاح', 'error');
                        $btn.html(originalHtml).prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'حدث خطأ أثناء حذف المفتاح';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    showAlert(errorMsg, 'error');
                    $btn.html(originalHtml).prop('disabled', false);
                }
            });
        }
    });



    function showAlert(message, type) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const icon = type === 'success' ? 'bi-check-circle' : 'bi-exclamation-triangle';
        const alertHtml = `<div class="alert ${alertClass} alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999; min-width: 300px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" role="alert">
            <i class="bi ${icon} me-2"></i>
            <strong>${type === 'success' ? 'نجح!' : 'خطأ!'}</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>`;

        $('body').append(alertHtml);
        setTimeout(() => {
            $('.alert').alert('close');
        }, 4000);
    }

    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            showAlert('تم نسخ معرف العميل بنجاح', 'success');
        }).catch(() => {
            showAlert('فشل في نسخ معرف العميل', 'error');
        });
    }
});
</script>
@endpush


