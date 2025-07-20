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
        Schema::table('coupons', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->nullable()->after('value')->comment('سعر الكوبون للشراء');
            $table->boolean('is_paid')->default(false)->after('price')->comment('هل الكوبون مدفوع');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn(['price', 'is_paid']);
        });
    }
};
