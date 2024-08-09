<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demande;

class DemandeController extends Controller
{
    public function index()
    {
        $demandes = Demande::all();
        return view('demandes.Tabledemandes', compact('demandes'));
    }

    public function create()
    {
        $demandes = Demande::all();
        return view('demandes.Formulairedemandes');
    }

    public function store(Request $request)
    {
        $request->validate([
            'quantity' => 'required',
            'notes' => 'nullable',
            'status' => 'nullable',
            'delivery_address' => 'nullable',
        ]);

        Demande::create($request->all());

        return redirect()->route('demande.showDemandes')->with('message', [
            'type' => 'success',
            'text' => 'Demande ajoutée avec succès.'
        ]);
    }

    public function edit($id)
    {
        $demande = Demande::findOrFail($id); // Fetch the demande by ID
        return view('demandes.edit', compact('demande')); // Pass the demande to the view
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required',
            'notes' => 'nullable',
            'status' => 'nullable',
            'delivery_address' => 'nullable',
        ]);

        $demande = Demande::findOrFail($id);
        $demande->update($request->all());

        return redirect()->route('demande.showDemandes')->with('message', [
            'type' => 'success',
            'text' => 'Demande mise à jour avec succès.'
        ]);
    }
    public function Table()
    {
        $demandes = Demande::all(); // Récupérer toutes les demandes
        return view('demandes.Tabledemandes', compact('demandes')); // Passer les demandes à la vue
    }
    public function showDemandes()
    {
        $demandes = Demande::all(); // Assurez-vous que vous récupérez les données correctement
        return view('demandes.Formulairedemandes', compact('demandes'));
    }

    public function destroy($id)
    {
        $demande = Demande::findOrFail($id);
        $demande->delete();

        return redirect()->route('demande.showDemandes')->with('message', [
            'type' => 'success',
            'text' => 'Demande supprimée avec succès.'
        ]);
    }

}    

