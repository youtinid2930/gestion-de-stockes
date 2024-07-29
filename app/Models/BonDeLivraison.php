<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonDeLivraison extends Model
{
    use HasFactory;

    protected $fillable = [
        'demande_id', 'magasinier_id', 'comments'
    ];

    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }

    public function magasinier()
    {
        return $this->belongsTo(User::class, 'magasinier_id');
    }

    public function bonDeLivraisonDetails()
    {
        return $this->hasMany(BonDeLivraisonDetail::class);
    }
}
