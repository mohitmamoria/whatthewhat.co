<?php

namespace App\Models\Markbook;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    protected $table = 'markbook_books';

    protected $fillable = [
        'openlibrary_work_id',
        'google_books_volume_id',
        'title',
        'authors',
        'cover_image_url',
        'published_year',
    ];

    protected $casts = [
        'authors' => 'array',
    ];

    public function readings()
    {
        return $this->hasMany(Reading::class);
    }
}
