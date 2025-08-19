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
        Schema::create('reward_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('points');
            $table->date('points_expiration');
            $table->string('reason', 200)->nullable();
            $table->foreignId('user_Id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reward_users');
    }
};
