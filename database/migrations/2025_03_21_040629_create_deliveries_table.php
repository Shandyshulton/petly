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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->unsignedBigInteger('delivery_id', true)->primary();
            $table->dateTime('delivery_deadline')->nullable(false);
            $table->string('delivery_address', 255)->nullable(false);
            $table->foreignId('courier_id')->nullable(true)->constrained('users', 'user_id')->onDelete('cascade');
            // $table->foreignId('courier_id')->constrained('couriers', 'user_user_id')->onDelete('cascade');
            $table->foreignId('delivery_delivery_class_id')->constrained('delivery_classes', 'delivery_class_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
