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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->text('code')->nullable();
            $table->integer('type')->nullable();
            $table->integer('value')->nullable(); //số lượng mã
            $table->integer('min_price')->nullable(); // giá trị mã giảm giá
            $table->integer('min_order')->nullable();// đơn tối hiểu
            $table->integer('max_price')->nullable();//giảm tối đa
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
        Schema::dropIfExists('discounts');
    }
};
