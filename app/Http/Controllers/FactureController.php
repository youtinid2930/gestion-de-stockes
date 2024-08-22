<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Fournisseur;
use App\Models\Facture;
use Spatie\Permission\Models\Role;
use Barryvdh\DomPDF\Facade\Pdf as PDF;


class FactureController extends Controller
{
    public function index(Request $request)
    {
        $commandeId = $request->input('commande_id');

        if ($commandeId) {
            // Rechercher les factures associées à la commande spécifique
            $factures = Facture::where('commande_id', $commandeId)->get();
            
            // Récupérer la commande pour obtenir le fournisseur
            $commande = Commande::find($commandeId);
            $fournisseur = $commande ? $commande->fournisseur : null; // Assurez-vous que la relation est correctement définie
        } else {
            $factures = Facture::all(); // Affiche toutes les factures si aucune commande n'est sélectionnée
            $fournisseur = null;
        }

        return view('factures.index', compact('factures', 'fournisseur'));
    }

    public function create()
    {
        $fournisseurs = Fournisseur::all(); // Récupérer tous les fournisseurs
        return view('factures.create', compact('fournisseurs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero_facture' => 'required|unique:factures,numero_facture',
            'date_facture' => 'required|date',
            'montant_total' => 'required|numeric',
            'client' => 'required|string|max:255',
        ]);

        Facture::create([
            'numero_facture' => $request->numero_facture,
            'date_facture' => $request->date_facture,
            'montant_total' => $request->montant_total,
            'client' => $request->client,
            'description' => $request->description,
        ]);

        return redirect()->route('factures.index')->with('success', 'Facture créée avec succès.');
    }
    public function destroy($id)
    {
        $facture = Facture::find($id);
        if ($facture) {
            $facture->delete();
            return redirect()->route('factures.index')->with('success', 'Facture supprimée avec succès.');
        }
        return redirect()->route('factures.index')->with('error', 'Facture non trouvée.');
    }

    public function edit($id)
    {
        $facture = Facture::find($id);

        if ($facture) {
            return view('factures.edit', compact('facture'));
        }
        return redirect()->route('factures.index')->with('error', 'Facture non trouvée.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'numero_facture' => 'required|string|max:255',
            'date_facture' => 'required|date',
            'montant_total' => 'required|numeric',
            'client' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $facture = Facture::find($id);

        if ($facture) {
            $facture->update([
                'numero_facture' => $request->input('numero_facture'),
                'date_facture' => $request->input('date_facture'),
                'montant_total' => $request->input('montant_total'),
                'client' => $request->input('client'),
                'description' => $request->input('description'),
            ]);

            return redirect()->route('factures.index')->with('success', 'Facture mise à jour avec succès.');
        }

        return redirect()->route('factures.index')->with('error', 'Facture non trouvée.');
    }
    public function print($id)
    {
        // Trouver la facture par son ID
        $facture = Facture::find($id);

        // Vérifier si la facture existe
        if ($facture) {
            $pdf = PDF::loadView('factures.pdf', compact('facture'));
            return $pdf->download('facture-' . $facture->numero_facture . '.pdf');
        }
        return redirect()->route('factures.index')->with('error', 'Facture non trouvée.');
    }
    public function show($id)
    {
        $facture = Facture::findOrFail($id);

        // Récupérer la commande associée à la facture pour obtenir le fournisseur
        $commande = $facture->commande;
        $fournisseur = $commande ? $commande->fournisseur : null;

        return view('factures.show', compact('facture', 'fournisseur'));
    }



}
