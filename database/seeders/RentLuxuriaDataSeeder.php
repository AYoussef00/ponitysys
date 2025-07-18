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

class RentLuxuriaDataSeeder extends Seeder
{
    public function run(): void
    {
        // الحصول على المستخدم
        $user = User::where('email', 'info@rentluxuria.com')->first();

        if (!$user) {
            $this->command->error('❌ المستخدم info@rentluxuria.com غير موجود');
            return;
        }

        $this->command->info('🚗 إنشاء بيانات Luxuria Cars Rental...');

        // إنشاء عملاء
        $customers = [];
        $customerNames = [
            'أحمد محمد',
            'فاطمة علي',
            'محمد عبدالله',
            'سارة أحمد',
            'علي حسن',
            'نور الدين',
            'مريم خالد',
            'عبدالرحمن يوسف',
            'ليلى أحمد',
            'حسن محمد'
        ];

        foreach ($customerNames as $index => $name) {
            $customers[] = Customer::create([
                'user_id' => $user->id,
                'name' => $name,
                'phone' => '966500000' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'email' => 'customer' . ($index + 1) . '@luxuria.com',
                'points_balance' => rand(0, 1000),
                'tier' => ['bronze', 'silver', 'gold'][rand(0, 2)],
                'status' => 'active'
            ]);
        }

        $this->command->info('✅ تم إنشاء ' . count($customers) . ' عملاء');

        // إنشاء مكافآت
        $rewards = [];
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

        foreach ($rewardData as $reward) {
            $rewards[] = Reward::create([
                'user_id' => $user->id,
                'title' => $reward['title'],
                'description' => $reward['description'],
                'points_required' => $reward['points_required'],
                'quantity' => $reward['quantity'],
                'status' => 'active',
                'expires_at' => Carbon::now()->addMonths(6)
            ]);
        }

        $this->command->info('✅ تم إنشاء ' . count($rewards) . ' مكافآت');

        // إنشاء معاملات
        $transactionTypes = ['earn', 'redeem'];
        $categories = ['purchase', 'referral', 'review', 'special'];

        foreach ($customers as $customer) {
            // معاملات ربح نقاط
            for ($i = 0; $i < rand(3, 8); $i++) {
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
            }

            // معاملات استبدال نقاط
            if ($customer->points_balance > 200) {
                $redeemPoints = rand(100, min(300, $customer->points_balance));
                Transaction::create([
                    'customer_id' => $customer->id,
                    'points' => $redeemPoints,
                    'type' => 'redeem',
                    'category' => 'reward',
                    'description' => 'استبدال مكافأة - ' . $rewards[array_rand($rewards)]->title,
                    'reference_id' => 'REDEEM_' . strtoupper(Str::random(8)),
                    'metadata' => [
                        'reward_id' => $rewards[array_rand($rewards)]->id,
                        'reward_title' => $rewards[array_rand($rewards)]->title
                    ],
                    'created_at' => Carbon::now()->subDays(rand(0, 30))
                ]);
            }
        }

        $this->command->info('✅ تم إنشاء المعاملات');

        // إنشاء API Keys
        $apiKeys = [
            [
                'name' => 'Luxuria Mobile App',
                'type' => 'production'
            ],
            [
                'name' => 'Luxuria Website',
                'type' => 'production'
            ],
            [
                'name' => 'Luxuria Testing',
                'type' => 'test'
            ]
        ];

        foreach ($apiKeys as $apiKey) {
            ApiKey::create([
                'user_id' => $user->id,
                'name' => $apiKey['name'],
                'key' => 'lux_' . Str::random(32),
                'type' => $apiKey['type']
            ]);
        }

        $this->command->info('✅ تم إنشاء ' . count($apiKeys) . ' مفاتيح API');

        $this->command->info('🎉 تم إنشاء جميع بيانات Luxuria Cars Rental بنجاح!');
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
