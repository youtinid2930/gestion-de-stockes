<?php

namespace App\Http\Controllers;

use App\Models\BonDeLivraison;
use App\Models\Demande;
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
        $demandes = Demande::all();
        return view('bons_de_livraison.create', compact('demandes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required|string|max:255',
            'date_livraison' => 'required|date',
            'adresse_livraison' => 'required|string',
            'demande_id' => 'required|exists:demandes,id',
        ]);

        BonDeLivraison::create($request->all());

        return redirect()->route('bons_de_livraison.index')
                     ->with('message', ['type' => 'success', 'text' => 'Bon de livraison ajouté avec succès']);
    }

    public function edit($id)
    {
        $bonDeLivraison = BonDeLivraison::findOrFail($id);
        $demandes = Demande::all();
        return view('bons_de_livraison.edit', compact('bonDeLivraison', 'demandes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'numero' => 'required|string|max:255',
            'date_livraison' => 'required|date',
            'adresse_livraison' => 'required|string',
            'commande_id' => 'required|exists:demandes,id',
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