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
        Schema::table('booking_seats', function (Blueprint $table) {
            $table->integer('baggage_weight')->default(0)->nullable()->after('special_requests');
            $table->decimal('baggage_price', 10, 2)->default(0)->after('baggage_weight');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_seats', function (Blueprint $table) {
            $table->dropColumn(['baggage_weight', 'baggage_price']);
        });
    }
};
