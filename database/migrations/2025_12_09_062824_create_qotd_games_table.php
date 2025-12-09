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
        Schema::create('qotd_games', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Player::class)->constrained()->cascadeOnDelete();
            $table->date('joined_on');
            $table->date('expires_on')->nullable();
            $table->unsignedInteger('longest_streak')->default(0);
            $table->unsignedInteger('current_streak')->default(0);
            $table->unsignedSmallInteger('total_attempted')->default(0);
            $table->unsignedSmallInteger('total_answered')->default(0);
            $table->unsignedSmallInteger('answered_percent')->default(0);
            $table->unsignedSmallInteger('average_time_taken')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qotd_games');
    }
};
