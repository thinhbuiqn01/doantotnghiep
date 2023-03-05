<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'business_id',
        'notification_id',
        'status', 
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function notification()
    {
        return $this->hasMany(Notification::class);
    }
    
}
