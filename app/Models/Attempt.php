<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attempt extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'question_id',
        'player_id',
        'answer',
        'is_correct',
        'time_spent',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
