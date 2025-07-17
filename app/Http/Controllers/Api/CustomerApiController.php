<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerApiController extends Controller
{
    /**
     * تسجيل عميل جديد
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:customers,phone',
            'email' => 'required|email|unique:customers,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'بيانات غير صحيحة',
                'errors' => $validator->errors()
            ], 422);
        }

        $customer = Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'points_balance' => 0,
            'tier' => 'bronze', // المستوى الافتراضي
        ]);

        // إطلاق حدث تسجيل عميل جديد للـ webhook
        event(new \App\Events\CustomerRegistered($customer));

        return response()->json([
            'status' => 'success',
            'message' => 'تم تسجيل العميل بنجاح',
            'data' => [
                'customer_id' => $customer->id,
                'name' => $customer->name,
                'points_balance' => $customer->points_balance,
                'tier' => $customer->tier
            ]
        ], 201);
    }

    /**
     * إضافة نقاط للعميل
     */
    public function addPoints(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'points' => 'required|integer|min:1',
            'description' => 'required|string',
            'reference_id' => 'required|string|unique:transactions,reference_id', // رقم مرجعي للعملية
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'بيانات غير صحيحة',
                'errors' => $validator->errors()
            ], 422);
        }

        $customer = Customer::findOrFail($request->customer_id);

        // إضافة النقاط وتسجيل المعاملة
        $customer->points_balance += $request->points;
        $customer->save();

        $transaction = $customer->transactions()->create([
            'points' => $request->points,
            'type' => 'credit',
            'description' => $request->description,
            'reference_id' => $request->reference_id
        ]);

        // إطلاق حدث إضافة نقاط للـ webhook
        event(new \App\Events\PointsAdded($customer, $transaction));

        return response()->json([
            'status' => 'success',
            'message' => 'تم إضافة النقاط بنجاح',
            'data' => [
                'customer_id' => $customer->id,
                'points_added' => $request->points,
                'new_balance' => $customer->points_balance,
                'transaction_id' => $transaction->id
            ]
        ]);
    }

    /**
     * الاستعلام عن رصيد النقاط
     */
    public function getBalance($customerId)
    {
        $customer = Customer::findOrFail($customerId);

        return response()->json([
            'status' => 'success',
            'data' => [
                'customer_id' => $customer->id,
                'name' => $customer->name,
                'points_balance' => $customer->points_balance,
                'tier' => $customer->tier,
                'total_earned' => $customer->transactions()->where('type', 'credit')->sum('points'),
                'total_redeemed' => $customer->transactions()->where('type', 'debit')->sum('points')
            ]
        ]);
    }

    /**
     * استبدال نقاط بمكافأة
     */
    public function redeemPoints(Request $request)
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

        $customer = Customer::findOrFail($request->customer_id);
        $reward = \App\Models\Reward::findOrFail($request->reward_id);

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

        $redemption = $customer->redemptions()->create([
            'reward_id' => $reward->id,
            'points_spent' => $reward->points_required,
            'status' => 'pending'
        ]);

        // إطلاق حدث استبدال نقاط للـ webhook
        event(new \App\Events\RewardRedeemed($customer, $redemption));

        return response()->json([
            'status' => 'success',
            'message' => 'تم استبدال النقاط بنجاح',
            'data' => [
                'redemption_id' => $redemption->id,
                'points_spent' => $reward->points_required,
                'new_balance' => $customer->points_balance,
                'reward' => [
                    'id' => $reward->id,
                    'name' => $reward->name,
                    'description' => $reward->description
                ]
            ]
        ]);
    }
}
