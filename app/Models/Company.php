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
        'registration_number',
        'terms_conditions_demandes',
        'terms_conditions_demandes', 
        'payment_instructions', 
        'bank_details', 
        'payment_terms',
        'terms_conditions_livraison'
    ];

    // Define the relationship with the User model if necessary
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
