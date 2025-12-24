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
        Schema::create('delivery_classes', function (Blueprint $table) {
            $table->unsignedBigInteger('delivery_class_id', true)->primary();
            $table->string('delivery_class_name')->nullable(false);
            $table->integer('delivery_class_price')->nullable(false);
            $table->text('delivery_class_desc')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_classes');
    }
};
