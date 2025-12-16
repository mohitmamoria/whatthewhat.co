<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Totem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'image_url',
        'pages',
    ];

    protected $casts = [
        'pages' => 'array',
    ];

    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class)
            ->withPivot('progress', 'collected_at')
            ->withTimestamps();
    }

    public function forPlayer(Player $player): BelongsTo
    {
        return $this->belongsTo(Player::class)
            ->whereHas('players', function ($query) use ($player) {
                $query->where('player_id', $player->id);
            })
            ->orWhereDoesntHave('players', function ($query) use ($player) {
                $query->where('player_id', $player->id);
            });
    }
}
