<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'demande_id', 'article_id','quantity','quantity_livree','quantity_restant'
    ];
    public $timestamps = true;
    
    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
