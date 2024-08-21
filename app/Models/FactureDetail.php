<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactureDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'facture_id',
        'article',
        'quantite',
        'prix_unitaire',
        'montant_total',
    ];

    public function facture()
    {
        return $this->belongsTo(Facture::class);
    }
}
