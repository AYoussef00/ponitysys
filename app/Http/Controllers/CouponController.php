<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::where('user_id', auth()->id())->latest()->paginate(10);
        return view('coupons.index', compact('coupons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:coupons,code',
            'name' => 'required',
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
            'price' => 'nullable|numeric|min:0',
            'is_paid' => 'boolean',
            'expires_at' => 'nullable|date|after:today',
            'eligibility_start' => 'nullable|date',
            'eligibility_end' => 'nullable|date|after_or_equal:eligibility_start',
            'description' => 'nullable|string'
        ]);

        // إذا لم يتم إدخال كود، سيتم إنشاء كود تلقائي
        if (empty($validated['code'])) {
            $validated['code'] = strtoupper(Str::random(8));
        }

        // إضافة user_id للمستخدم الحالي
        $validated['user_id'] = auth()->id();

        $coupon = Coupon::create($validated);

        return redirect()->route('coupons.index')
            ->with('success', 'تم إضافة الكوبون بنجاح');
    }

    public function update(Request $request, Coupon $coupon)
    {
        // التأكد من أن الكوبون يخص المستخدم الحالي
        if ($coupon->user_id !== auth()->id()) {
            abort(403, 'غير مصرح لك بتعديل هذا الكوبون');
        }

        $validated = $request->validate([
            'code' => 'required|unique:coupons,code,' . $coupon->id,
            'name' => 'required',
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
            'price' => 'nullable|numeric|min:0',
            'is_paid' => 'boolean',
            'expires_at' => 'nullable|date|after:today',
            'eligibility_start' => 'nullable|date',
            'eligibility_end' => 'nullable|date|after_or_equal:eligibility_start',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive,expired'
        ]);

        $coupon->update($validated);

        return redirect()->route('coupons.index')
            ->with('success', 'تم تحديث الكوبون بنجاح');
    }

    public function destroy(Coupon $coupon)
    {
        // التأكد من أن الكوبون يخص المستخدم الحالي
        if ($coupon->user_id !== auth()->id()) {
            abort(403, 'غير مصرح لك بحذف هذا الكوبون');
        }

        $coupon->delete();

        return redirect()->route('coupons.index')
            ->with('success', 'تم حذف الكوبون بنجاح');
    }

    public function toggleStatus(Coupon $coupon)
    {
        // التأكد من أن الكوبون يخص المستخدم الحالي
        if ($coupon->user_id !== auth()->id()) {
            abort(403, 'غير مصرح لك بتغيير حالة هذا الكوبون');
        }

        $coupon->status = $coupon->status === 'active' ? 'inactive' : 'active';
        $coupon->save();

        return redirect()->route('coupons.index')
            ->with('success', 'تم تغيير حالة الكوبون بنجاح');
    }

    // إحصائيات الكوبونات
    public function stats()
    {
        $stats = [
            'total_coupons' => Coupon::where('user_id', auth()->id())->count(),
            'active_coupons' => Coupon::where('user_id', auth()->id())->where('status', 'active')->count(),
            'paid_coupons' => Coupon::where('user_id', auth()->id())->where('is_paid', true)->count(),
            'free_coupons' => Coupon::where('user_id', auth()->id())->where('is_paid', false)->count(),
            'total_revenue' => Coupon::where('user_id', auth()->id())->where('is_paid', true)->sum('price'),
            'expiring_soon' => Coupon::where('user_id', auth()->id())->where('expires_at', '<=', now()->addDays(7))->count()
        ];

        return response()->json($stats);
    }

    // التحقق من صلاحية الكوبون
    public function validateCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|exists:coupons,code',
            'amount' => 'required|numeric|min:0'
        ]);

        $coupon = Coupon::where('code', $request->code)->first();

        if (!$coupon->isValid()) {
            return response()->json([
                'valid' => false,
                'message' => 'الكوبون غير صالح للاستخدام'
            ]);
        }

        // التحقق من أن الكوبون مدفوع
        if ($coupon->isPaid()) {
            return response()->json([
                'valid' => false,
                'message' => 'هذا الكوبون مدفوع ويحتاج إلى شراء بقيمة ' . $coupon->getFormattedPrice(),
                'is_paid' => true,
                'price' => $coupon->price
            ]);
        }

        if ($coupon->minimum_purchase && $request->amount < $coupon->minimum_purchase) {
            return response()->json([
                'valid' => false,
                'message' => "الحد الأدنى للشراء هو {$coupon->minimum_purchase} ريال"
            ]);
        }

        $discount = $coupon->calculateDiscount($request->amount);

        return response()->json([
            'valid' => true,
            'discount' => $discount,
            'is_paid' => false,
            'message' => 'تم تطبيق الكوبون بنجاح'
        ]);
    }
}
