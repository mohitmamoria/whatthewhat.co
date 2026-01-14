<?php

use App\Models\Gamification\Activity;
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
            $table->foreignIdFor(Activity::class, 'activity_id')
                ->nullable()
                ->after('wallet_id')
                ->storedAs("JSON_UNQUOTE(meta->'$.activity_id')")
                ->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gamification_transactions', function (Blueprint $table) {
            $table->dropColumn('activity_id');
        });
    }
};
