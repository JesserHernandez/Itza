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
            $table->string('physical_location', 30)->nullable();
            $table->string('creator');
            $table->date('creation_date');
            $table->decimal('price', 10, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
