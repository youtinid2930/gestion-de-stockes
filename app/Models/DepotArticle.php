<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepotArticle extends Model
{
    use HasFactory;
    protected $fillable = [
        'article_id',
        'depot_id',
        'quantity',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function depot()
    {
        return $this->belongsTo(Depot::class);
    }
}
