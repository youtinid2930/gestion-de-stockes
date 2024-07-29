<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caracteristique extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function articleCaracteristiques()
    {
        return $this->hasMany(ArticleCaracteristique::class);
    }
}
