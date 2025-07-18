<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RewardApiController extends Controller
{
    /**
     * عرض المكافآت المتاحة
     */
    public function index(Request $request)
    {
        // الحصول على user_id من مفتاح API
        $apiKeyUserId = $request->get('api_key_user_id');

        $rewards = Reward::where('status', 'active')
                        ->where('user_id', $apiKeyUserId)
                        ->get();

        return response()->json([
            'status' => 'success',
            'data' => $rewards->map(function($reward) {
                return [
                    'id' => $reward->id,
                    'title' => $reward->title,
                    'description' => $reward->description,
                    'points_required' => $reward->points_required,
                    'status' => $reward->status
                ];
            })
        ]);
    }

    /**
     * استبدال نقاط بمكافأة
     */
    public function redeem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'reward_id' => 'required|exists:rewards,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'بيانات غير صحيحة',
                'errors' => $validator->errors()
            ], 422);
        }

        // التحقق من أن العميل ينتمي لنفس المستخدم الذي يملك مفتاح API
        $apiKeyUserId = $request->get('api_key_user_id');
        $customer = Customer::where('id', $request->customer_id)
                           ->where('user_id', $apiKeyUserId)
                           ->first();

        if (!$customer) {
            return response()->json([
                'status' => 'error',
                'message' => 'العميل غير موجود أو لا يمكن الوصول إليه'
            ], 404);
        }
        $reward = Reward::findOrFail($request->reward_id);

        // التحقق من كفاية النقاط
        if ($customer->points_balance < $reward->points_required) {
            return response()->json([
                'status' => 'error',
                'message' => 'رصيد النقاط غير كافٍ'
            ], 400);
        }

        // خصم النقاط وتسجيل الاستبدال
        $customer->points_balance -= $reward->points_required;
        $customer->save();

        // تسجيل المعاملة
        $transaction = $customer->transactions()->create([
            'points' => -$reward->points_required,
            'type' => 'redeem',
            'description' => 'استبدال: ' . $reward->title,
            'reference_id' => 'REDEEM_' . time()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'تم استبدال النقاط بنجاح',
            'data' => [
                'transaction_id' => $transaction->id,
                'points_spent' => $reward->points_required,
                'new_balance' => $customer->points_balance,
                'reward' => [
                    'id' => $reward->id,
                    'title' => $reward->title,
                    'description' => $reward->description
                ]
            ]
        ]);
    }
}
