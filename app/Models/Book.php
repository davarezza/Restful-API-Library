<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\File;

class Book extends Model
{
    use HasFactory;

    protected $primaryKey = 'book_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'book_category_id',
        'book_publisher_id',
        'book_shelf_id',
        'book_author_id',
        'book_name',
        'book_isbn',
        'book_stock',
        'book_description',
        'book_img',
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

    public static function createBook($data)
    {
        if (isset($data['book_img'])) {
            $file = $data['book_img'];
            $imageName = md5($file->getClientOriginalName() . microtime()) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/books'), $imageName);
            $data['book_img'] = $imageName;
        }

        return self::create($data);
    }

    public static function findBookById($id)
    {
        return self::find($id);
    }

    public function updateBook($data)
    {
        if (isset($data['book_img'])) {
            if (!empty($data->book_img)) {
                $imageName = public_path('img/book_image/' . $data->book_img);
                if (file_exists($imageName) && !is_dir($imageName)) {
                    unlink($imageName);
                }
            }

            $file = $data['book_img'];
            $file->move(public_path('img/books'), $imageName);
            $data['book_img'] = $imageName;
        }
        
        $imageName = md5($file->getClientOriginalName() . microtime()) . '.' . $file->getClientOriginalExtension();
        $this->update($data);
    }

    public function deleteBook()
    {
        $imagePath = public_path('img/books/' . $this->book_img);
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        $this->delete();
    }

    public $timestamps = false;

    public function categories()
    {
        return $this->belongsTo(Category::class, 'book_category_id', 'category_id');
    }

    public function publishers()
    {
        return $this->belongsTo(Publisher::class, 'book_publisher_id', 'publisher_id');
    }

    public function shelves()
    {
        return $this->belongsTo(Shelf::class, 'book_shelf_id', 'shelf_id');
    }

    public function authors()
    {
        return $this->belongsTo(Author::class, 'book_author_id', 'author_id');
    }

    public function borrowingDetails()
    {
        return $this->hasMany(BorrowingDetail::class, 'detail_book_id', 'book_id');
    }
}
