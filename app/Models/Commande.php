<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Commande;
use App\Models\Article;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id', 'fournisseur_id', 'status'
    ];

    public $timestamps = true;

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function commandeDetails()
    {
        return $this->hasMany(CommandeDetail::class);
    }
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function factures()
    {
        return $this->hasMany(Facture::class);
    }


    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }
}
