<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonDeLivraisonDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'bon_de_livraison_id', 'article_id', 'quantity', 'unit_price'
    ];

    public function bonDeLivraison()
    {
        return $this->belongsTo(BonDeLivraison::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}

