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
        Schema::create('aircraft_manufacturers', function (Blueprint $table) {
    $table->id('aircraft_manufacturer_id');
    $table->string('name', 45)->unique();
    $table->char('country_code', 2)->nullable();
    $table->year('founded_year')->nullable();
    $table->timestamps();

    $table->foreign('country_code')->references('country_code')->on('countries');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aircraft_manufacturers');
    }
};
