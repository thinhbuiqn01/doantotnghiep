<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    //use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'phone',
        'status',
        'password',
    ];

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id', 'id');
    }

    public function businesses()
    {
        return $this->hasOne(Business::class, 'user_id', 'id');
    }
}
