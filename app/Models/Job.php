<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_job',
        'tech_using',
        'description',
        'require_job',
        'location',
        'email_give',
        'status',
        'business_id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function notification()
    {
        return $this->hasMany(Notification::class);
    }

    public function businesses()
    {
        return $this->belongsTo(Business::class);
    }
}
