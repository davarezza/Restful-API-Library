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

    public static function createAuthor(array $data)
    {
        return self::create($data);
    }

    public static function updateAuthor(string $id, array $data)
    {
        $author = self::find($id);
        if (!$author) {
            return null;
        }

        $author->update($data);
        return $author;
    }

    public static function findAuthor(string $id)
    {
        return self::find($id);
    }

    public $timestamps = false;

    public function books()
    {
        return $this->hasMany(Book::class, 'book_author_id', 'author_id');
    }
}
