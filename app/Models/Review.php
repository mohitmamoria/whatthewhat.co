<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'player_id',
        'rating',
        'title',
        'body',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function changes()
    {
        return $this->hasMany(Review::class, 'player_id', 'player_id')
            ->onlyTrashed()
            ->orderBy('deleted_at', 'desc');
    }
}
