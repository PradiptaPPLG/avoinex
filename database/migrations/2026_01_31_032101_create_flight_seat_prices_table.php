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
        Schema::create('flight_seat_prices', function (Blueprint $table) {
    $table->id('flight_seat_price_id');
    $table->unsignedBigInteger('flight_instance_id'); // TAMBAH
    $table->foreign('flight_instance_id')->references('flight_instance_id')->on('flight_instances');
    $table->unsignedBigInteger('seat_id'); // TAMBAH
    $table->foreign('seat_id')->references('seat_id')->on('seats');
    $table->decimal('price_usd', 10, 2);
    $table->char('currency', 3)->default('USD');
    $table->boolean('is_available')->default(true);
    $table->timestamps();

    $table->unique(['flight_instance_id', 'seat_id']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_seat_prices');
    }
};
