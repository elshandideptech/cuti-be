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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_language');
            $table->foreignId('id_parent')->nullable();
            $table->string('first_name', 20);
            $table->string('last_name', 20);
            $table->string('email', 50);
            $table->string('phone_number', 15);
            $table->string('address', 255);
            $table->string('gender', 10);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
