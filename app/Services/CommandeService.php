<?php

namespace App\Services;

use App\Models\Commande;
use App\Models\CommandeDetail;

class CommandeService
{
    /**
     * Get all commandes with their count.
     *
     * @return array
     */
    public function getAllCommandes()
    {
        $commandes = Commande::all();
        return [
            'nbre' => $commandes->count(),
        ];
    }

    /**
     * Get details of a specific commande.
     *
     * @param int $commandeId
     * @return mixed
     */
    public function getCommandeDetails($commandeId)
    {
        return CommandeDetail::where('commande_id', $commandeId)->get();
    }
}
