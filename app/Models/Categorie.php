<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_id'];

    // A category can have many subcategories
    public function sousCategories()
    {
        return $this->hasMany(Categorie::class, 'parent_id');
    }

    // A category belongs to a parent category
    public function parent()
    {
        return $this->belongsTo(Categorie::class, 'parent_id');
    }

    // Relationship to articles
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function caracteristiques() {
        return $this->belongsToMany(Caracteristique::class, 'categorie_caracteristique', 'categorie_id', 'caracteristique_id');
    }
}
