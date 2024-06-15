<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $primaryKey = 'id';

    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'isadmin',
        'email',
        'password',
    ];

    public $timestamps = false;

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class, 'borrowing_user_id', 'id');
    }
}
