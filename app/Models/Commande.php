<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;
    protected $fillable = ['admin_id', 'fournisseur_id'];

    // A commande is placed by an admin
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // A commande is placed to a fournisseur
    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    // A commande can have many commande details
    public function commandeDetails()
    {
        return $this->hasMany(CommandeDetail::class);
    }
}
