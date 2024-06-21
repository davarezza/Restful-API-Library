<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

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
    
    public static function storeWithDetails(array $data)
    {
        try {
            DB::beginTransaction();

            $borrowing = self::create($data);

            foreach ($data['details'] as $detail) {
                BorrowingDetail::create([
                    'detail_borrowing_id' => $borrowing->borrowing_id,
                    'detail_book_id' => $detail['book_id'],
                    'detail_quantity' => $detail['quantity'],
                ]);
            }

            DB::commit();

            return $borrowing;
        } catch (\Exception $e) {
            DB::rollback();
            return null;
        }
    }

    public static function findByIdWithDetails(string $id)
    {
        return self::with('details')->find($id);
    }

    public static function updateWithDetails(string $id, array $data)
    {
        try {
            DB::beginTransaction();

            $borrowing = self::findOrFail($id);
            $borrowing->update($data);

            BorrowingDetail::where('detail_borrowing_id', $borrowing->borrowing_id)->delete();
            foreach ($data['details'] as $detail) {
                BorrowingDetail::create([
                    'detail_borrowing_id' => $borrowing->borrowing_id,
                    'detail_book_id' => $detail['book_id'],
                    'detail_quantity' => $detail['quantity'],
                ]);
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public static function deleteById(string $id)
    {
        try {
            DB::beginTransaction();

            $borrowing = self::find($id);

            if (!$borrowing) {
                DB::rollback();
                return false;
            }

            $borrowing->delete();

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
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
