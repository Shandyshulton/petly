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
        Schema::create('carts', function (Blueprint $table) {
            $table->unsignedBigInteger('cart_id', true)->primary();
            $table->foreignId('customer_user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->foreignId('foreign_product_id')->constrained('products', 'product_id');
            $table->integer('quantity')->default(1);
            $table->integer('total_price')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
