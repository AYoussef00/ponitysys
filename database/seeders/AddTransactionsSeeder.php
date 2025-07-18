<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Customer;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AddTransactionsSeeder extends Seeder
{
    public function run(): void
    {
        // الحصول على المستخدم
        $user = User::where('email', 'info@rentluxuria.com')->first();

        if (!$user) {
            $this->command->error('❌ المستخدم info@rentluxuria.com غير موجود');
            return;
        }

        $this->command->info('💰 إضافة معاملات إضافية...');

        // الحصول على العملاء
        $customers = Customer::where('user_id', $user->id)->get();

        if ($customers->isEmpty()) {
            $this->command->error('❌ لا يوجد عملاء للمستخدم');
            return;
        }

        $categories = ['purchase', 'referral', 'review', 'special'];

        foreach ($customers as $customer) {
            // إضافة معاملات ربح نقاط
            for ($i = 0; $i < rand(2, 5); $i++) {
                $points = rand(50, 300);
                Transaction::create([
                    'customer_id' => $customer->id,
                    'points' => $points,
                    'type' => 'earn',
                    'category' => $categories[array_rand($categories)],
                    'description' => 'إيجار سيارة - ' . $this->getRandomDescription(),
                    'reference_id' => 'RENT_' . strtoupper(Str::random(8)),
                    'metadata' => [
                        'rental_days' => rand(1, 7),
                        'car_type' => ['economy', 'luxury', 'suv'][rand(0, 2)],
                        'location' => ['الرياض', 'جدة', 'الدمام'][rand(0, 2)]
                    ],
                    'created_at' => Carbon::now()->subDays(rand(0, 90))
                ]);

                // تحديث رصيد العميل
                $customer->increment('points_balance', $points);
            }

            // إضافة معاملات استبدال نقاط
            if ($customer->points_balance > 200) {
                $redeemPoints = rand(100, min(300, $customer->points_balance));
                Transaction::create([
                    'customer_id' => $customer->id,
                    'points' => $redeemPoints,
                    'type' => 'redeem',
                    'category' => 'special',
                    'description' => 'استبدال مكافأة - خصم على الإيجار',
                    'reference_id' => 'REDEEM_' . strtoupper(Str::random(8)),
                    'metadata' => [
                        'reward_type' => 'discount',
                        'discount_percentage' => 10
                    ],
                    'created_at' => Carbon::now()->subDays(rand(0, 30))
                ]);

                // تحديث رصيد العميل
                $customer->decrement('points_balance', $redeemPoints);
            }
        }

        $this->command->info('✅ تم إضافة المعاملات الإضافية بنجاح!');
    }

    private function getRandomDescription()
    {
        $descriptions = [
            'إيجار سيارة اقتصادية',
            'إيجار سيارة فاخرة',
            'إيجار سيارة SUV',
            'إيجار سيارة رياضية',
            'إيجار سيارة عائلية',
            'إيجار سيارة تجارية'
        ];

        return $descriptions[array_rand($descriptions)];
    }
}
