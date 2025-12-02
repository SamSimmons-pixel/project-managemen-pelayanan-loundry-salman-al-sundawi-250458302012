<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_type')->default('online');
            $table->string('branch_admin_id')->nullable();
            $table->string('service_type');
            $table->float('weight')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('booking_fee', 10, 2)->nullable();
            $table->string('pickup_address');
            $table->dateTime('pickup_time');
            $table->enum('status', [
                'pending',
                'completed',
                'cancelled',
                'denied',
                'expired',
                'challenge',
                'settlement',
                'failed',
                'success',
                'pickup_scheduled',
                'processing',
                'ready_for_pickup',
            ])->default('pending');
            $table->decimal('approximate_price', 10, 2)->nullable();
            $table->string('final_payment_method')->nullable();
            $table->timestamps();
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
