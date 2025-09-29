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
        Schema::create('gamification_wallets', function (Blueprint $table) {
            $table->id();
            $table->morphs('owner');
            $table->bigInteger('balance')->default(0);
            $table->bigInteger('lifetime_earned')->default(0);
            $table->bigInteger('lifetime_spent')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gamification_wallets');
    }
};
