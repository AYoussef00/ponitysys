<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use Illuminate\Support\Facades\Validator;

class CouponApiController extends Controller
{
    /**
     * عرض جميع الكوبونات للمستخدم
     */
    public function index(Request $request)
    {
        $apiKeyUserId = $request->get('api_key_user_id');

        $coupons = Coupon::where('user_id', $apiKeyUserId)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return response()->json([
            'status' => 'success',
            'data' => $coupons->map(function($coupon) {
                return [
                    'id' => $coupon->id,
                    'code' => $coupon->code,
                    'name' => $coupon->name,
                    'description' => $coupon->description,
                    'type' => $coupon->type,
                    'value' => $coupon->value,
                    'points_required' => $coupon->points_required,
                    'usage_limit' => $coupon->usage_limit,
                    'used_count' => $coupon->used_count,
                    'minimum_purchase' => $coupon->minimum_purchase,
                    'starts_at' => $coupon->starts_at,
                    'expires_at' => $coupon->expires_at,
                    'eligibility_start' => $coupon->eligibility_start,
                    'eligibility_end' => $coupon->eligibility_end,
                    'status' => $coupon->status,
                    'is_valid' => $coupon->isValid(),
                    'created_at' => $coupon->created_at,
                    'updated_at' => $coupon->updated_at
                ];
            })
        ]);
    }

    /**
     * عرض كوبون محدد
     */
    public function show(Request $request, $id)
    {
        $apiKeyUserId = $request->get('api_key_user_id');

        $coupon = Coupon::where('id', $id)
                       ->where('user_id', $apiKeyUserId)
                       ->first();

        if (!$coupon) {
            return response()->json([
                'status' => 'error',
                'message' => 'الكوبون غير موجود'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'name' => $coupon->name,
                'description' => $coupon->description,
                'type' => $coupon->type,
                'value' => $coupon->value,
                'points_required' => $coupon->points_required,
                'usage_limit' => $coupon->usage_limit,
                'used_count' => $coupon->used_count,
                'minimum_purchase' => $coupon->minimum_purchase,
                'starts_at' => $coupon->starts_at,
                'expires_at' => $coupon->expires_at,
                'eligibility_start' => $coupon->eligibility_start,
                'eligibility_end' => $coupon->eligibility_end,
                'status' => $coupon->status,
                'is_valid' => $coupon->isValid(),
                'created_at' => $coupon->created_at,
                'updated_at' => $coupon->updated_at
            ]
        ]);
    }

    /**
     * إنشاء كوبون جديد
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|unique:coupons,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
            'points_required' => 'nullable|integer|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'minimum_purchase' => 'nullable|numeric|min:0',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:starts_at',
            'eligibility_start' => 'nullable|date',
            'eligibility_end' => 'nullable|date|after:eligibility_start',
            'status' => 'required|in:active,inactive,expired'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'بيانات غير صحيحة',
                'errors' => $validator->errors()
            ], 422);
        }

        $apiKeyUserId = $request->get('api_key_user_id');

        $coupon = Coupon::create([
            'user_id' => $apiKeyUserId,
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'value' => $request->value,
            'points_required' => $request->points_required ?? 0,
            'usage_limit' => $request->usage_limit,
            'minimum_purchase' => $request->minimum_purchase,
            'starts_at' => $request->starts_at,
            'expires_at' => $request->expires_at,
            'eligibility_start' => $request->eligibility_start,
            'eligibility_end' => $request->eligibility_end,
            'status' => $request->status
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'تم إنشاء الكوبون بنجاح',
            'data' => [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'name' => $coupon->name,
                'is_valid' => $coupon->isValid()
            ]
        ], 201);
    }

    /**
     * تحديث كوبون
     */
    public function update(Request $request, $id)
    {
        $apiKeyUserId = $request->get('api_key_user_id');

        $coupon = Coupon::where('id', $id)
                       ->where('user_id', $apiKeyUserId)
                       ->first();

        if (!$coupon) {
            return response()->json([
                'status' => 'error',
                'message' => 'الكوبون غير موجود'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'code' => 'sometimes|required|string|unique:coupons,code,' . $id,
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'sometimes|required|in:fixed,percentage',
            'value' => 'sometimes|required|numeric|min:0',
            'points_required' => 'nullable|integer|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'minimum_purchase' => 'nullable|numeric|min:0',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:starts_at',
            'eligibility_start' => 'nullable|date',
            'eligibility_end' => 'nullable|date|after:eligibility_start',
            'status' => 'sometimes|required|in:active,inactive,expired'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'بيانات غير صحيحة',
                'errors' => $validator->errors()
            ], 422);
        }

        $coupon->update($request->only([
            'code', 'name', 'description', 'type', 'value', 'points_required',
            'usage_limit', 'minimum_purchase', 'starts_at', 'expires_at',
            'eligibility_start', 'eligibility_end', 'status'
        ]));

        return response()->json([
            'status' => 'success',
            'message' => 'تم تحديث الكوبون بنجاح',
            'data' => [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'name' => $coupon->name,
                'is_valid' => $coupon->isValid()
            ]
        ]);
    }

    /**
     * حذف كوبون
     */
    public function destroy(Request $request, $id)
    {
        $apiKeyUserId = $request->get('api_key_user_id');

        $coupon = Coupon::where('id', $id)
                       ->where('user_id', $apiKeyUserId)
                       ->first();

        if (!$coupon) {
            return response()->json([
                'status' => 'error',
                'message' => 'الكوبون غير موجود'
            ], 404);
        }

        $coupon->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'تم حذف الكوبون بنجاح'
        ]);
    }

    /**
     * التحقق من صلاحية كوبون
     */
    public function validateCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string',
            'amount' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'بيانات غير صحيحة',
                'errors' => $validator->errors()
            ], 422);
        }

        $apiKeyUserId = $request->get('api_key_user_id');

        $coupon = Coupon::where('code', $request->code)
                       ->where('user_id', $apiKeyUserId)
                       ->first();

        if (!$coupon) {
            return response()->json([
                'status' => 'error',
                'message' => 'الكوبون غير موجود'
            ], 404);
        }

        if (!$coupon->isValid()) {
            return response()->json([
                'status' => 'error',
                'message' => 'الكوبون غير صالح'
            ], 400);
        }

        // التحقق من الحد الأدنى للشراء
        if ($coupon->minimum_purchase && $request->amount < $coupon->minimum_purchase) {
            return response()->json([
                'status' => 'error',
                'message' => 'المبلغ أقل من الحد الأدنى المطلوب: ' . $coupon->minimum_purchase
            ], 400);
        }

        $discount = $coupon->calculateDiscount($request->amount);

        return response()->json([
            'status' => 'success',
            'message' => 'الكوبون صالح',
            'data' => [
                'coupon_id' => $coupon->id,
                'code' => $coupon->code,
                'name' => $coupon->name,
                'type' => $coupon->type,
                'value' => $coupon->value,
                'discount_amount' => $discount,
                'original_amount' => $request->amount,
                'final_amount' => $request->amount - $discount
            ]
        ]);
    }
}
