<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'email',
        'contact',
    ];

    // Define the relationship with the User model if necessary
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
