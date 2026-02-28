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
        Schema::create('airports', function (Blueprint $table) {
    $table->id('airport_id');
    $table->char('iata_code', 3)->unique();
    $table->char('icao_code', 4)->nullable();
    $table->string('airport_name', 255);
    $table->string('city', 100);
    $table->char('country_code', 2);
    $table->decimal('latitude', 10, 8)->nullable();
    $table->decimal('longitude', 11, 8)->nullable();
    $table->string('timezone', 50)->nullable();
    $table->timestamps();

    $table->foreign('country_code')->references('country_code')->on('countries');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airports');
    }
};
