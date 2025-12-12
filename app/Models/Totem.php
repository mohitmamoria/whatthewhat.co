<?php

namespace App\Models;

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
}
