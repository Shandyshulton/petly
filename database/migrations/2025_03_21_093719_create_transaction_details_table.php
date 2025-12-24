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
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->integer('total_payment')->nullable(false);
            $table->integer('quantity')->nullable(false);
            $table->foreignId('foreign_product_id')->constrained('products', 'product_id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('transaction_transaction_id')->primary()->constrained('transactions', 'transaction_id')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
    }
};
