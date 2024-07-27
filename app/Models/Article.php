<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'categorie_id'];

    // An article belongs to a category
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    // An article can have many caracteristiques
    public function caracteristiques()
    {
        return $this->belongsToMany(Caracteristique::class, 'article_caracteristique')->withPivot('valeur');
    }

    // An article can be part of many stocks
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}
