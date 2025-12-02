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
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->string('machine_id')->unique();
            $table->string('location');
            $table->enum('status', ['available', 'in_use', 'unpaid', 'pending'])->default('available');
            $table->enum('availability', ['available', 'unavailable'])->default('available');
            $table->enum('payment_status', ['-', 'paid', 'unpaid'])->default('unpaid');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machines');
    }
};
