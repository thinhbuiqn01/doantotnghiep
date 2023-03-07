<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'job_id',
        'description',
        'role_take',
        'status',
    ];

    public function users()
    {
        return $this->belongsTo(Notification::class);
    }

    public function jobs()
    {
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }
}
