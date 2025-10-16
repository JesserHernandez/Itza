<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_team');
            $table->boolean('personal_team')->default(false);
            $table->string('address')->nullable();
            $table->string('type', 20)->nullable();
            $table->text('history')->nullable();
            $table->string('city', 20)->nullable();
            $table->string('municipality', 20)->nullable();
            $table->string('phoneNumber', 20)->nullable();
            $table->string('ruc', 20)->nullable();
            $table->boolean('is_active')->default(false);
            $table->string('photo_path', 2048)->nullable();
            $table->foreignId('user_id')->index();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};