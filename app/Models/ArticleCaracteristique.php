<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleCaracteristique extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id', 'caracteristique_id', 'valeur'
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function caracteristique()
    {
        return $this->belongsTo(Caracteristique::class);
    }
}
