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
        Schema::create('clients', function (Blueprint $table) {
    $table->id('client_id');
    $table->string('first_name', 45);
    $table->string('middle_name', 45)->nullable();
    $table->string('last_name', 45);
    $table->string('phone', 45);
    $table->string('email', 45)->unique();
    $table->string('passport', 45)->unique();
    $table->char('iata_country_code', 2);
    $table->string('password_hash', 255)->nullable();
    $table->date('date_of_birth')->nullable();
    $table->timestamps();

    $table->foreign('iata_country_code')->references('country_code')->on('countries');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
