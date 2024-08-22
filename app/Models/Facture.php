<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_facture',
        'date_facture',
        'montant_total',
        'client',
        'description',
    ];
    protected $casts = [
        'date_facture' => 'datetime',  // Convertir date_facture en objet Carbon
    ];

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class, 'fournisseur_id'); // Assurez-vous que 'fournisseur_id' est le nom correct de la colonne
    }
    
public function commande()
{
    return $this->belongsTo(Commande::class, 'commande_id');
}




}
