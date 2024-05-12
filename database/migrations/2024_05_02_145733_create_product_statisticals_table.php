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
        Schema::create('product_statisticals', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('color_id');
            $table->date('date')->nullable();
            $table->double('sales')->default(0);
            $table->double('profit')->default(0);
            $table->integer('quantity')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_statisticals');
    }
};
