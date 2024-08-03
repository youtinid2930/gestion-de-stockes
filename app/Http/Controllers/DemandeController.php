<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demande;

class DemandeController extends Controller
{
    public function index()
    {
        $demandes = Demande::all();
        return view('demande.Tabledemandes', compact('demandes'));
    }

    public function create()
    {
        $demandes = Demande::all();
        return view('demande.Formulairedemandes');
    }

    public function store(Request $request)
    {
        $request->validate([

                'gestionnaire_id' => 'required|integer',
                'article_id' => 'required|integer',
                'quantity' => 'required|integer',
                'notes' => 'required|string|max:255',
                'status' => 'required|string|in:pending,approved,rejected',
                'delivery_address' => 'required|string|max:255',
        ]);

        Demande::create($request->all());

        return redirect()->route('demande.Tabledemandes')
                         ->with('message', ['type' => 'success', 'text' => 'Demande ajouté avec succès']);
    }

    public function edit($id)
    {
        $demande = Demande::findOrFail($id); // Fetch the demande by ID
        return view('demande.edit', compact('demande')); // Pass the demande to the view
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'gestionnaire_id' => 'required|integer',
            'article_id' => 'required|integer',
            'quantity' => 'required|integer',
            'notes' => 'required|string|max:255',
            'status' => 'required|string|in:pending,approved,rejected',
            'delivery_address' => 'required|string|max:255',
        ]);

        $demande = Demande::findOrFail($id);
        $demande->update($request->all());

        return redirect()->route('demande.index')
                         ->with('message', ['type' => 'success', 'text' => 'Demande modifié avec succès']);
    }
    public function Table()
    {
        $demandes = Demande::all(); // Récupérer toutes les demandes
        return view('demande.Tabledemandes', compact('demandes')); // Passer les demandes à la vue
    }
    public function showDemandes()
    {
        $demandes = Demande::all(); // Assurez-vous que vous récupérez les données correctement
        return view('demande.Formulairedemandes', compact('demandes'));
    }

}

