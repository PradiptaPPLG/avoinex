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
       Schema::create('flight_instances', function (Blueprint $table) {
    $table->id('flight_instance_id');
    $table->unsignedBigInteger('schedule_id'); // TAMBAH
    $table->foreign('schedule_id')->references('schedule_id')->on('schedules');
    $table->unsignedBigInteger('aircraft_instance_id'); // TAMBAH
    $table->foreign('aircraft_instance_id')->references('aircraft_instance_id')->on('aircraft_instances');
    $table->date('flight_date');
    $table->string('departure_gate', 10)->nullable();
    $table->string('arrival_gate', 10)->nullable();
    $table->timestamp('departure_actual')->nullable();
    $table->timestamp('arrival_actual')->nullable();
    $table->unsignedBigInteger('flight_status_id')->default(1); // TAMBAH
    $table->foreign('flight_status_id')->references('flight_status_id')->on('flight_statuses');
    $table->timestamps();

    $table->unique(['schedule_id', 'flight_date']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_instances');
    }
};
