<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Transaction;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            AdminSeeder::class,
            RentLuxuriaSeeder::class,
        ]);

        // إنشاء 10 عملاء
        $customers = [];
        for ($i = 1; $i <= 10; $i++) {
            $customers[] = Customer::create([
                'name' => "عميل $i",
                'phone' => "966500000{$i}00",
                'email' => "customer{$i}@example.com",
                'points' => 0,
                'status' => 'active'
            ]);
        }

        // إنشاء معاملات للعملاء
        $categories = ['purchase', 'referral', 'review', 'special'];
        $now = Carbon::now();

        foreach ($customers as $customer) {
            // معاملات الشهر الحالي
            for ($i = 0; $i < rand(3, 7); $i++) {
                $points = rand(50, 500);
                Transaction::create([
                    'customer_id' => $customer->id,
                    'points' => $points,
                    'type' => 'earn',
                    'category' => $categories[array_rand($categories)],
                    'description' => 'معاملة تجريبية',
                    'created_at' => $now->copy()->subDays(rand(0, 29))
                ]);

                // تحديث نقاط العميل
                $customer->increment('points', $points);
            }

            // معاملات استبدال
            if ($customer->points > 200) {
                $redeemPoints = rand(100, min(200, $customer->points));
                Transaction::create([
                    'customer_id' => $customer->id,
                    'points' => $redeemPoints,
                    'type' => 'redeem',
                    'description' => 'استبدال نقاط',
                    'created_at' => $now->copy()->subDays(rand(0, 29))
                ]);

                // تحديث نقاط العميل
                $customer->decrement('points', $redeemPoints);
            }

            // معاملات الشهر السابق
            for ($i = 0; $i < rand(2, 5); $i++) {
                $points = rand(50, 500);
                Transaction::create([
                    'customer_id' => $customer->id,
                    'points' => $points,
                    'type' => 'earn',
                    'category' => $categories[array_rand($categories)],
                    'description' => 'معاملة تجريبية',
                    'created_at' => $now->copy()->subMonth()->subDays(rand(0, 29))
                ]);
            }
        }
    }
}
