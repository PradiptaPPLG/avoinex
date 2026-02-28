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
        Schema::create('users', function (Blueprint $table) {
    $table->id('user_id');
    $table->string('username', 50)->unique();
    $table->string('email', 100)->unique();
    $table->string('password_hash');
    $table->string('full_name', 100)->nullable();
    $table->enum('user_role', ['admin', 'agent', 'staff'])->default('staff');
    $table->boolean('is_active')->default(true);
    $table->timestamp('last_login')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
