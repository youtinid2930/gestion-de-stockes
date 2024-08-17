<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'last_name', 'email', 'password', 'remember_token', 
        'id_role', 'etat', 'telephone', 'adresse', 'derniere_login', 
        'location'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'derniere_login' => 'datetime',
    ];

    

    // Relationship with Commande (admin or gestionnaire creating the commande)
    public function commandes()
    {
        return $this->hasMany(Commande::class, 'admin_id');
    }

    // Relationship with Commande (admin or gestionnaire managing the commande)
    public function commandesGestionnaire()
    {
        return $this->hasMany(Commande::class, 'gestionnaire_id');
    }

    // Relationship with Demande (gestionnaire making the demande)
    public function demandes()
    {
        return $this->hasMany(Demande::class, 'gestionnaire_id');
    }

    // Relationship with Article through Commande (commande details)
    public function articles()
    {
        return $this->hasManyThrough(
            Article::class,
            Commande::class,
            'admin_id', // Foreign key on Commande table
            'id', // Foreign key on Article table
            'id', // Local key on User table
            'id_article' // Local key on Commande table
        );
    }

    
    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }


}
