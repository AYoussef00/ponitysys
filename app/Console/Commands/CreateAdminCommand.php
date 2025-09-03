<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {--force : Force create admin even if exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create default admin user (admin@admin.com / admin123)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = 'admin@admin.com';
        $password = 'admin123';
        $name = 'Super Admin';

        // التحقق من وجود الأدمن
        $existingAdmin = Admin::where('email', $email)->first();

        if ($existingAdmin && !$this->option('force')) {
            $this->warn("⚠️  الأدمن {$email} موجود بالفعل!");
            $this->info("استخدم --force لإعادة إنشاء الأدمن");
            return;
        }

        if ($existingAdmin && $this->option('force')) {
            $existingAdmin->delete();
            $this->info("🗑️  تم حذف الأدمن الموجود");
        }

        // إنشاء الأدمن
        Admin::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info("✅ تم إنشاء الأدمن بنجاح!");
        $this->table(['Field', 'Value'], [
            ['الاسم', $name],
            ['الإيميل', $email],
            ['كلمة المرور', $password],
        ]);
    }
}
