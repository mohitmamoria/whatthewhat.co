<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendQotdReminderToPlayers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:qotd-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send QOTD reminder to players who have not played yet';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
