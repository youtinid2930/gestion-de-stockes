<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facteur extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number', 'issue_date', 'due_date', 'fournisseur_id', 'commande_id', 'total_amount', 'amount_paid', 'status', 'comments'
    ];

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function facteurDetails()
    {
        return $this->hasMany(FacteurDetail::class);
    }
}
