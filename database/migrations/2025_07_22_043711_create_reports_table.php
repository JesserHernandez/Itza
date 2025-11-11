<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 50);
            $table->string('type', 20);
            $table->text('content');
            $table->string('status', 20)->default('En proceso');
            $table->date('report_date')->nullable();
            $table->date('revision_date')->nullable();
            $table->boolean('is_Reviewed')->default(false);
            $table->foreignId('reporting_user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('reviewer_user_id')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->morphs('reported');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};