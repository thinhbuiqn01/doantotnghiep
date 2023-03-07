<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'scales',
        'link_website',
        'location',
        'image',
        'task',
        'status',
        'user_id',
    ];

    public function users()
    {
        return $this->hasOne(User::class, 'user_id', 'id');
    }
    public function jobs()
    {
        return $this->hasMany(Job::class, 'job_id', 'id');
    }
}
