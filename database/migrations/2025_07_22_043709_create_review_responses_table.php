<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('review_responses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('comment');
            $table->date('review_date');
            $table->integer('like_count')->default(0);
            $table->integer('dis_like_count')->default(0);
            $table->boolean('is_verified_purchase')->default(false);
            $table->foreignId('parent_response_id')->nullable()->constrained('review_responses')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('review_id')->constrained('reviews')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('review_responses');
    }
};