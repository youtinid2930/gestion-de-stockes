<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacteurDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'facteur_id', 'article_id', 'quantity'
    ];

    public function facteur()
    {
        return $this->belongsTo(Facteur::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
