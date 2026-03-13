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
        Schema::table('aircrafts', function (Blueprint $table) {
            $table->integer('baggage_capacity_kg')->default(20)->after('business_seats');
            $table->boolean('has_meal')->default(true)->after('baggage_capacity_kg');
            $table->boolean('has_wifi')->default(false)->after('has_meal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aircrafts', function (Blueprint $table) {
            $table->dropColumn(['baggage_capacity_kg', 'has_meal', 'has_wifi']);
        });
    }
};
