<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category_attributes', function (Blueprint $table) {
            $table->bigIncrements(column: 'id');
            $table->string('category_name');
            $table->string('label');
            $table->string('data_type');
            $table->string('unit');
            $table->foreignId('category_id')->constrained(table: 'categories')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('category_attributes');
    }
};