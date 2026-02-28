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
        Schema::create('aircraft_instances', function (Blueprint $table) {
    $table->id('aircraft_instance_id');
    $table->string('registration_number', 20)->unique();
    $table->unsignedBigInteger('aircraft_id'); // TAMBAH INI
    $table->foreign('aircraft_id')->references('aircraft_id')->on('aircrafts');
    $table->year('manufacture_year')->nullable();
    $table->date('next_maintenance_date')->nullable();
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aircraft_instances');
    }
};
