<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'category_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'category_name',
        'category_description',
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

    public static function createCategory(array $data)
    {
        return self::create($data);
    }

    public static function updateCategory(string $id, array $data)
    {
        $category = self::find($id);
        if (!$category) {
            return null;
        }

        $category->update($data);
        return $category;
    }

    public static function findCategory(string $id)
    {
        return self::find($id);
    }

    public $timestamps = false;

    public function books()
    {
        return $this->hasMany(Book::class, 'book_category_id', 'category_id');
    }
}
