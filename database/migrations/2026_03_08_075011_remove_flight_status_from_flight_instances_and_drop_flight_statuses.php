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
            $table->dropForeign(['flight_status_id']);
            $table->dropColumn('flight_status_id');
        });

        Schema::dropIfExists('flight_statuses');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('flight_statuses', function (Blueprint $table) {
            $table->id('flight_status_id');
            $table->string('status_name', 50)->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('flight_instances', function (Blueprint $table) {
            $table->unsignedBigInteger('flight_status_id')->default(1)->after('arrival_actual');
            $table->foreign('flight_status_id')->references('flight_status_id')->on('flight_statuses');
        });
    }
};
