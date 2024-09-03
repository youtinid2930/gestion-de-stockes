<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Fournisseur;
use App\Models\Facteur;
use App\Models\FacteurDetails;
use App\Models\StockMovement;
use Spatie\Permission\Models\Role;
use Barryvdh\DomPDF\Facade\Pdf as PDF;


class FacteurController extends Controller
{
    public function index()
   {
    // Fetch all facteurs with related commande and fournisseur data
    $facteurs = Facteur::with(['commande', 'fournisseur'])->get();

    // Pass the data to the view
    return view('factures.index', compact('facteurs'));
    }

    public function create($id)
    {
        $commande = Commande::with('commandeDetails')->where('id', $id)->first();
        $movement = StockMovement::where('commande_id',$id)->first();
        $issue_date = $movement->created_at;
        return view('Factures.create', compact('commande','issue_date'));
    }

    public function store(Request $request, $id)
   {
    // Validation des données d'entrée
    $request->validate([
        'due_date' => 'required|date',
        'amount_paid' => 'required|numeric',
        'status' => 'required|in:Payée,Partiellement payée,Échue',
        'description' => 'nullable|string',
    ]);
   
    // Récupération de la commande
    $commande = Commande::with('commandeDetails')->where('id', $id)->first();

    if (!$commande) {
        return redirect()->back()->withErrors(['error' => 'Commande non trouvée']);
    }

    // Récupération du mouvement de stock pour la date d'émission
    $movement = StockMovement::where('commande_id', $id)->first();
    $issue_date = $movement ? $movement->created_at : now(); // Utilisez la date de création ou la date actuelle

    $lastFacteur = Facteur::latest('id')->first();
    $nextInvoiceNumber = $lastFacteur ? 'INV-' . str_pad(substr($lastFacteur->invoice_number, 4) + 1, 4, '0', STR_PAD_LEFT) : 'INV-0001';
    // Calcul du montant total de la commande
    $total_amount = $commande->commandeDetails->sum(function ($detail) {
        return $detail->quantite * $detail->article->unit_price;
    });
     

    $facteur = new Facteur();

    $facteur->invoice_number = $nextInvoiceNumber;
    $facteur->issue_date = $issue_date;
    $facteur->due_date = $request['due_date'];
    $facteur->fournisseur_id = $commande->fournisseur_id;
    $facteur->commande_id = $commande->id;
    $facteur->total_amount = $total_amount;
    $facteur->amount_paid = $request->input('amount_paid');
    $facteur->status = $request->input('status');
    $facteur->comments = $request->input('description');

    $facteur->save();

    // Création des détails de la facture
    foreach ($commande->commandeDetails as $detail) {
        $facteurdetail = new FacteurDetails();

        $facteurdetail->facteur_id = $facteur->id;
        $facteurdetail->article_id = $detail->article_id;
        $facteurdetail->quantity = $detail->quantite;

        $facteurdetail->save();
    }

    return redirect()->route('facteurs.index')->with('success', 'Facture créée avec succès.');
    }

        
    public function destroy($id)
    {
        $Facteur = Facteur::find($id);
        if ($Facteur) {
            $Facteur->delete();
            return redirect()->route('Facteurs.index')->with('success', 'Facteur supprimée avec succès.');
        }
        return redirect()->route('Facteurs.index')->with('error', 'Facteur non trouvée.');
    }

    public function edit($id)
    {
        $Facteur = Facteur::find($id);

        if ($Facteur) {
            $fournisseurs = Fournisseur::all(); // Récupérer tous les fournisseurs
            return view('Facteurs.edit', compact('Facteur', 'fournisseurs'));
        }
        return redirect()->route('Facteurs.index')->with('error', 'Facteur non trouvée.');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'numero_Facteur' => 'required|string|max:255',
            'date_Facteur' => 'required|date',
            'montant_total' => 'required|numeric',
            'fournisseur' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $Facteur = Facteur::find($id);

        if ($Facteur) {
            $Facteur->update([
                'numero_Facteur' => $request->input('numero_Facteur'),
                'date_Facteur' => $request->input('date_Facteur'),
                'montant_total' => $request->input('montant_total'),
                'fournisseur' => $request->input('fournisseur'),
                'description' => $request->input('description'),
            ]);

            return redirect()->route('Facteurs.index')->with('success', 'Facteur mise à jour avec succès.');
        }

        return redirect()->route('Facteurs.index')->with('error', 'Facteur non trouvée.');
    }
    public function print($id)
    {
        // Trouver la Facteur par son ID
        $Facteur = Facteur::find($id);

        // Vérifier si la Facteur existe
        if ($Facteur) {
            $pdf = PDF::loadView('Facteurs.pdf', compact('Facteur'));
            return $pdf->download('Facteur-' . $Facteur->numero_Facteur . '.pdf');
        }
        return redirect()->route('Facteurs.index')->with('error', 'Facteur non trouvée.');
    }
    public function show($id)
    {
        $Facteur = Facteur::findOrFail($id);

        // Récupérer la commande associée à la Facteur pour obtenir le fournisseur
        $commande = $Facteur->commande;
        $fournisseur = $commande ? $commande->fournisseur : null;

        return view('Facteurs.show', compact('Facteur', 'fournisseur'));
    }





}
