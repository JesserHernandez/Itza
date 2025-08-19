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
        Schema::create('payment_method_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('method_name', 100);
            $table->string('provider', 10);
            $table->string('type', 15);
            $table->string('currency_supported', 15)->unique();
            $table->string('card_numberLast4')->nullable();
            $table->string('expiration_month')->nullable();
            $table->string('expiration_year')->nullable();
            $table->boolean('is_main')->nullable();
            $table->boolean('is_active')->nullable();
            $table->boolean('priority')->nullable();
            $table->string('photo_path', 2048)->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_method_users');
    }
};
