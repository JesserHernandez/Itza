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
        Schema::create('reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->string('title', 50);
            $table->text('content');
            $table->string('status')->default('En proceso');
            $table->date('revision_date')->nullable();
            $table->boolean('is_Reviewed')->default(false);
            $table->foreignId('reporting_user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('reviewer_user_id')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->nullableMorphs('reported');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
