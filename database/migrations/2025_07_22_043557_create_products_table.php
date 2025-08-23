<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 20)->unique();
            $table->string('name', 30);
            $table->string('technique')->nullable();
            $table->string('cultural_origin')->nullable();
            $table->string('dimensions', 50);
            $table->string('color', 20);
            $table->string('shape', 20);
            $table->string('history');
            $table->string('status', 20);
            $table->string('physical_location', 20)->nullable();
            $table->string('creator', 100);
            $table->date('creation_date');
            $table->decimal('price', 10, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};