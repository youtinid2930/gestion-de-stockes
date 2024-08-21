<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facture;
use Barryvdh\DomPDF\Facade\Pdf as PDF;


class FactureController extends Controller
{
    public function index()
    {
        $factures = Facture::all();  // Assurez-vous que cette ligne est correcte
        return view('factures.index', compact('factures'));
    }

    public function create()
    {
        return view('factures.create'); // Créez la vue correspondante
    }


    // Ajoutez d'autres méthodes selon vos besoins (show, edit, update, destroy)
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
        // Trouver la facture par son ID
        $facture = Facture::find($id);

        // Vérifier si la facture existe
        if ($facture) {
            // Retourner la vue d'édition avec la facture
            return view('factures.edit', compact('facture'));
        }

        // Retourner une réponse d'erreur si la facture n'existe pas
        return redirect()->route('factures.index')->with('error', 'Facture non trouvée.');
    }

    /**
     * Met à jour une facture spécifique dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'numero_facture' => 'required|string|max:255',
            'date_facture' => 'required|date',
            'montant_total' => 'required|numeric',
            'client' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Trouver la facture par son ID
        $facture = Facture::find($id);

        // Vérifier si la facture existe
        if ($facture) {
            // Mettre à jour la facture
            $facture->update([
                'numero_facture' => $request->input('numero_facture'),
                'date_facture' => $request->input('date_facture'),
                'montant_total' => $request->input('montant_total'),
                'client' => $request->input('client'),
                'description' => $request->input('description'),
            ]);

            // Retourner une réponse réussie
            return redirect()->route('factures.index')->with('success', 'Facture mise à jour avec succès.');
        }

        // Retourner une réponse d'erreur si la facture n'existe pas
        return redirect()->route('factures.index')->with('error', 'Facture non trouvée.');
    }
    public function print($id)
    {
        // Trouver la facture par son ID
        $facture = Facture::find($id);

        // Vérifier si la facture existe
        if ($facture) {
            // Générer le PDF
            $pdf = PDF::loadView('factures.pdf', compact('facture'));

            // Télécharger le PDF
            return $pdf->download('facture-' . $facture->numero_facture . '.pdf');
        }

        // Rediriger avec un message d'erreur si la facture n'existe pas
        return redirect()->route('factures.index')->with('error', 'Facture non trouvée.');
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        $factures = Facture::where('numero_facture', 'LIKE', '%' . $query . '%')->get();

        return view('factures.index', compact('factures'));
    }
    public function show($id)
    {
        $facture = Facture::findOrFail($id);
        return view('factures.show', compact('facture'));
    }

}
