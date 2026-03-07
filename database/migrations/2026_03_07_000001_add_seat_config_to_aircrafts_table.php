<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('aircrafts', function (Blueprint $table) {
            $table->integer('seat_columns')->default(6)->after('total_seats');
            $table->integer('seat_rows')->default(30)->after('seat_columns');
            $table->integer('business_rows')->default(2)->after('seat_rows');
            $table->boolean('preferred_zone_enabled')->default(false)->after('business_rows');
            $table->integer('preferred_zone_start_row')->nullable()->after('preferred_zone_enabled');
            $table->integer('preferred_zone_end_row')->nullable()->after('preferred_zone_start_row');
        });
    }

    public function down(): void
    {
        Schema::table('aircrafts', function (Blueprint $table) {
            $table->dropColumn([
                'seat_columns',
                'seat_rows',
                'business_rows',
                'preferred_zone_enabled',
                'preferred_zone_start_row',
                'preferred_zone_end_row',
            ]);
        });
    }
};
