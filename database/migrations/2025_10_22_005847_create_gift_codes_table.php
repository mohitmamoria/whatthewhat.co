<?php

use App\Models\Gift;
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
        Schema::create('gift_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Gift::class)->constrained()->onDelete('cascade');
            $table->string('name')->unique();
            $table->string('code')->unique();
            $table->foreignIdFor(Player::class, 'receiver_id')->nullable();
            $table->json('meta')->nullable();
            $table->timestamp('reserved_at')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_codes');
    }
};
