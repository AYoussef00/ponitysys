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

class SafeServerSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🛡️ تشغيل Safe Server Seeder...');

        try {
            // 1. إنشاء أو تحديث المستخدم الإداري
            $admin = User::updateOrCreate(
                ['email' => 'admin@admin.com'],
                [
                    'name' => 'Admin',
                    'password' => Hash::make('admin123'),
                    'email_verified_at' => now(),
                ]
            );
            $this->command->info('✅ تم إنشاء/تحديث المستخدم الإداري');

            // 2. إنشاء أو تحديث مستخدم Luxuria
            $luxuria = User::updateOrCreate(
                ['email' => 'info@rentluxuria.com'],
                [
                    'name' => 'Luxuria Cars Rental',
                    'password' => Hash::make('luxuria123'),
                    'email_verified_at' => now(),
                ]
            );
            $this->command->info('✅ تم إنشاء/تحديث مستخدم Luxuria');

            // 3. إنشاء عملاء للمستخدم الإداري (إذا لم يكونوا موجودين)
            $this->createAdminCustomers($admin);

            // 4. إنشاء عملاء لـ Luxuria (إذا لم يكونوا موجودين)
            $this->createLuxuriaCustomers($luxuria);

            // 5. إنشاء مكافآت لـ Luxuria (إذا لم تكن موجودة)
            $this->createLuxuriaRewards($luxuria);

            // 6. إنشاء مفاتيح API (إذا لم تكن موجودة)
            $this->createApiKeys($admin, $luxuria);

            $this->command->info('🎉 تم تشغيل Safe Server Seeder بنجاح!');
            $this->command->info('📧 Admin: admin@admin.com / admin123');
            $this->command->info('📧 Luxuria: info@rentluxuria.com / luxuria123');

        } catch (\Exception $e) {
            $this->command->error('❌ خطأ في Safe Server Seeder: ' . $e->getMessage());
        }
    }

    private function createAdminCustomers($admin)
    {
        $customerData = [
            ['name' => 'عميل 1', 'phone' => '966500000001', 'email' => 'customer1@admin.com'],
            ['name' => 'عميل 2', 'phone' => '966500000002', 'email' => 'customer2@admin.com'],
            ['name' => 'عميل 3', 'phone' => '966500000003', 'email' => 'customer3@admin.com'],
        ];

        $createdCount = 0;
        foreach ($customerData as $data) {
            $customer = Customer::firstOrCreate(
                [
                    'user_id' => $admin->id,
                    'phone' => $data['phone']
                ],
                [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'points_balance' => rand(0, 500),
                    'tier' => ['bronze', 'silver', 'gold'][rand(0, 2)],
                    'status' => 'active'
                ]
            );

            if ($customer->wasRecentlyCreated) {
                $createdCount++;
            }
        }

        if ($createdCount > 0) {
            $this->command->info("✅ تم إنشاء {$createdCount} عملاء للمستخدم الإداري");
        }
    }

    private function createLuxuriaCustomers($luxuria)
    {
        $customerData = [
            ['name' => 'أحمد محمد', 'phone' => '966500000101', 'email' => 'customer1@luxuria.com'],
            ['name' => 'فاطمة علي', 'phone' => '966500000102', 'email' => 'customer2@luxuria.com'],
            ['name' => 'محمد عبدالله', 'phone' => '966500000103', 'email' => 'customer3@luxuria.com'],
            ['name' => 'سارة أحمد', 'phone' => '966500000104', 'email' => 'customer4@luxuria.com'],
            ['name' => 'علي حسن', 'phone' => '966500000105', 'email' => 'customer5@luxuria.com'],
        ];

        $createdCount = 0;
        foreach ($customerData as $data) {
            $customer = Customer::firstOrCreate(
                [
                    'user_id' => $luxuria->id,
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

        if ($createdCount > 0) {
            $this->command->info("✅ تم إنشاء {$createdCount} عملاء لـ Luxuria");
        }
    }

    private function createLuxuriaRewards($luxuria)
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
            ]
        ];

        $createdCount = 0;
        foreach ($rewardData as $data) {
            $reward = Reward::firstOrCreate(
                [
                    'user_id' => $luxuria->id,
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

        if ($createdCount > 0) {
            $this->command->info("✅ تم إنشاء {$createdCount} مكافآت لـ Luxuria");
        }
    }

    private function createApiKeys($admin, $luxuria)
    {
        $apiKeyData = [
            ['user_id' => $admin->id, 'name' => 'Admin API', 'type' => 'production'],
            ['user_id' => $luxuria->id, 'name' => 'Luxuria Mobile App', 'type' => 'production'],
            ['user_id' => $luxuria->id, 'name' => 'Luxuria Website', 'type' => 'production'],
        ];

        $createdCount = 0;
        foreach ($apiKeyData as $data) {
            $apiKey = ApiKey::firstOrCreate(
                [
                    'user_id' => $data['user_id'],
                    'name' => $data['name']
                ],
                [
                    'key' => 'key_' . Str::random(32),
                    'type' => $data['type']
                ]
            );

            if ($apiKey->wasRecentlyCreated) {
                $createdCount++;
            }
        }

        if ($createdCount > 0) {
            $this->command->info("✅ تم إنشاء {$createdCount} مفاتيح API");
        }
    }
}
