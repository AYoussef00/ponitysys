<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Customer;
use App\Models\Reward;
use App\Models\Transaction;
use App\Models\ApiKey;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class CompleteRentLuxuriaSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🚗 إنشاء حساب Luxuria Cars Rental كاملاً...');

        // 1. إنشاء أو تحديث المستخدم
        $user = User::updateOrCreate(
            ['email' => 'info@rentluxuria.com'],
            [
                'name' => 'Luxuria Cars Rental',
                'password' => Hash::make('luxuria123'),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ تم إنشاء/تحديث المستخدم: ' . $user->name);

        // 2. إنشاء عملاء (إذا لم يكونوا موجودين)
        $this->createCustomers($user);

        // 3. إنشاء مكافآت (إذا لم تكن موجودة)
        $this->createRewards($user);

        // 4. إنشاء معاملات إضافية
        $this->createTransactions($user);

        // 5. إنشاء مفاتيح API (إذا لم تكن موجودة)
        $this->createApiKeys($user);

        $this->command->info('🎉 تم إنشاء حساب Luxuria Cars Rental بنجاح!');
        $this->command->info('📧 البريد الإلكتروني: info@rentluxuria.com');
        $this->command->info('🔑 كلمة المرور: luxuria123');
    }

    private function createCustomers($user)
    {
        $customerData = [
            ['name' => 'أحمد محمد', 'phone' => '966500000001', 'email' => 'customer1@luxuria.com'],
            ['name' => 'فاطمة علي', 'phone' => '966500000002', 'email' => 'customer2@luxuria.com'],
            ['name' => 'محمد عبدالله', 'phone' => '966500000003', 'email' => 'customer3@luxuria.com'],
            ['name' => 'سارة أحمد', 'phone' => '966500000004', 'email' => 'customer4@luxuria.com'],
            ['name' => 'علي حسن', 'phone' => '966500000005', 'email' => 'customer5@luxuria.com'],
            ['name' => 'نور الدين', 'phone' => '966500000006', 'email' => 'customer6@luxuria.com'],
            ['name' => 'مريم خالد', 'phone' => '966500000007', 'email' => 'customer7@luxuria.com'],
            ['name' => 'عبدالرحمن يوسف', 'phone' => '966500000008', 'email' => 'customer8@luxuria.com'],
            ['name' => 'ليلى أحمد', 'phone' => '966500000009', 'email' => 'customer9@luxuria.com'],
            ['name' => 'حسن محمد', 'phone' => '966500000010', 'email' => 'customer10@luxuria.com'],
        ];

        $createdCount = 0;
        foreach ($customerData as $data) {
            $customer = Customer::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'phone' => $data['phone']
                ],
                [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'points_balance' => rand(0, 1000),
                    'tier' => ['bronze', 'silver', 'gold'][rand(0, 2)],
                    'status' => 'active'
                ]
            );

            if ($customer->wasRecentlyCreated) {
                $createdCount++;
            }
        }

        $this->command->info("✅ تم إنشاء {$createdCount} عملاء جدد");
    }

    private function createRewards($user)
    {
        $rewardData = [
            [
                'title' => 'خصم 10% على الإيجار',
                'description' => 'خصم 10% على إيجار أي سيارة لمدة يوم واحد',
                'points_required' => 500,
                'quantity' => 50
            ],
            [
                'title' => 'إيجار مجاني ليوم واحد',
                'description' => 'إيجار مجاني لسيارة اقتصادية ليوم واحد',
                'points_required' => 1000,
                'quantity' => 20
            ],
            [
                'title' => 'ترقية مجانية',
                'description' => 'ترقية مجانية من سيارة اقتصادية إلى فاخرة',
                'points_required' => 750,
                'quantity' => 30
            ],
            [
                'title' => 'خصم 20% على الإيجار الأسبوعي',
                'description' => 'خصم 20% على إيجار أي سيارة لمدة أسبوع',
                'points_required' => 1500,
                'quantity' => 15
            ],
            [
                'title' => 'إضافة سائق مجاني',
                'description' => 'إضافة سائق محترف مجاناً لمدة يوم واحد',
                'points_required' => 800,
                'quantity' => 25
            ]
        ];

        $createdCount = 0;
        foreach ($rewardData as $data) {
            $reward = Reward::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'title' => $data['title']
                ],
                [
                    'description' => $data['description'],
                    'points_required' => $data['points_required'],
                    'quantity' => $data['quantity'],
                    'status' => 'active',
                    'expires_at' => Carbon::now()->addMonths(6)
                ]
            );

            if ($reward->wasRecentlyCreated) {
                $createdCount++;
            }
        }

        $this->command->info("✅ تم إنشاء {$createdCount} مكافآت جديدة");
    }

    private function createTransactions($user)
    {
        $customers = Customer::where('user_id', $user->id)->get();
        $categories = ['purchase', 'referral', 'review', 'special'];

        $createdCount = 0;
        foreach ($customers as $customer) {
            // إضافة معاملات ربح نقاط
            for ($i = 0; $i < rand(2, 4); $i++) {
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

                $customer->increment('points_balance', $points);
                $createdCount++;
            }
        }

        $this->command->info("✅ تم إنشاء {$createdCount} معاملات جديدة");
    }

    private function createApiKeys($user)
    {
        $apiKeyData = [
            ['name' => 'Luxuria Mobile App', 'type' => 'production'],
            ['name' => 'Luxuria Website', 'type' => 'production'],
            ['name' => 'Luxuria Testing', 'type' => 'test']
        ];

        $createdCount = 0;
        foreach ($apiKeyData as $data) {
            $apiKey = ApiKey::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'name' => $data['name']
                ],
                [
                    'key' => 'lux_' . Str::random(32),
                    'type' => $data['type']
                ]
            );

            if ($apiKey->wasRecentlyCreated) {
                $createdCount++;
            }
        }

        $this->command->info("✅ تم إنشاء {$createdCount} مفاتيح API جديدة");
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
