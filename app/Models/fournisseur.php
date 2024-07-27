<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fournisseur extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'address', 'phone'];

    // A fournisseur can provide many commandes
    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }

    // A fournisseur can issue many factures
    public function factures()
    {
        return $this->hasMany(Facture::class);
    }
}
