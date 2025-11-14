<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComingSoonSubscription extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'page',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
