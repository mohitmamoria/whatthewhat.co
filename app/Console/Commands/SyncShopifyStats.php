<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncShopifyStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-shopify-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncs Shopify stats locally every minute';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
