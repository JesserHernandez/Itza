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
        Schema::create('teams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->boolean('personal_team')->default(false);
            $table->string('address');
            $table->string('type', 30);
            $table->text('description');
            $table->text('history');
            $table->string('city', 20);
            $table->string('municipality', 20);
            $table->string('phoneNumber', 20);
            $table->string('ruc', 20);
            $table->string('experience', 10);
            $table->string('photo_path', 2048)->nullable();
            $table->foreignId('user_id')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
