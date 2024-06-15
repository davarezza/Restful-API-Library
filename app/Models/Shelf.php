<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shelf extends Model
{
    use HasFactory;

    protected $primaryKey = 'shelf_id';

    protected $fillable = [
        'shelf_name',
        'shelf_position',
    ];

    public $timestamps = false;

    public function books()
    {
        return $this->hasMany(Book::class, 'book_shelf_id', 'shelf_id');
    }
}
