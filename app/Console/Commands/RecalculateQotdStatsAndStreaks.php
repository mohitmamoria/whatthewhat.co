<?php

namespace App\Console\Commands;

use App\Actions\Qotd\RecalculateQotdStats;
use App\Actions\Qotd\RecalculateQotdStreaks;
use App\Models\Player;
use Illuminate\Console\Command;

class RecalculateQotdStatsAndStreaks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:recalculate-qotd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate QOTD stats and streaks for all players';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting recalculation of QOTD stats and streaks...');

        $players = Player::with('qotd')->whereHas('qotd')->cursor();
        $total = $players->count();
        foreach ($players as $index => $player) {
            $this->info(sprintf('[%d of %d] --------------------------', $index + 1, $total));
            $this->info(sprintf("Player ID: %d (%s)", $player->id, $player->name));
            $this->info("Recalculating stats...");
            (new RecalculateQotdStats)($player);

            $this->info("Recalculating streaks...");
            (new RecalculateQotdStreaks)($player);
        }

        $this->info('Recalculation completed.');
    }
}
