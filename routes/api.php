<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerApiController;
use App\Http\Controllers\Api\RewardApiController;
use App\Http\Controllers\Api\CouponApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// مسارات API للعملاء (محمية بمفتاح API)
Route::prefix('v1')->middleware('api.key')->group(function () {
    // تسجيل عميل جديد
    Route::post('/customers/register', [CustomerApiController::class, 'register']);

    // إضافة نقاط للعميل
    Route::post('/customers/points/add', [CustomerApiController::class, 'addPoints']);

    // الاستعلام عن رصيد النقاط
    Route::get('/customers/{customerId}/balance', [CustomerApiController::class, 'getBalance']);

    // استبدال النقاط بمكافأة
    Route::post('/customers/points/redeem', [CustomerApiController::class, 'redeemPoints']);

    // عرض المكافآت المتاحة
    Route::get('/rewards', [RewardApiController::class, 'index']);

    // استبدال نقاط بمكافأة
    Route::post('/rewards/redeem', [RewardApiController::class, 'redeem']);

    // مسارات الكوبونات
    Route::get('/coupons', [CouponApiController::class, 'index']);
    Route::get('/coupons/{id}', [CouponApiController::class, 'show']);
    Route::post('/coupons', [CouponApiController::class, 'store']);
    Route::put('/coupons/{id}', [CouponApiController::class, 'update']);
    Route::delete('/coupons/{id}', [CouponApiController::class, 'destroy']);
    Route::post('/coupons/validate', [CouponApiController::class, 'validateCoupon']);
});
