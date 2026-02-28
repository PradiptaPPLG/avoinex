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
        Schema::create('aircrafts', function (Blueprint $table) {
    $table->id('aircraft_id');
    $table->string('aircraft_model', 100);
    $table->unsignedBigInteger('manufacturer_id');
    $table->foreign('manufacturer_id')->references('aircraft_manufacturer_id')->on('aircraft_manufacturers');
    $table->string('icao_code', 10)->nullable();
    $table->integer('total_seats');
    $table->integer('economy_seats')->nullable();
    $table->integer('business_seats')->nullable();
    $table->integer('first_class_seats')->nullable();
    $table->integer('max_range_km')->nullable();
    $table->integer('cruise_speed_kmh')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aircraft');
    }
};
