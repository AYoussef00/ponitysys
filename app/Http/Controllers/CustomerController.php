<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index()
    {
        // جلب العملاء الخاصة بالمستخدم (الشركة) الحالي فقط
        $customers = Customer::where('user_id', auth()->id())
                            ->orderBy('created_at', 'desc')
                            ->get();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|string|unique:customers,phone',
            'tier' => 'required|in:bronze,silver,gold'
        ]);

        Customer::create([
            'user_id' => auth()->id(), // ربط العميل بالمستخدم (الشركة) الحالي
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'tier' => $request->tier,
            'points_balance' => 0,
            'status' => 'active'
        ]);

        return redirect()->route('customers.index')->with('success', 'تم إضافة العميل بنجاح');
    }

    public function show($id)
    {
        return view('customers.show');
    }

    public function edit($id)
    {
        return view('customers.edit');
    }

    public function update(Request $request, $id)
    {
        // سيتم إضافة المنطق لاحقاً
        return redirect()->route('customers.index');
    }

    public function destroy($id)
    {
        try {
            // التحقق من أن العميل يخص المستخدم (الشركة) الحالي
            $customer = Customer::where('id', $id)
                               ->where('user_id', auth()->id())
                               ->firstOrFail();
            $customerName = $customer->name;
            $customer->delete();

            if (request()->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'تم حذف العميل بنجاح',
                    'customer_name' => $customerName
                ]);
            }

            return redirect()->route('customers.index')->with('success', 'تم حذف العميل بنجاح');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'حدث خطأ أثناء حذف العميل'
                ], 500);
            }

            return redirect()->route('customers.index')->with('error', 'حدث خطأ أثناء حذف العميل');
        }
    }

    /**
     * إضافة نقاط للعميل
     */
    public function addPoints(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'points' => 'required|integer|min:1',
            'reason' => 'required|string',
            'description' => 'required|string|max:500',
            'reference_id' => 'required|string|unique:transactions,reference_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'بيانات غير صحيحة',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // التحقق من أن العميل يخص المستخدم (الشركة) الحالي
            $customer = Customer::where('id', $request->customer_id)
                               ->where('user_id', auth()->id())
                               ->firstOrFail();

            // إضافة النقاط للعميل
            $customer->points_balance += $request->points;
            $customer->save();

            // تسجيل المعاملة
            $transaction = Transaction::create([
                'customer_id' => $customer->id,
                'points' => $request->points,
                'type' => 'earn',
                'description' => $request->description,
                'reference_id' => $request->reference_id,
                'metadata' => [
                    'reason' => $request->reason,
                    'added_by' => auth()->id()
                ]
            ]);

            return response()->json([
                'status' => 'success',
                'message' => "تم إضافة {$request->points} نقطة للعميل {$customer->name} بنجاح",
                'data' => [
                    'customer_id' => $customer->id,
                    'new_balance' => $customer->points_balance,
                    'transaction_id' => $transaction->id
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء إضافة النقاط'
            ], 500);
        }
    }
}
