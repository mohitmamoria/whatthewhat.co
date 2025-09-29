<?php

use App\Models\Gamification\Wallet;
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
        Schema::table('gamification_transactions', function (Blueprint $table) {
            $table->dropMorphs('owner');
            $table->foreignIdFor(Wallet::class, 'wallet_id')->after('id')->constrained('gamification_wallets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gamification_transactions', function (Blueprint $table) {
            $table->morphs('owner');
            $table->dropConstrainedForeignIdFor(Wallet::class, 'wallet_id');
        });
    }
};
