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
        Schema::create('schedules', function (Blueprint $table) {
    $table->id('schedule_id');
    $table->string('flight_number', 10);
    $table->string('airline_code', 10);
    $table->char('origin_iata_code', 3);
    $table->char('destination_iata_code', 3);
    $table->time('departure_time_gmt');
    $table->time('arrival_time_gmt');
    $table->integer('duration_minutes');
    $table->boolean('is_daily')->default(true);
    $table->boolean('monday')->default(true);
    $table->boolean('tuesday')->default(true);
    $table->boolean('wednesday')->default(true);
    $table->boolean('thursday')->default(true);
    $table->boolean('friday')->default(true);
    $table->boolean('saturday')->default(true);
    $table->boolean('sunday')->default(true);
    $table->decimal('base_price_usd', 10, 2);
    $table->date('effective_from');
    $table->date('effective_to')->nullable();
    $table->timestamps();

    $table->unique(['flight_number', 'departure_time_gmt']);
    $table->foreign('origin_iata_code')->references('iata_code')->on('airports');
    $table->foreign('destination_iata_code')->references('iata_code')->on('airports');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
