<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'unit_price', 'sku', 'serial_number', 'batch_number', 'combined_code', 'category_id'
    ];
    
    protected $dates = ['date_de_fabrication', 'date_d_expiration'];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            $article->sku = static::generateSku($article);
            $article->serial_number = static::generateSerialNumber();
            $article->batch_number = static::generateBatchNumber();
            $article->combined_code = static::generateCombinedCode($article);
        });

        static::updating(function ($article) {
            $article->combined_code = static::generateCombinedCode($article);
        });
    }

    public static function generateSku($article)
    {
        $locationCode = strtoupper(substr($article->location, 0, 3));
        $uniqueId = str_pad($article->id ?? Article::max('id') + 1, 4, '0', STR_PAD_LEFT); 
        return "{$locationCode}{$uniqueId}";
    }

    public static function generateSerialNumber()
    {
        return 'SN' . strtoupper(uniqid());
    }

    public static function generateBatchNumber()
    {
        return 'BATCH' . date('Ymd');
    }

    public static function generateCombinedCode($article)
    {
        
        return "{$article->sku}-{$article->serial_number}-{$article->batch_number}";
    }

    public function category()
    {
        return $this->belongsTo(Categorie::class);
    }
    
    public function articleCaracteristiques()
    {
        return $this->hasMany(ArticleCaracteristique::class, 'article_id');
    }

    
    public function characteristics()
    {
        return $this->belongsToMany(Caracteristique::class, 'article_caracteristiques')
                    ->withPivot('valeur');
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

    public function user()
    {
    return $this->belongsTo(User::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function depots()
    {
    return $this->hasMany(DepotArticle::class);
    }

    public function details()
    {
        return $this->hasMany(FacteurDetails::class, 'article_id');
    }

    public function depotArticles()
    {
        return $this->hasMany(DepotArticle::class);
    }
}
