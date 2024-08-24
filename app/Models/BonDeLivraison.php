<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BonDeLivraison extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero', 'date_livraison','status','user_id'
    ];

    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($livraison) {
            $latestNumber = self::max('numero'); // Get the latest numero
            $number = 1;

            if ($latestNumber) {
                $latestNumber = str_replace('LIV-', '', $latestNumber);
                $number = intval($latestNumber) + 1;
            }

            $livraison->numero = 'LIV-' . str_pad($number, 3, '0', STR_PAD_LEFT);
        });
    }
    public function bonDeLivraisonDetails()
    {
        return $this->hasMany(BonDeLivraisonDetail::class, 'bon_de_livraison_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}