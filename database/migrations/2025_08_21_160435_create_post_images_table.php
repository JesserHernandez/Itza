<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('photo_path', 2048)->nullable();
            $table->boolean('is_main')->default(false);
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('post_images');
    }
};