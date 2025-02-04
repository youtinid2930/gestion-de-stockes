<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonDeLivraisonDetail extends Model
{
    use HasFactory;

    protected $table = 'bon_de_livraison_details';

    protected $fillable = [
        'bon_de_livraison_id', 'commande_id', 'demande_id','quantity_livree','quantity_restant'

    ];
    protected $casts = [
        'quantity_livree' => 'integer',
        'quantity_restant' => 'integer',
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

