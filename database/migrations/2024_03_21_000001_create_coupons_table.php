<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['fixed', 'percentage']); // نوع الخصم: مبلغ ثابت أو نسبة
            $table->decimal('value', 10, 2); // قيمة الخصم
            $table->integer('points_required')->default(0); // النقاط المطلوبة للحصول على الكوبون
            $table->integer('usage_limit')->nullable(); // عدد مرات الاستخدام المسموح به
            $table->integer('used_count')->default(0); // عدد مرات الاستخدام الفعلي
            $table->decimal('minimum_purchase', 10, 2)->nullable(); // الحد الأدنى للشراء
            $table->timestamp('starts_at')->nullable(); // تاريخ بداية الصلاحية
            $table->timestamp('expires_at')->nullable(); // تاريخ نهاية الصلاحية
            $table->timestamp('eligibility_start')->nullable(); // تاريخ بداية الاستحقاق
            $table->timestamp('eligibility_end')->nullable(); // تاريخ نهاية الاستحقاق
            $table->enum('status', ['active', 'inactive', 'expired'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
