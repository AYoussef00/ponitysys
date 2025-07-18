<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // إضافة حقل points_balance
            $table->integer('points_balance')->default(0)->after('email');

            // إضافة حقل tier
            $table->string('tier')->default('bronze')->after('points_balance');
        });

        // نقل البيانات من points إلى points_balance
        DB::statement('UPDATE customers SET points_balance = points');

        // حذف حقل points القديم
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('points');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // إعادة حقل points
            $table->integer('points')->default(0)->after('email');

            // نقل البيانات من points_balance إلى points
            DB::statement('UPDATE customers SET points = points_balance');

            // حذف الحقول الجديدة
            $table->dropColumn(['points_balance', 'tier']);
        });
    }
};
