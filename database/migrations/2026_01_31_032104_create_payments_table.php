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
        Schema::create('payments', function (Blueprint $table) {
    $table->id('payment_id');
    $table->unsignedBigInteger('booking_id'); // TAMBAH
    $table->foreign('booking_id')->references('booking_id')->on('bookings');
    $table->string('payment_code', 50)->unique();
    $table->enum('payment_method', ['credit_card', 'debit_card', 'bank_transfer', 'ewallet', 'virtual_account']);
    $table->decimal('amount_usd', 10, 2);
    $table->char('currency', 3)->default('USD');
    $table->enum('payment_status', ['pending', 'success', 'failed', 'expired'])->default('pending');
    $table->string('gateway_name', 50)->nullable();
    $table->text('gateway_response')->nullable();
    $table->timestamp('paid_at')->nullable();
    $table->timestamp('expiry_at')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
