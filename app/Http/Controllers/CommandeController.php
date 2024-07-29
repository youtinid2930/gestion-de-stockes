<?php
namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Fournisseur;
use App\Models\Users;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = Commande::with('fournisseur','users')->get();
        $fournisseurs = Fournisseur::all();

        return view('commande', compact('commandes', 'fournisseurs'));
    }

    public function create()
    {
        $fournisseurs = Fournisseur::all();
        return view('commande.create', compact('fournisseurs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_fournisseur' => 'required|exists:fournisseurs,id',
            'quantite' => 'required|integer',
            'prix' => 'required|numeric',
        ]);

        Commande::create($validated);

        return redirect()->route('commande.index')->with('message', ['text' => 'Commande ajoutée avec succès', 'type' => 'success']);
    }

    public function show($id)
    {
        $commande = Commande::with('fournisseur')->findOrFail($id);
        return view('commande.show', compact('commande'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_fournisseur' => 'required|exists:fournisseurs,id',
            'quantite' => 'required|integer',
            'prix' => 'required|numeric',
        ]);

        $commande = Commande::findOrFail($id);
        $commande->update($validated);

        return redirect()->route('commande.index')->with('message', ['text' => 'Commande mise à jour avec succès', 'type' => 'success']);
    }

    public function destroy(Request $request)
    {
        $idCommande = $request->query('idCommande');
        $quantite = $request->query('quantite');

        $commande = Commande::findOrFail($idCommande);
        $commande->delete();

        // Update any related inventory here

        return redirect()->route('commande.index')->with('message', ['text' => 'Commande annulée avec succès', 'type' => 'success']);
    }
}

