<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depot extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'adresse','type'];

    public function depotArticles()
    {
        return $this->hasMany(DepotArticle::class);
    }
}
