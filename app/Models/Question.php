<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Question extends Model
{
    use SoftDeletes, HasUniqueName;

    protected $fillable = [
        'name',
        'asked_on',
        'body',
        'options',
    ];

    protected $casts = [
        'asked_on' => 'date',
        'options' => 'array',
    ];

    protected $appends = ['body_html'];

    public function bodyHtml(): Attribute
    {
        return Attribute::make(get: fn() => Str::markdown($this->body));
    }

    public static function forToday()
    {
        $today = now()->toDateString();
        return self::where('asked_on', $today)->first();
    }
}
