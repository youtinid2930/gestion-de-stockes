<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = ['article_id', 'quantite'];

    // A stock belongs to an article
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
