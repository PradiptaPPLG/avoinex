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
        Schema::table('clients', function (Blueprint $table) {
            $table->string('phone', 45)->nullable()->change();
            $table->string('passport', 45)->nullable()->change();
            $table->char('iata_country_code', 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('phone', 45)->nullable(false)->change();
            $table->string('passport', 45)->nullable(false)->change();
            $table->char('iata_country_code', 2)->nullable(false)->change();
        });
    }
};
