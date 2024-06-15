<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    protected $primaryKey = 'borrowing_id';

    protected $fillable = [
        'borrowing_user_id',
        'borrowing_isreturned',
        'borrowing_notes',
        'borrowing_line',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'borrowing_user_id', 'id');
    }

    public function details()
    {
        return $this->hasMany(BorrowingDetail::class, 'detail_borrowing_id', 'borrowing_id');
    }
}
