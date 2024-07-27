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
    protected $fillable = ['name', 'email', 'password', 'role', 'telephone', 'adresse', 'departement', 'warehouse_location'];

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
    ];

    // User can create many Demandes
    public function demandes()
    {
        return $this->hasMany(Demande::class, 'gestionnaire_id');
    }

    // User can create many BonsDeLivraison
    public function bonsDeLivraison()
    {
        return $this->hasMany(BonDeLivraison::class, 'magasinier_id');
    }

    // User can create many Commandes
    public function commandes()
    {
        return $this->hasMany(Commande::class, 'admin_id');
    }

    // Determine if the user is an admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Determine if the user is a gestionnaire
    public function isGestionnaire()
    {
        return $this->role === 'gestionnaire';
    }

    // Determine if the user is a magasinier
    public function isMagasinier()
    {
        return $this->role === 'magasinier';
    }
}
