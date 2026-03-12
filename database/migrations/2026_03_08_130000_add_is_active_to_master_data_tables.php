<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        Schema::table('airports', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('timezone');
        });

        Schema::table('airlines', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('contact_phone');
        });

        Schema::table('countries', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('continent');
        });

        Schema::table('aircraft_manufacturers', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('founded_year');
        });
    }

    public function down(): void
    {
        $tables = ['airports', 'airlines', 'countries', 'aircraft_manufacturers'];
        foreach ($tables as $t) {
            Schema::table($t, function (Blueprint $table) {
                $table->dropColumn('is_active');
            });
        }
    }
};
