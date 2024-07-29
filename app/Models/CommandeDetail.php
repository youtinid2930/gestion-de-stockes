<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandeDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'commande_id', 'article_id', 'quantite'
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
