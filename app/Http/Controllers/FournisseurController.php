<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fournisseur;

class FournisseurController extends Controller
{
    public function index()
    {
        $fournisseurs = Fournisseur::all();
        return view('fournisseur', compact('fournisseurs'));
    }

    public function create()
    {
        return view('fournisseur');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:20',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|max:255',
        ]);

        Fournisseur::create($request->all());

        return redirect()->route('fournisseur.index')
                         ->with('message', ['type' => 'success', 'text' => 'Fournisseur ajouté avec succès']);
    }

    public function edit($id)
{
    $fournisseur = Fournisseur::findOrFail($id); // Fetch the fournisseur by ID
    return view('fournisseur.edit', compact('fournisseur')); // Pass the fournisseur to the view
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:20',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|max:255',
        ]);

        $fournisseur = Fournisseur::findOrFail($id);
        $fournisseur->update($request->all());

        return redirect()->route('fournisseur.index')
                         ->with('message', ['type' => 'success', 'text' => 'Fournisseur modifié avec succès']);
    }
}

