<?php

namespace App\Http\Controllers;

use App\Models\BonDeLivraison;
use App\Models\Commande;
use Illuminate\Http\Request;

class BonDeLivraisonController extends Controller
{
    public function index()
    {
        $bonsDeLivraison = BonDeLivraison::all();
        return view('bons_de_livraison.index', compact('bonsDeLivraison'));
    }

    public function create()
    {
        $commandes = Commande::all();
        return view('bons_de_livraison.create', compact('commandes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required|string|max:255',
            'date_livraison' => 'required|date',
            'adresse_livraison' => 'required|string',
            'commande_id' => 'required|exists:commandes,id',
        ]);

        BonDeLivraison::create($request->all());

        return redirect()->route('bons_de_livraison.index')
                         ->with('message', ['type' => 'success', 'text' => 'Bon de livraison ajouté avec succès']);
    }

    public function edit($id)
    {
        $bonDeLivraison = BonDeLivraison::findOrFail($id);
        $commandes = Commande::all();
        return view('bons_de_livraison.edit', compact('bonDeLivraison', 'commandes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'numero' => 'required|string|max:255',
            'date_livraison' => 'required|date',
            'adresse_livraison' => 'required|string',
            'commande_id' => 'required|exists:commandes,id',
        ]);

        $bonDeLivraison = BonDeLivraison::findOrFail($id);
        $bonDeLivraison->update($request->all());

        return redirect()->route('bons_de_livraison.index')
                         ->with('message', ['type' => 'success', 'text' => 'Bon de livraison modifié avec succès']);
    }

    public function destroy($id)
    {
        $bonDeLivraison = BonDeLivraison::findOrFail($id);
        $bonDeLivraison->delete();

        return redirect()->route('bons_de_livraison.index')
                         ->with('message', ['type' => 'success', 'text' => 'Bon de livraison supprimé avec succès']);
    }
}
