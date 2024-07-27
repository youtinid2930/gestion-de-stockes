<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;
    protected $fillable = ['gestionnaire_id', 'employe_id'];

    // A demande is managed by a gestionnaire
    public function gestionnaire()
    {
        return $this->belongsTo(User::class, 'gestionnaire_id');
    }

    // A demande is made by an employee
    public function employe()
    {
        return $this->belongsTo(User::class, 'employe_id');
    }

    // A demande can have many details
    public function demandeDetails()
    {
        return $this->hasMany(DemandeDetail::class);
    }
}
