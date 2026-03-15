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
        Schema::create('flash_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flight_id')->constrained('flight_instances', 'flight_instance_id')->cascadeOnDelete();
            $table->string('discount_type'); // 'percentage' or 'fixed'
            $table->decimal('discount_value', 10, 2);
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->integer('max_seats');
            $table->integer('seats_sold')->default(0);
            $table->integer('priority')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Additional indexes for performance
            $table->index('flight_id'); // This might be redundant if foreignId already creates it, but explicitly added as requested
            $table->index('is_active');
            $table->index(['start_time', 'end_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flash_sales');
    }
};
