<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attempt extends Model
{
    use SoftDeletes, HasUniqueName;

    const TIMEOUT_ANSWER = '[[TIMEOUT]]';

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

    #[Scope]
    protected function correct(Builder $query): Builder
    {
        return $query->where('is_correct', true);
    }

    #[Scope]
    protected function timedout(Builder $query): Builder
    {
        return $query->where('answer', self::TIMEOUT_ANSWER);
    }
}
