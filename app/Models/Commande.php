<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id', 'fournisseur_id', 'quantite', 'prix', 'date_commande'
    ];

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

    public function facteur()
    {
        return $this->hasOne(Facteur::class);
    }
}
