<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_option')->nullable()->after('payment_status');
        });

        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'waiting_for_booking_fee', 'booking_fee_paid', 'waiting_for_pickup', 'washing', 'ready_for_pickup', 'completed', 'cancelled') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
