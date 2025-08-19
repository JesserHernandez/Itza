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
        Schema::create('addresse_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type', 15);
            $table->string('address', 250);
            $table->string('postal_code', 10);
            $table->string('city', 20);
            $table->string('municipality', 20);
            $table->boolean('is_active')->default(false);
            $table->boolean('is_main')->default(false);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresse_users');
    }
};
