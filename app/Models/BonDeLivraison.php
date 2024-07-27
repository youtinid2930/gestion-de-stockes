<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonDeLivraison extends Model
{
    use HasFactory;
    protected $fillable = ['demande_id', 'magasinier_id'];

    // A bon de livraison is for a demande
    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }

    // A bon de livraison is created by a magasinier
    public function magasinier() 
    {
        return $this->belongsTo(User::class, 'magasinier_id');
    }
}
