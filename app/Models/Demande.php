<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;

    protected $fillable = [
        'gestionnaire_id', 'article_id', 'quantity', 'notes', 'status', 'delivery_address'
    ];

    public function gestionnaire()
    {
        return $this->belongsTo(User::class, 'gestionnaire_id');
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function demandeDetails()
    {
        return $this->hasMany(DemandeDetail::class);
    }

    public function bonDeLivraisons()
    {
        return $this->hasMany(BonDeLivraison::class);
    }
}
