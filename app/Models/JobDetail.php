<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'job_id',
        'description', 
        'type_pay_salary', 
        'location_job', 
        'email_give_job', 
        'require_job',  
    ];

    public function jobs()
    {
        return $this->hasOne(Jobs::class, 'job_id', 'id');
    }
}
