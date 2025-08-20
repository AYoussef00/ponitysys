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
		if (!Schema::hasColumn('coupons', 'user_id')) {
			Schema::table('coupons', function (Blueprint $table) {
				$table->foreignId('user_id')->after('id')->nullable()->constrained()->onDelete('cascade');
			});

			$firstUserId = \App\Models\User::first()->id ?? null;
			if ($firstUserId) {
				\App\Models\Coupon::whereNull('user_id')->update(['user_id' => $firstUserId]);
			}

			Schema::table('coupons', function (Blueprint $table) {
				$table->foreignId('user_id')->nullable(false)->change();
			});
		}
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		if (Schema::hasColumn('coupons', 'user_id')) {
			Schema::table('coupons', function (Blueprint $table) {
				$table->dropForeign(['user_id']);
				$table->dropColumn('user_id');
			});
		}
	}
};


