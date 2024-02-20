<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'publisher_id',
        'title',
        'price',
        'copies',
        'published_date'
    ];

    public function author()
    {
        return $this->belongsToMany(Author::class, 'author_book');
    }

    public function language()
    {
        return $this->belongsToMany(Language::class, 'book_language');
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
