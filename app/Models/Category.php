<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'category_id';

    protected $fillable = [
        'category_name',
        'category_description',
    ];

    public $timestamps = false;

    public function books()
    {
        return $this->hasMany(Book::class, 'book_category_id', 'category_id');
    }
}
