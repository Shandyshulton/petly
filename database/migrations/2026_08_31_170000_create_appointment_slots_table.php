<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointment_slots', function (Blueprint $table) {
            $table->id('slot_id');
            $table->string('service_type');
            $table->date('appointment_date');
            $table->string('appointment_time', 20);
            $table->unsignedInteger('capacity')->default(5);
            $table->unsignedInteger('booked_count')->default(0);
            $table->timestamps();

            $table->unique(['service_type', 'appointment_date', 'appointment_time'], 'appointment_slots_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointment_slots');
    }
};
