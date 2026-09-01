<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->unsignedBigInteger('appointment_id', true)->primary();
            $table->foreignId('user_user_id')->constrained('users', 'user_id')->onDelete('cascade')->onUpdate('cascade');
            $table->string('service_type');
            $table->date('appointment_date');
            $table->string('appointment_time', 20);
            $table->string('pet_name');
            $table->string('pet_species');
            $table->string('pet_breed')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
