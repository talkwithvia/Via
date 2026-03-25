<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds a 'plan' and 'status' column to the users table
 * so we can track which membership plan each user is on.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Membership plan: Basic, Core, or Circle
            $table->string('plan')->default('Basic')->after('email');
            // Account status: Active or Inactive
            $table->string('status')->default('Active')->after('plan');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['plan', 'status']);
        });
    }
};
