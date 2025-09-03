<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class DefaultAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // التحقق من عدم وجود الأدمن مسبقاً
        if (!Admin::where('email', 'admin@admin.com')->exists()) {
            Admin::create([
                'name' => 'Super Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin123'),
            ]);

            $this->command->info('✅ تم إنشاء الأدمن admin@admin.com بنجاح');
        } else {
            $this->command->info('⚠️ الأدمن admin@admin.com موجود بالفعل');
        }
    }
}
