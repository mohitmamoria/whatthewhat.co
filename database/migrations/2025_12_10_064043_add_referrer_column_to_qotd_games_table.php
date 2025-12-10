<?php

use App\Models\Player;
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
            $table->foreignIdFor(Player::class, 'referrer_id')->after('player_id')->nullable()->constrained('players');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('qotd_games', function (Blueprint $table) {
            $table->dropColumn('referrer_id');
        });
    }
};
