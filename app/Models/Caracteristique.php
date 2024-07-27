<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caracteristique extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    // A caracteristique can belong to many articles
    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_caracteristique')->withPivot('valeur');
    }
}
