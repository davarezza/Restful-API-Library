<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Borrowing extends Model
{
    use HasFactory;

    protected $primaryKey = 'borrowing_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'borrowing_user_id',
        'borrowing_isreturned',
        'borrowing_notes',
        'borrowing_line',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });

        static::deleting(function ($model) {
            $model->details()->delete();
        });
    }

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
