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
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', ['waiting_for_booking_fee', 'booking_fee_paid', 'waiting_for_pickup', 'washing', 'ready_for_pickup', 'completed', 'cancelled', 'cleaned'])->default('waiting_for_pickup')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', ['waiting_for_booking_fee', 'booking_fee_paid', 'waiting_for_pickup', 'washing', 'ready_for_pickup', 'completed', 'cancelled'])->default('waiting_for_booking_fee')->change();
        });
    }
};
