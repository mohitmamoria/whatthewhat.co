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
        Schema::create('gamification_transactions', function (Blueprint $table) {
            $table->id();
            $table->morphs('owner');
            $table->string('idempotency_key')->nullable()->unique();
            $table->string('direction'); // credit or debit
            $table->unsignedBigInteger('amount');
            $table->string('reason', 255);
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gamification_transactions');
    }
};
