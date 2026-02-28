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
        Schema::create('seats', function (Blueprint $table) {
    $table->id('seat_id');
    $table->unsignedBigInteger('aircraft_id'); // TAMBAH INI
    $table->foreign('aircraft_id')->references('aircraft_id')->on('aircrafts');
    $table->string('seat_number', 10);
    $table->enum('seat_class', ['economy', 'business', 'first'])->default('economy');
    $table->enum('seat_type', ['window', 'aisle', 'middle'])->default('aisle');
    $table->boolean('is_active')->default(true);
    $table->timestamps();

    $table->unique(['aircraft_id', 'seat_number']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
