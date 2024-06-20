<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Publisher extends Model
{
    use HasFactory;

    protected $primaryKey = 'publisher_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'publisher_name',
        'publisher_description',
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

    public static function createPublisher(array $data)
    {
        return self::create($data);
    }

    public static function updatePublisher(string $id, array $data)
    {
        $publisher = self::find($id);
        if (!$publisher) {
            return null;
        }

        $publisher->update($data);
        return $publisher;
    }

    public static function findPublisher(string $id)
    {
        return self::find($id);
    }

    public $timestamps = false;

    public function books()
    {
        return $this->hasMany(Book::class, 'book_publisher_id', 'publisher_id');
    }
}
