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
        Schema::table('flight_instances', function (Blueprint $table) {
            $table->dropForeign(['schedule_id']);
            $table->dropUnique(['schedule_id', 'flight_date']);
            $table->index(['schedule_id']);
            $table->foreign('schedule_id')->references('schedule_id')->on('schedules');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flight_instances', function (Blueprint $table) {
            $table->dropForeign(['schedule_id']);
            $table->dropIndex(['schedule_id']);
            $table->unique(['schedule_id', 'flight_date']);
            $table->foreign('schedule_id')->references('schedule_id')->on('schedules');
        });
    }
};
