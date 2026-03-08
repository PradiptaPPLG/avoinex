<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        Schema::table('aircrafts', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('preferred_zone_end_row');
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('effective_to');
        });

        Schema::table('flight_instances', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('flight_date');
        });
    }

    public function down(): void
    {
        Schema::table('aircrafts', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('flight_instances', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};
