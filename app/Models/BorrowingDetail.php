<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowingDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'detail_id';

    protected $fillable = [
        'detail_book_id',
        'detail_borrowing_id',
        'detail_quantity',
    ];

    public $timestamps = false;

    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class, 'detail_borrowing_id', 'borrowing_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'detail_book_id', 'book_id');
    }
}
