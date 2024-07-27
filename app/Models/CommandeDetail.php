<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandeDetail extends Model
{
    use HasFactory;
    protected $fillable = ['commande_id', 'article_id', 'quantite'];

    // A commande detail belongs to a commande
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    // A commande detail is for an article
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
