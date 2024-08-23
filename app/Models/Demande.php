<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;

    protected $fillable = [
        'gestionnaire_id', 'magasinier_id', 'admin_id', 'quantity', 'notes', 'status', 'delivery_address'
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

    public function bonDeLivraisonDetails()
    {
        return $this->hasMany(BonDeLivraisonDetail::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }
    public function magasinier()
    {
    return $this->belongsTo(User::class, 'magasinier_id');
    }
    public function admin()
    {
    return $this->belongsTo(User::class, 'admin_id');
    }
}
