<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Customer;
use Carbon\Carbon;

class TransactionController extends Controller
{
    /**
     * عرض قائمة المعاملات
     */
    public function index()
    {
        // إجمالي المعاملات
        $totalTransactions = Transaction::count();

        // معدل النمو
        $now = Carbon::now();
        $lastMonth = $now->copy()->subMonth();
        $currentMonthCount = Transaction::whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->count();
        $lastMonthCount = Transaction::whereMonth('created_at', $lastMonth->month)->whereYear('created_at', $lastMonth->year)->count();
        $growthRate = $lastMonthCount > 0 ? round((($currentMonthCount - $lastMonthCount) / $lastMonthCount) * 100, 1) : 100;

        // المعاملات المعلقة (لا يوجد عمود status)
        $pendingTransactions = 0;

        // العملاء النشيطين
        $activeCustomers = Customer::where('status', 'active')->count();

        // جلب المعاملات مع بيانات العميل (مع ترقيم)
        $transactions = Transaction::with('customer')->latest()->paginate(10);

        // جلب جميع العملاء لعرضهم في نموذج إضافة معاملة
        $customers = Customer::all();

        return view('transactions.index', compact(
            'totalTransactions',
            'growthRate',
            'pendingTransactions',
            'activeCustomers',
            'transactions',
            'customers'
        ));
    }

    /**
     * عرض نموذج إنشاء معاملة جديدة
     */
    public function create()
    {
        $customers = Customer::all();
        return view('transactions.create', compact('customers'));
    }

    /**
     * حفظ معاملة جديدة
     */
    public function store(Request $request)
    {
        // التحقق من البيانات
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'type' => 'required|in:purchase,redeem',
            'amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        // إنشاء المعاملة
        // Transaction::create($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'تم إضافة المعاملة بنجاح');
    }

    /**
     * عرض تفاصيل معاملة محددة
     */
    public function show($id)
    {
        return view('transactions.show', compact('transaction'));
    }

    /**
     * عرض نموذج تعديل معاملة
     */
    public function edit($id)
    {
        return view('transactions.edit', compact('transaction'));
    }

    /**
     * تحديث معاملة محددة
     */
    public function update(Request $request, $id)
    {
        // التحقق من البيانات
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'type' => 'required|in:purchase,redeem',
            'amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        // تحديث المعاملة
        // $transaction->update($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'تم تحديث المعاملة بنجاح');
    }

    /**
     * حذف معاملة محددة
     */
    public function destroy($id)
    {
        // حذف المعاملة
        // $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'تم حذف المعاملة بنجاح');
    }
}
