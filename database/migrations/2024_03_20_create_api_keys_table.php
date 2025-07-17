<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Schema::create('api_keys', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('user_id')->constrained()->onDelete('cascade');
        //     $table->string('name');
        //     $table->string('key')->unique();
        //     $table->enum('type', ['test', 'live']);
        //     $table->timestamp('last_used_at')->nullable();
        //     $table->timestamps();
        //     $table->softDeletes();
        // });
    }

    public function down()
    {
        Schema::dropIfExists('api_keys');
    }
};
