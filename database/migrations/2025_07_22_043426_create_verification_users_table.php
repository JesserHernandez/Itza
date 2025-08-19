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
        Schema::create('verification_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status', 15);
            $table->json('submitted_documents');
            $table->string('comments', 200)->nullable();
            $table->foreignId('vendor_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null')->onUpdate('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verification_users');
    }
};
