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
        Schema::create('order_totals', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');
            $table->integer('user_id');
            $table->integer('shipper_id')->nullable();
            $table->double('sub_total');
            $table->double('amount');
            $table->integer('product_qty');
            $table->string('payment_method');
            $table->integer('payment_status');
            $table->text('order_address');
            $table->text('order_coupon')->nullable();
            $table->text('shipping_method')->nullable();
            $table->text('coupon')->nullable();
            $table->integer('shipper_status')->nullable();
            $table->integer('order_status');
            $table->integer('order_review')->default(0);
            $table->text('fail_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_totals');
    }
};
