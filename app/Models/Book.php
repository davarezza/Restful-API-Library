<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $primaryKey = 'book_id';

    protected $fillable = [
        'book_category_id',
        'book_publisher_id',
        'book_shelf_id',
        'book_author_id',
        'book_name',
        'book_isbn',
        'book_stock',
        'book_description',
        'book_img',
    ];

    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(Category::class, 'book_category_id', 'category_id');
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class, 'book_publisher_id', 'publisher_id');
    }

    public function shelf()
    {
        return $this->belongsTo(Shelf::class, 'book_shelf_id', 'shelf_id');
    }

    public function author()
    {
        return $this->belongsTo(Author::class, 'book_author_id', 'author_id');
    }
}
