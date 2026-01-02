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
        Schema::table('qotd_games', function (Blueprint $table) {
            $table->foreignId('longest_streak_start_attempt_id')->nullable()->after('longest_streak');
            $table->foreignId('current_streak_start_attempt_id')->nullable()->after('current_streak');
            $table->timestamp('last_streak_calculated_at')->nullable()->after('average_time_taken');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('qotd_games', function (Blueprint $table) {
            $table->dropColumn('longest_streak_start_attempt_id');
            $table->dropColumn('current_streak_start_attempt_id');
            $table->dropColumn('last_streak_calculated_at');
        });
    }
};
