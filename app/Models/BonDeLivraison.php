<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonDeLivraison extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero', 'date_livraison','status','user_id'
    ];


    public function bonDeLivraisonDetails()
    {
        return $this->hasMany(BonDeLivraisonDetail::class, 'bon_de_livraison_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}