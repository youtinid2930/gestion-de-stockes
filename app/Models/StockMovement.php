<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'user_id',
        'commande_id',
        'demande_id',
        'quantity',
        'type',
        'date_movement',
        'notes',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }
}
