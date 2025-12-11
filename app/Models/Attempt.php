<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attempt extends Model
{
    use SoftDeletes, HasUniqueName;

    const TIME_PER_ATTEMPT = 13; // seconds
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

    public function isTimedOut(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->answer === self::TIMEOUT_ANSWER,
        );
    }

    public function isCompleted(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->time_spent !== null,
        );
    }
}
