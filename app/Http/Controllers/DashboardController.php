<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\Reward;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * عرض لوحة التحكم
     */
    public function index()
    {
        // إحصائيات سريعة - محسوبة من قاعدة البيانات للمستخدم (الشركة) الحالي فقط
        $stats = [
            'total_points' => Customer::where('user_id', auth()->id())->sum('points_balance'), // إجمالي النقاط الحالية
            'redeemed_points' => abs(Transaction::whereHas('customer', function($q) { $q->where('user_id', auth()->id()); })->where('type', 'redeem')->sum('points')), // النقاط المستبدلة
            'active_customers' => Customer::where('user_id', auth()->id())->where('status', 'active')->count(), // العملاء النشطين
            'avg_points' => round(Customer::where('user_id', auth()->id())->where('status', 'active')->avg('points_balance') ?? 0, 1), // متوسط النقاط
            'total_customers' => Customer::where('user_id', auth()->id())->count(), // إجمالي العملاء
            'total_transactions' => Transaction::whereHas('customer', function($q) { $q->where('user_id', auth()->id()); })->count(), // إجمالي المعاملات
            'earned_points' => Transaction::whereHas('customer', function($q) { $q->where('user_id', auth()->id()); })->where('type', 'earn')->sum('points'), // النقاط المكتسبة
            'rewards_count' => Reward::where('user_id', auth()->id())->where('status', 'active')->count() // عدد المكافآت النشطة
        ];

        // نسبة التغيير من الشهر السابق للمستخدم (الشركة) الحالي فقط
        $lastMonth = Carbon::now()->subMonth();
        $stats['points_change'] = $this->calculateChange(
            Transaction::whereHas('customer', function($q) { $q->where('user_id', auth()->id()); })->whereMonth('created_at', $lastMonth->month)->sum('points'),
            Transaction::whereHas('customer', function($q) { $q->where('user_id', auth()->id()); })->whereMonth('created_at', Carbon::now()->month)->sum('points')
        );

        $stats['redeemed_change'] = $this->calculateChange(
            Transaction::whereHas('customer', function($q) { $q->where('user_id', auth()->id()); })->where('type', 'redeem')
                ->whereMonth('created_at', $lastMonth->month)
                ->sum('points'),
            Transaction::whereHas('customer', function($q) { $q->where('user_id', auth()->id()); })->where('type', 'redeem')
                ->whereMonth('created_at', Carbon::now()->month)
                ->sum('points')
        );

        $stats['customers_change'] = $this->calculateChange(
            Customer::where('user_id', auth()->id())->where('status', 'active')
                ->whereMonth('created_at', $lastMonth->month)
                ->count(),
            Customer::where('user_id', auth()->id())->where('status', 'active')
                ->whereMonth('created_at', Carbon::now()->month)
                ->count()
        );

        // توزيع النقاط خلال السنة للمستخدم (الشركة) الحالي فقط
        $yearlyPoints = Transaction::whereHas('customer', function($q) { $q->where('user_id', auth()->id()); })
            ->selectRaw('MONTH(created_at) as month, SUM(points) as total_points')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total_points', 'month')
            ->toArray();

        // تعبئة الأشهر الناقصة بأصفار
        $monthlyPoints = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyPoints[$i] = $yearlyPoints[$i] ?? 0;
        }

        // توزيع فئات النقاط للمستخدم (الشركة) الحالي فقط
        $pointsCategories = Transaction::whereHas('customer', function($q) { $q->where('user_id', auth()->id()); })
            ->selectRaw('category, SUM(points) as total_points')
            ->whereNotNull('category')
            ->groupBy('category')
            ->get()
            ->map(function ($item) {
                return [
                    'category' => $this->translateCategory($item->category),
                    'points' => $item->total_points
                ];
            });

        // مقارنة النقاط المكتسبة والمستبدلة للأسبوع الحالي للمستخدم (الشركة) الحالي فقط
        $weekComparison = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $earned = Transaction::whereHas('customer', function($q) { $q->where('user_id', auth()->id()); })
                ->whereDate('created_at', $date)
                ->where('type', 'earn')
                ->sum('points');
            $redeemed = Transaction::whereHas('customer', function($q) { $q->where('user_id', auth()->id()); })
                ->whereDate('created_at', $date)
                ->where('type', 'redeem')
                ->sum('points');

            $weekComparison[] = [
                'date' => $date->format('Y-m-d'),
                'day_name' => $this->getArabicDayName($date->dayOfWeek),
                'earned' => $earned,
                'redeemed' => $redeemed
            ];
        }

        return view('dashboard', compact('stats', 'monthlyPoints', 'pointsCategories', 'weekComparison'));
    }

    private function calculateChange($old, $new)
    {
        if ($old == 0) return 100;
        return round((($new - $old) / $old) * 100, 1);
    }

    private function translateCategory($category)
    {
        return match($category) {
            'purchase' => 'مشتريات',
            'referral' => 'إحالات',
            'review' => 'مراجعات',
            'special' => 'مناسبات خاصة',
            default => $category
        };
    }

    private function getArabicDayName($dayNumber)
    {
        return match($dayNumber) {
            0 => 'الأحد',
            1 => 'الإثنين',
            2 => 'الثلاثاء',
            3 => 'الأربعاء',
            4 => 'الخميس',
            5 => 'الجمعة',
            6 => 'السبت',
        };
    }
}
