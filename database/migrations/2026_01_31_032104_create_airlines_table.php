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
        Schema::create('airlines', function (Blueprint $table) {
    $table->id('airline_id');
    $table->string('airline_code', 10)->unique();
    $table->string('airline_name', 100);
    $table->char('country_code', 2)->nullable();
    $table->string('website', 255)->nullable();
    $table->string('contact_phone', 45)->nullable();
    $table->timestamps();

    $table->foreign('country_code')->references('country_code')->on('countries');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airlines');
    }
};
