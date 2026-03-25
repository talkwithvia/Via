<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Creates the 'subscriptions' table for editable Via membership tiers.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('name');          // e.g. "Via Basic"
            $table->string('price');         // e.g. "500"
            $table->string('period')->default('/month');
            $table->string('tagline');
            $table->text('features');        // One feature per line
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
