<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'unit_price', 'stock', 'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function characteristics()
    {
        return $this->hasMany(ArticleCaracteristique::class);
    }

    public function commandeDetails()
    {
        return $this->hasMany(CommandeDetail::class);
    }

    public function demandeDetails()
    {
        return $this->hasMany(DemandeDetail::class);
    }

    public function bonDeLivraisonDetails()
    {
        return $this->hasMany(BonDeLivraisonDetail::class);
    }

    public function facteurDetails()
    {
        return $this->hasMany(FacteurDetail::class);
    }
}
