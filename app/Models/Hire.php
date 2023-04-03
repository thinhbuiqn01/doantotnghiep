<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hire extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_student',
        'email_student',
        'email_business',
        'phone_student',
        'user_id',
        'job_id',
        'business_id',
        'status',
        'cv',
    ];
}
