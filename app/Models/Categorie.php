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
        return $this->hasMany(Article::class, 'category_id');
    }

    public function caracteristiques() {
        return $this->belongsToMany(Caracteristique::class, 'categorie_caracteristique', 'category_id', 'caracteristique_id');
    }
    public function getFinalSubcategory()
    {
        // If the category has no children, it's the final subcategory
        if ($this->sousCategories()->count() === 0) {
            return $this;
        }

        // If it has children, recursively find the final subcategory
        foreach ($this->sousCategories as $child) {
            return $child->getFinalSubcategory();
        }
    }
}
