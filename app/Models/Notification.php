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
        'description', 
    ];

    public function users()
    {
        return $this->belongsTo(Notification::class);
    }
}
