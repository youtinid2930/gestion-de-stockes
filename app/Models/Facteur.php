<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facteur extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number','issue_date','fournisseur_id','commande_id','total_amount','amount_paid','status','comments',
    ];
    protected $casts = [
        'due_date' => 'datetime',  // Convertir date_facture en objet Carbon
        'issue_date' => 'datetime',
    ];
    
    public $timestamps = true;

    
    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class, 'fournisseur_id'); // Assurez-vous que 'fournisseur_id' est le nom correct de la colonne
    }
    
public function commande()
{
    return $this->belongsTo(Commande::class, 'commande_id');
}




}
