<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Demande extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero','gestionnaire_id', 'magasinier_id', 'admin_id', 'employer_id', 'quantity', 'notes', 'status', 'delivery_address'
    ];
    
    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($demande) {
            $latestNumber = self::max('numero'); // Get the latest numero
            $number = 1;

            if ($latestNumber) {
                $latestNumber = str_replace('DEM-', '', $latestNumber);
                $number = intval($latestNumber) + 1;
            }

            $demande->numero = 'DEM-' . str_pad($number, 3, '0', STR_PAD_LEFT);
        });
    }

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

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }
}
