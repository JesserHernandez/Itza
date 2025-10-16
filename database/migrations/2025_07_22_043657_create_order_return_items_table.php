<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_return_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('quantity');
            $table->string('product_status', 20);
            $table->boolean('is_returned_physical')->default(false);
            $table->foreignId('order_return_id')->constrained('order_returns')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('order_detail_id')->constrained('order_details')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('order_return_items');
    }
};