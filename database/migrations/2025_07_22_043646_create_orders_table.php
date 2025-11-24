<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 20)->unique();
            $table->decimal('sub_total', 10, 2);
            $table->decimal('shipping_cost', 10, 2);
            $table->decimal('total', 10, 2);
            $table->string('shipping_number', 20)->unique()->nullable();
            $table->string('estimated_time', 20)->nullable();
            $table->string('warranty', 10)->nullable();
            $table->date('order_date');
            $table->string('order_status', 20)->default('Pendiente');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_addresses_id')->constrained('user_addresses')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('coupon_id')->nullable()->constrained('coupons')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};