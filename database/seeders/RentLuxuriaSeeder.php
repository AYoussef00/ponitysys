<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RentLuxuriaSeeder extends Seeder
{
    public function run(): void
    {
        // التحقق من عدم وجود المستخدم مسبقاً
        if (!User::where('email', 'info@rentluxuria.com')->exists()) {
            User::create([
                'name' => 'Luxuria Cars Rental',
                'email' => 'info@rentluxuria.com',
                'password' => Hash::make('luxuria123'),
                'email_verified_at' => now(),
            ]);

            $this->command->info('✅ تم إنشاء المستخدم info@rentluxuria.com بنجاح');
        } else {
            $this->command->info('⚠️ المستخدم info@rentluxuria.com موجود بالفعل');
        }
    }
}
