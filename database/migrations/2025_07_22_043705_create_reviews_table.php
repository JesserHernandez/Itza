<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 100);
            $table->integer('rating');
            $table->text('comment');
            $table->date('review_date');
            $table->integer('like_count')->default(0);
            $table->integer('dis_like_count')->default(0);
            $table->boolean('is_verified_purchase')->default(false);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->morphs('reviewed');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};