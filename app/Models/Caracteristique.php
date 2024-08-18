<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caracteristique extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function categories() {
        return $this->belongsToMany(Categorie::class, 'categorie_caracteristique', 'caracteristique_id', 'categorie_id');
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_caracteristique')
                    ->withPivot('valeur');
    }
}
