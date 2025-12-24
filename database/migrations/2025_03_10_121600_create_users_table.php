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
        Schema::create('users', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id', true)->primary();
            $table->string('username')->nullable(false);
            $table->unsignedBigInteger('role_role_id')->nullable(false)->default(1);
            $table->string('password')->nullable(false);
            $table->string('phone_number')->nullable(false);
            $table->string('email')->unique('users_email_unique')->nullable(false);
            $table->string('token', 100)->unique('users_token_unique')->nullable();
            $table->timestamps();

            $table->foreign('role_role_id')->on('roles')->references('role_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
