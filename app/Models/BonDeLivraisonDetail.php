<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonDeLivraisonDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'bon_de_livraison_id', 'commande_id', 'demande_id'
    ];

    public $timestamps = true;

    public function bonDeLivraison()
    {
        return $this->belongsTo(BonDeLivraison::class);
    }

    public function demande()
    {
        return $this->belongsTo(Demande::class, 'demande_id');
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class); 
    }
}

