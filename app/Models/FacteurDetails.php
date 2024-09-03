<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacteurDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'facture_id',
        'article_id',
        'quantite',
        'montant_total',
    ];

    public function facture()
    {
        return $this->belongsTo(Facteur::class);
    }
}
