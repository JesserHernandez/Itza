<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('photo_path', 2048)->nullable();
            $table->boolean('is_main')->default(false);
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('team_images');
    }
};
