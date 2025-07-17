@extends('layouts.app')

@section('header')
إعدادات API
@endsection

@section('content')
<div class="container-fluid" dir="rtl">
    <div class="row">
        <!-- القائمة الجانبية -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">إعدادات API</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="#api-keys" class="list-group-item list-group-item-action">مفاتيح API</a>
                    <a href="#webhooks" class="list-group-item list-group-item-action">Webhooks</a>
                    <a href="{{ route('settings.api.docs.download') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <i class="fas fa-download"></i>
                        تحميل الدليل الإرشادي
                    </a>
                </div>
            </div>
        </div>

        <!-- المحتوى الرئيسي -->
        <div class="col-md-9">
            <!-- قسم مفاتيح API -->
            <div class="card mb-4" id="api-keys">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">مفاتيح API</h5>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#createApiKeyModal">
                            <i class="fas fa-plus ml-1"></i>
                            إنشاء مفتاح جديد
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>الاسم</th>
                                    <th>المفتاح</th>
                                    <th>النوع</th>
                                    <th>آخر استخدام</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($apiKeys as $key)
                                <tr>
                                    <td>{{ $key->name }}</td>
                                    <td>
                                        <code class="api-key">{{ $key->key }}</code>
                                        <button class="btn btn-sm btn-link copy-btn" data-key="{{ $key->key }}">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $key->type === 'live' ? 'success' : 'warning' }}">
                                            {{ $key->type }}
                                        </span>
                                    </td>
                                    <td>{{ $key->last_used_at ? $key->last_used_at->diffForHumans() : 'لم يستخدم بعد' }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning regenerate-btn" data-id="{{ $key->id }}">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $key->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- قسم Webhooks -->
            <div class="card" id="webhooks">
                <div class="card-header">
                    <h5 class="mb-0">إعدادات Webhook</h5>
                </div>
                <div class="card-body">
                    <form id="webhookForm">
                        <div class="form-group">
                            <label for="webhookUrl">رابط Webhook</label>
                            <input type="url" class="form-control" id="webhookUrl" name="url"
                                   value="{{ $webhooks->first()->url ?? '' }}" required>
                            <small class="form-text text-muted">
                                سيتم إرسال الإشعارات إلى هذا الرابط عند حدوث الأحداث المحددة
                            </small>
                        </div>

                        <div class="form-group">
                            <label>الأحداث</label>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="event_customer_created"
                                       name="events[]" value="customer.created">
                                <label class="custom-control-label" for="event_customer_created">
                                    تسجيل عميل جديد
                                </label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="event_points_added"
                                       name="events[]" value="points.added">
                                <label class="custom-control-label" for="event_points_added">
                                    إضافة نقاط
                                </label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="event_reward_redeemed"
                                       name="events[]" value="reward.redeemed">
                                <label class="custom-control-label" for="event_reward_redeemed">
                                    استبدال مكافأة
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                            <button type="button" class="btn btn-secondary" id="testWebhook">
                                اختبار Webhook
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal إنشاء مفتاح API -->
<div class="modal fade" id="createApiKeyModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إنشاء مفتاح API جديد</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createApiKeyForm">
                    <div class="form-group">
                        <label for="keyName">اسم المفتاح</label>
                        <input type="text" class="form-control" id="keyName" required>
                    </div>
                    <div class="form-group">
                        <label>نوع المفتاح</label>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="typeTest" name="keyType" value="test"
                                   class="custom-control-input" checked>
                            <label class="custom-control-label" for="typeTest">تجريبي</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="typeLive" name="keyType" value="live"
                                   class="custom-control-input">
                            <label class="custom-control-label" for="typeLive">إنتاج</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" id="createApiKey">إنشاء</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // نسخ مفتاح API
    $('.copy-btn').click(function() {
        const key = $(this).data('key');
        navigator.clipboard.writeText(key).then(() => {
            alert('تم نسخ المفتاح بنجاح');
        });
    });

    // إنشاء مفتاح API جديد
    $('#createApiKey').click(function() {
        const name = $('#keyName').val();
        const type = $('input[name="keyType"]:checked').val();

        $.post('{{ route("settings.api.keys.create") }}', {
            name: name,
            type: type,
            _token: '{{ csrf_token() }}'
        })
        .done(function(response) {
            location.reload();
        })
        .fail(function(xhr) {
            alert('حدث خطأ أثناء إنشاء المفتاح');
        });
    });

    // إعادة توليد مفتاح API
    $('.regenerate-btn').click(function() {
        if (!confirm('هل أنت متأكد من إعادة توليد هذا المفتاح؟')) return;

        const keyId = $(this).data('id');
        $.ajax({
            url: `/settings/api/keys/${keyId}/regenerate`,
            type: 'PUT',
            data: {_token: '{{ csrf_token() }}'}
        })
        .done(function() {
            location.reload();
        })
        .fail(function() {
            alert('حدث خطأ أثناء إعادة توليد المفتاح');
        });
    });

    // حذف مفتاح API
    $('.delete-btn').click(function() {
        if (!confirm('هل أنت متأكد من حذف هذا المفتاح؟')) return;

        const keyId = $(this).data('id');
        $.ajax({
            url: `/settings/api/keys/${keyId}`,
            type: 'DELETE',
            data: {_token: '{{ csrf_token() }}'}
        })
        .done(function() {
            location.reload();
        })
        .fail(function() {
            alert('حدث خطأ أثناء حذف المفتاح');
        });
    });

    // حفظ إعدادات Webhook
    $('#webhookForm').submit(function(e) {
        e.preventDefault();
        const url = $('#webhookUrl').val();
        const events = $('input[name="events[]"]:checked').map(function() {
            return $(this).val();
        }).get();

        $.post('{{ route("settings.api.webhooks.update") }}', {
            url: url,
            events: events,
            _token: '{{ csrf_token() }}'
        })
        .done(function() {
            alert('تم حفظ الإعدادات بنجاح');
        })
        .fail(function() {
            alert('حدث خطأ أثناء حفظ الإعدادات');
        });
    });

    // اختبار Webhook
    $('#testWebhook').click(function() {
        const webhookId = $(this).data('webhook-id');
        $.post(`/settings/api/webhooks/${webhookId}/test`, {
            _token: '{{ csrf_token() }}'
        })
        .done(function() {
            alert('تم إرسال طلب الاختبار بنجاح');
        })
        .fail(function() {
            alert('حدث خطأ أثناء اختبار Webhook');
        });
    });
});
</script>
@endpush
