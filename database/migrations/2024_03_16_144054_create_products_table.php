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
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->text('image');
            $table->integer('category_id');
            $table->integer('brand_id');
            $table->text('short_description');
            $table->longtext('long_description')->nullable();
            $table->text('video_link')->nullable();
            $table->string('sku')->nullable();
            $table->double('offer_price')->nullable();
            $table->integer('view')->default(0);
            $table->string('product_type')->nullable();
            $table->boolean('status');


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
