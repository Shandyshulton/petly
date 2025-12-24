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
        Schema::create('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('transaction_id', true)->primary();
            $table->dateTime('transaction_date');
            $table->foreignId('user_user_id')->nullable(true)->constrained('users', "user_id")->onDelete('set null');
            $table->foreignId('delivery_delivery_id')->nullable(true)->constrained('deliveries', "delivery_id");
            $table->foreignId('foreign_cart_id')->nullable(true)->constrained('carts', "cart_id")->onDelete('set null');
            $table->foreignId('transactions_transaction_status_id')->constrained('transaction_statuses', "transaction_status_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
