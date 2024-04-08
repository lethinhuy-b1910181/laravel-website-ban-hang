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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->text('code')->nullable();
            $table->integer('type')->nullable();
            $table->integer('value')->nullable();
            $table->integer('min_price')->nullable();
            $table->integer('min_order')->nullable();
            $table->integer('max_price')->nullable();
            $table->integer('check_use')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
