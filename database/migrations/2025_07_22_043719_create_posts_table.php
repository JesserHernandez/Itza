<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 100);
            $table->text('content');
            $table->string('summary');
            $table->date('post_date');
            $table->string('post_status', 20);
            $table->string('photo_path',  2048)->nullable();
            $table->foreignId('author_Id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('team_id')->nullable()->constrained('teams')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};