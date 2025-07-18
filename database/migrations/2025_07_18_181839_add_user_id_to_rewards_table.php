<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // التحقق من وجود العمود أولاً
        if (!Schema::hasColumn('rewards', 'user_id')) {
            Schema::table('rewards', function (Blueprint $table) {
                $table->foreignId('user_id')->after('id')->nullable()->constrained()->onDelete('cascade');
            });

            // تحديث البيانات الموجودة لتستخدم المستخدم الأول
            $firstUserId = \App\Models\User::first()->id ?? 1;
            \App\Models\Reward::whereNull('user_id')->update(['user_id' => $firstUserId]);

            // جعل العمود مطلوب بعد تحديث البيانات
            Schema::table('rewards', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable(false)->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rewards', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
