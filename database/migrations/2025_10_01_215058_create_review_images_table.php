<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('review_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('photo_path', 2048)->nullable();
            $table->morphs('review');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('review_images');
    }
};