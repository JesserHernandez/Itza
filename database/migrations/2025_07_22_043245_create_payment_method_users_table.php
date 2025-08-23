<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_method_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('method_name', 100);
            $table->string('provider', 10);
            $table->string('type', 15);
            $table->string('currency_supported', 15);
            $table->string('card_numberLast4', 20)->unique();
            $table->string('expiration_month', 10);
            $table->string('expiration_year', 10);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_main')->default(false);
            $table->string('photo_path', 2048)->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('payment_method_users');
    }
};