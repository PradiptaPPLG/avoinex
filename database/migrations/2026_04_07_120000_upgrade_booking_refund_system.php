<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->text('refund_reason')->nullable()->after('notes');
            $table->timestamp('refund_requested_at')->nullable()->after('refund_reason');
            $table->decimal('refund_amount_usd', 10, 2)->nullable()->after('refund_requested_at');
            $table->string('refund_admin_notes', 500)->nullable()->after('refund_amount_usd');
            $table->timestamp('refund_processed_at')->nullable()->after('refund_admin_notes');
        });

        // Expand booking_status enum
        DB::statement("ALTER TABLE bookings MODIFY COLUMN booking_status ENUM('pending','confirmed','cancelled','refund_requested','no_show') DEFAULT 'pending'");

        // Expand payment_status enum
        DB::statement("ALTER TABLE bookings MODIFY COLUMN payment_status ENUM('unpaid','pending','paid','refund_pending','refunded','failed','refund_rejected') DEFAULT 'unpaid'");
    }

    public function down(): void
    {
        // Revert enums
        DB::statement("ALTER TABLE bookings MODIFY COLUMN booking_status ENUM('pending','confirmed','cancelled','no_show') DEFAULT 'pending'");
        DB::statement("ALTER TABLE bookings MODIFY COLUMN payment_status ENUM('unpaid','pending','paid','refunded','failed') DEFAULT 'unpaid'");

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['refund_reason', 'refund_requested_at', 'refund_amount_usd', 'refund_admin_notes', 'refund_processed_at']);
        });
    }
};
