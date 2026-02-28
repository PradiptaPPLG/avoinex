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
       Schema::create('booking_seats', function (Blueprint $table) {
    $table->id('booking_seat_id');
    $table->unsignedBigInteger('booking_id'); // TAMBAH
    $table->foreign('booking_id')->references('booking_id')->on('bookings');
    $table->unsignedBigInteger('flight_seat_price_id'); // TAMBAH
    $table->foreign('flight_seat_price_id')->references('flight_seat_price_id')->on('flight_seat_prices');
    $table->string('passenger_first_name', 45);
    $table->string('passenger_last_name', 45);
    $table->string('passenger_passport', 45);
    $table->date('passenger_date_of_birth')->nullable();
    $table->unsignedBigInteger('seat_id'); // TAMBAH
    $table->foreign('seat_id')->references('seat_id')->on('seats');
    $table->decimal('price_at_booking', 10, 2);
    $table->text('special_requests')->nullable();
    $table->enum('checkin_status', ['not_checked', 'checked', 'boarded'])->default('not_checked');
    $table->string('boarding_pass_code', 20)->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_seats');
    }
};
