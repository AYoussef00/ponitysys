<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\RedemptionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AnalyticController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ApiSettingsController;
use App\Http\Controllers\ApiDocsController;


// توجيه الصفحة الرئيسية إلى تسجيل الدخول
Route::redirect('/', '/login');

// مسارات المصادقة - للزوار فقط
Route::middleware('guest')->group(function () {
    // تسجيل الدخول
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // التسجيل
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
});

// المسارات المحمية - للمستخدمين المسجلين فقط
Route::middleware('auth')->group(function () {
    // لوحة التحكم
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // إدارة العملاء
    Route::prefix('customers')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])
            ->name('customers.index');
        Route::get('/create', [CustomerController::class, 'create'])
            ->name('customers.create');
        Route::post('/', [CustomerController::class, 'store'])
            ->name('customers.store');
        Route::get('/{customer}', [CustomerController::class, 'show'])
            ->name('customers.show');
        Route::get('/{customer}/edit', [CustomerController::class, 'edit'])
            ->name('customers.edit');
        Route::put('/{customer}', [CustomerController::class, 'update'])
            ->name('customers.update');
        Route::delete('/{customer}', [CustomerController::class, 'destroy'])
            ->name('customers.destroy');
    });

    // إدارة المكافآت
    Route::prefix('rewards')->group(function () {
        Route::get('/', [RewardController::class, 'index'])
            ->name('rewards.index');
        Route::get('/create', [RewardController::class, 'create'])
            ->name('rewards.create');
        Route::post('/', [RewardController::class, 'store'])
            ->name('rewards.store');
        Route::get('/{reward}', [RewardController::class, 'show'])
            ->name('rewards.show');
        Route::get('/{reward}/edit', [RewardController::class, 'edit'])
            ->name('rewards.edit');
        Route::put('/{reward}', [RewardController::class, 'update'])
            ->name('rewards.update');
        Route::delete('/{reward}', [RewardController::class, 'destroy'])
            ->name('rewards.destroy');
    });

    // إدارة الاستبدالات
    Route::prefix('redemptions')->group(function () {
        Route::get('/', [RedemptionController::class, 'index'])
            ->name('redemptions.index');
        Route::get('/create', [RedemptionController::class, 'create'])
            ->name('redemptions.create');
        Route::post('/', [RedemptionController::class, 'store'])
            ->name('redemptions.store');
        Route::get('/{redemption}', [RedemptionController::class, 'show'])
            ->name('redemptions.show');
    });

    // الإعدادات
    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingController::class, 'index'])
            ->name('settings.index');
        Route::get('/mobile-integration', [SettingController::class, 'mobileIntegration'])
            ->name('settings.mobile-integration');

        // تحديث الإعدادات
        Route::put('/company', [SettingController::class, 'updateCompany'])
            ->name('settings.company.update');
        Route::put('/points', [SettingController::class, 'updatePoints'])
            ->name('settings.points.update');

        // مسارات API Settings
        Route::get('/api', [ApiSettingsController::class, 'index'])->name('settings.api');
        Route::get('/api/docs', [ApiSettingsController::class, 'docs'])->name('settings.api.docs');
        Route::get('/settings/api/docs/download', [ApiDocsController::class, 'downloadPdf'])->name('settings.api.docs.download');
        Route::post('/api/keys', [ApiSettingsController::class, 'createApiKey'])->name('settings.api.keys.create');
        Route::put('/api/keys/{apiKey}/regenerate', [ApiSettingsController::class, 'regenerateApiKey'])->name('settings.api.keys.regenerate');
        Route::delete('/api/keys/{apiKey}', [ApiSettingsController::class, 'deleteApiKey'])->name('settings.api.keys.delete');
        Route::post('/api/webhooks', [ApiSettingsController::class, 'updateWebhook'])->name('settings.api.webhooks.update');
        Route::post('/api/webhooks/{webhook}/test', [ApiSettingsController::class, 'testWebhook'])->name('settings.api.webhooks.test');
    });

    // التحليلات
    Route::prefix('analytics')->group(function () {
        Route::get('/', [AnalyticController::class, 'index'])
            ->name('analytics.index');
    });

    // التقارير
    Route::prefix('reports')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/sales', [ReportController::class, 'sales'])->name('reports.sales');
        Route::get('/customers', [ReportController::class, 'customers'])->name('reports.customers');
        Route::get('/points', [ReportController::class, 'points'])->name('reports.points');
        Route::get('/redemptions', [ReportController::class, 'redemptions'])->name('reports.redemptions');
        Route::post('/export', [ReportController::class, 'export'])->name('reports.export');
    });

    // تسجيل الخروج
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // المعاملات
    Route::resource('transactions', TransactionController::class);

    // مسارات الكوبونات
    Route::resource('coupons', CouponController::class);
    Route::post('coupons/{coupon}/toggle', [CouponController::class, 'toggleStatus'])->name('coupons.toggle');
    Route::post('coupons/validate', [CouponController::class, 'validateCoupon'])->name('coupons.validate');
});
