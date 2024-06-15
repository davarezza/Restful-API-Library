<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $primaryKey = 'author_id';

    protected $fillable = [
        'author_name',
        'author_description',
    ];

    public $timestamps = false;

    public function books()
    {
        return $this->hasMany(Book::class, 'book_author_id', 'author_id');
    }
}
