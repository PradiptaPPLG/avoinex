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
        Schema::create('bookings', function (Blueprint $table) {
    $table->id('booking_id');
    $table->string('booking_code', 15)->unique();
    $table->unsignedBigInteger('client_id'); // TAMBAH
    $table->foreign('client_id')->references('client_id')->on('clients');
    $table->unsignedBigInteger('flight_instance_id'); // TAMBAH
    $table->foreign('flight_instance_id')->references('flight_instance_id')->on('flight_instances');
    $table->decimal('total_price_usd', 10, 2);
    $table->enum('booking_status', ['pending', 'confirmed', 'cancelled', 'no_show'])->default('pending');
    $table->enum('payment_status', ['unpaid', 'pending', 'paid', 'refunded', 'failed'])->default('unpaid');
    $table->timestamp('booking_date')->useCurrent();
    $table->timestamp('expires_at')->nullable();
    $table->text('notes')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
