<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('meals')) {
            Schema::create('meals', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->decimal('price_usd', 8, 2)->default(0);
                $table->string('image_path')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('flight_meals')) {
            Schema::create('flight_meals', function (Blueprint $table) {
                $table->id();
                $table->foreignId('flight_instance_id')->constrained('flight_instances')->onDelete('cascade');
                $table->foreignId('meal_id')->constrained('meals')->onDelete('cascade');
                $table->timestamps();
                
                $table->unique(['flight_instance_id', 'meal_id']);
            });
        }

        Schema::table('booking_seats', function (Blueprint $table) {
            if (!Schema::hasColumn('booking_seats', 'meal_id')) {
                $table->foreignId('meal_id')->nullable()->constrained('meals')->nullOnDelete();
            }
            if (!Schema::hasColumn('booking_seats', 'meal_price')) {
                $table->decimal('meal_price', 8, 2)->default(0);
            }
            if (!Schema::hasColumn('booking_seats', 'has_insurance')) {
                $table->boolean('has_insurance')->default(false);
            }
            if (!Schema::hasColumn('booking_seats', 'insurance_price')) {
                $table->decimal('insurance_price', 8, 2)->default(0);
            }
            if (!Schema::hasColumn('booking_seats', 'is_vip_seat_selection')) {
                $table->boolean('is_vip_seat_selection')->default(false);
            }
        });
    }

    public function down(): void
    {
        Schema::table('booking_seats', function (Blueprint $table) {
            if (Schema::hasColumn('booking_seats', 'meal_id')) {
                $table->dropForeign(['meal_id']);
                $table->dropColumn('meal_id');
            }
            if (Schema::hasColumn('booking_seats', 'meal_price')) $table->dropColumn('meal_price');
            if (Schema::hasColumn('booking_seats', 'has_insurance')) $table->dropColumn('has_insurance');
            if (Schema::hasColumn('booking_seats', 'insurance_price')) $table->dropColumn('insurance_price');
            if (Schema::hasColumn('booking_seats', 'is_vip_seat_selection')) $table->dropColumn('is_vip_seat_selection');
        });

        Schema::dropIfExists('flight_meals');
        Schema::dropIfExists('meals');
    }
};
