<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('subscription_id')
                ->nullable()
                ->after('email')
                ->constrained('subscriptions')
                ->nullOnDelete();
        });

        // Migrate existing string plans to IDs
        DB::statement("UPDATE users SET subscription_id = 1 WHERE plan = 'Basic'");
        DB::statement("UPDATE users SET subscription_id = 2 WHERE plan = 'Core'");
        DB::statement("UPDATE users SET subscription_id = 3 WHERE plan = 'Circle'");

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('plan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('plan')->nullable()->after('subscription_id');
        });

        // Restore string plans from IDs
        DB::statement("UPDATE users SET plan = 'Basic' WHERE subscription_id = 1");
        DB::statement("UPDATE users SET plan = 'Core' WHERE subscription_id = 2");
        DB::statement("UPDATE users SET plan = 'Circle' WHERE subscription_id = 3");

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['subscription_id']);
            $table->dropColumn('subscription_id');
        });
    }
};
