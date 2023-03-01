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
        'user_id',
    ];
}
