<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;
    protected $fillable = ['commande_id', 'fournisseur_id'];

    // A facture is for a commande
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    // A facture is issued by a fournisseur
    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }
}
