<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // التحقق من عدم وجود المستخدم مسبقاً
        if (!User::where('email', 'admin@admin.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]);

            $this->command->info('✅ تم إنشاء المستخدم admin@admin.com بنجاح');
        } else {
            $this->command->info('⚠️ المستخدم admin@admin.com موجود بالفعل');
        }
    }
}
