<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transport_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type', 20);
            $table->string('name', 20);
            $table->text('description');
            $table->string('company_name', 30);
            $table->string('schedule', 100);
            $table->string('email', 50)->unique();
            $table->string('price_range', 30);
            $table->string('phone_number', 20);
            $table->boolean('is_active')->default(true);
            $table->string('photo_path', 2048)->nullable();
            $table->foreignId('creative_circuit_id')->constrained('creative_circuits')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('transport_services');
    }
};