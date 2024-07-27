<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleCaracteristique extends Model
{
    use HasFactory;
    protected $table = 'article_caracteristique'; 

    protected $fillable = ['article_id', 'caracteristique_id', 'valeur'];
}
