<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Shelf extends Model
{
    use HasFactory;

    protected $primaryKey = 'shelf_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'shelf_name',
        'shelf_position',
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

    public function books()
    {
        return $this->hasMany(Book::class, 'book_shelf_id', 'shelf_id');
    }
}
