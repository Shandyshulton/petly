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
        // Schema::create('pets', function (Blueprint $table) {
        //     $table->unsignedBigInteger('pet_id', true)->primary();
        //     $table->string('pet_name', 25);
        //     $table->string('pet_gender', 10);
        //     $table->integer('pet_weight');
        //     $table->foreignId('user_user_id')->constrained('users', 'user_id');
        //     $table->foreignId('pet_pet_types_id')->constrained('pet_types', 'pet_type_id');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
