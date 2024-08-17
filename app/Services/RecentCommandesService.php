<?php

namespace App\Services;

use App\Models\Commande;

class RecentCommandesService
{
    /**
     * Get recent commandes.
     *
     * @return mixed
     */
    public function getRecentCommandes()
    {
        return Commande::latest()->take(5)->get();
    }
}
