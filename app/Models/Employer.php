<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;

    // If necessary, specify the table name if it's not 'employers'
    protected $table = 'employers';

    // Specify the fillable fields for mass assignment
    protected $fillable = ['first_name', 'second_name', 'department', 'contact'];

    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }
}
