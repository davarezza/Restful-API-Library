<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BorrowingDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'detail_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'detail_book_id',
        'detail_borrowing_id',
        'detail_quantity',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

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
