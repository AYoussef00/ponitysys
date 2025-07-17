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
        // إحصائيات سريعة
        $stats = [
            'total_points' => 0, // دائماً صفر
            'redeemed_points' => 0, // دائماً صفر
            'active_customers' => 0, // دائماً صفر
            'avg_points' => 0 // دائماً صفر
        ];

        // نسبة التغيير من الشهر السابق
        $lastMonth = Carbon::now()->subMonth();
        $stats['points_change'] = $this->calculateChange(
            Transaction::whereMonth('created_at', $lastMonth->month)->sum('points'),
            Transaction::whereMonth('created_at', Carbon::now()->month)->sum('points')
        );

        $stats['redeemed_change'] = $this->calculateChange(
            Transaction::where('type', 'redeem')
                ->whereMonth('created_at', $lastMonth->month)
                ->sum('points'),
            Transaction::where('type', 'redeem')
                ->whereMonth('created_at', Carbon::now()->month)
                ->sum('points')
        );

        $stats['customers_change'] = $this->calculateChange(
            Customer::where('status', 'active')
                ->whereMonth('created_at', $lastMonth->month)
                ->count(),
            Customer::where('status', 'active')
                ->whereMonth('created_at', Carbon::now()->month)
                ->count()
        );

        // توزيع النقاط خلال السنة
        $yearlyPoints = Transaction::selectRaw('MONTH(created_at) as month, SUM(points) as total_points')
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

        // توزيع فئات النقاط
        $pointsCategories = Transaction::selectRaw('category, SUM(points) as total_points')
            ->whereNotNull('category')
            ->groupBy('category')
            ->get()
            ->map(function ($item) {
                return [
                    'category' => $this->translateCategory($item->category),
                    'points' => $item->total_points
                ];
            });

        // مقارنة النقاط المكتسبة والمستبدلة للأسبوع الحالي
        $weekComparison = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $earned = Transaction::whereDate('created_at', $date)
                ->where('type', 'earn')
                ->sum('points');
            $redeemed = Transaction::whereDate('created_at', $date)
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
