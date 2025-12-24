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
            $table->unsignedBigInteger('product_id', true)->primary();
            $table->string('product_name');
            $table->text('product_desc');
            $table->foreignId('product_product_type_id')->constrained('product_types', 'product_type_id')->default(1);
            $table->foreignId('pet_pet_types_id')->constrained('pet_types', 'pet_type_id')->default(1);
            $table->string('product_image');
            $table->integer('product_stock');
            $table->integer('product_rating');
            $table->integer('product_price');
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
