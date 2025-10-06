<?php

namespace App\Providers;

use App\Models\Player;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Laravel\Mcp\Server\Resource;
use Illuminate\Http\Resources\Json\JsonResource; // Add this import

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping(); // Disable wrapping of resource data

        Relation::enforceMorphMap([
            'player' => Player::class,
        ]);
    }
}
