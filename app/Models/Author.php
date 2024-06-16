<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Author extends Model
{
    use HasFactory;

    protected $primaryKey = 'author_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'author_name',
        'author_description',
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
        return $this->hasMany(Book::class, 'book_author_id', 'author_id');
    }
}
