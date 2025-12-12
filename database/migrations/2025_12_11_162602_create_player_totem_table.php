<?php

use App\Models\Player;
use App\Models\Totem;
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
        Schema::create('player_totem', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Player::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Totem::class)->constrained()->onDelete('cascade');
            $table->json('progress')->nullable();
            $table->timestamp('collected_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_totem');
    }
};
