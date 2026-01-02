<?php

namespace App\Models\Markbook;

use App\Models\Player;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reading extends Model
{
    use SoftDeletes;

    protected $table = 'markbook_readings';

    protected $fillable = [
        'player_id',
        'pages_read',
        'notes',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
