<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Commande;
use Illuminate\Support\Str;
use App\Models\Article;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero','admin_id', 'fournisseur_id', 'status'
    ];

    public $timestamps = true;
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($commande) {
            $latestNumber = self::max('numero'); // Get the latest numero
            $number = 1;

            if ($latestNumber) {
                $latestNumber = str_replace('CMD-', '', $latestNumber);
                $number = intval($latestNumber) + 1;
            }

            $commande->numero = 'CMD-' . str_pad($number, 3, '0', STR_PAD_LEFT);
        });
    }

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
