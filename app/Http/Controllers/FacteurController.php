<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Commande;
use App\Models\Fournisseur;
use App\Models\Company;
use App\Models\Facteur;
use Illuminate\Support\Facades\Auth;
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
    $total_amount = 0;
    $total_paid = 0;
    $Facteurs = Facteur::where('commande_id',$id)->get();
    $Facteur = null;
    foreach($Facteurs as $facteur) {
        $total_amount = $facteur->total_amount;
        $total_paid += $facteur->amount_paid;
        $Facteur = $facteur;
    }
    $total_paid += $request['amount_paid'];
    if($total_amount>$total_paid) {
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

    return redirect()->route('factures.show', $facteur->commande_id)->with('success', 'Facture créée avec succès.');
    } else {
        return redirect()->route('factures.show', $Facteur->commande_id)->with('error', 'le prix depasse le total a payée');
    }
    }

        
    public function destroy($id)
    {
        $Facteur = Facteur::find($id);
        if ($Facteur) {
            $Facteur->delete();
            return redirect()->route('factures.show', $Facteur->commande_id)->with('success', 'Facteur supprimée avec succès.');
        }
        return redirect()->route('factures.show', $Facteur->commande_id)->with('error', 'Facteur non trouvée.');
    }

    public function edit($id)
    {
        $facture = Facteur::find($id);

        if ($facture) {
            $fournisseurs = Fournisseur::all(); // Récupérer tous les fournisseurs
            return view('factures.edit', compact('facture', 'fournisseurs'));
        }
        return redirect()->route('facteurs.index')->with('error', 'Facteur non trouvée.');
    }


    public function update(Request $request, $id)
    {
        // Validate the request data
    $request->validate([
        'due_date' => 'required|date',
        'amount_paid' => 'required|numeric|min:0',
        'status' => 'required|string|in:Payée,Partiellement payée,Échue',
        'description' => 'nullable|string|max:255',
    ]);
    // Find the facture by ID
    $facture = Facteur::findOrFail($id);
    $total_amount = 0;
    $total_paid = 0;
    $Facteurs = Facteur::where('commande_id',$facture->commande_id)->get();
    $Facteur = null;
    
    foreach($Facteurs as $facteur) {
        $total_amount = $facteur->total_amount;
        $total_paid += $facteur->amount_paid;
        $Facteur = $facteur;
    }
    
    $total_paid += $request['amount_paid'];
    if($total_amount>$total_paid) {
    

    // Update the facture with the new data
    $facture->due_date = $request->input('due_date');
    $facture->amount_paid = $request->input('amount_paid');
    $facture->status = $request->input('status');
    $facture->comments = $request->input('description');

    // Save the changes to the database
    $facture->save();

    // Redirect back to a relevant page (e.g., factures index or a specific commande page)
    return redirect()->route('facteurs.index')->with('success', 'Facture mise à jour avec succès.');
    } else {
    return redirect()->route('factures.show', $Facteur->commande_id)->with('error', 'le prix depasse le total a payée');
    }
    }
    public function show($id)
    {
        $total_paid = 0;
        $Facteurs = Facteur::where('commande_id',$id)->get();
        foreach($Facteurs as $facteur) {
            $total_amount = $facteur->total_amount;
            $total_paid += $facteur->amount_paid;
        }
        

        return view('factures.show', compact('Facteurs','total_amount','total_paid','id'));
    }

    public function showone($id) {

        
        // Retrieve the invoice by ID
        $invoice = Facteur::with('fournisseur','facteurDetails.article')->where('id',$id)->first();
        $subtotal = $invoice->amount_paid;

        $taxes = $subtotal * 0.10;

        $discounts = 5.00;

        $totalAmount = $subtotal + $taxes - $discounts;
        $admin = Auth::user();
        $company = Company::first();

        return view('factures.showone',compact('invoice','admin', 'company','subtotal', 'taxes', 'discounts', 'totalAmount'));
    }

    public function downloadPDF($id)
    {
        $invoice = Facteur::with('fournisseur','facteurDetails.article')->where('id',$id)->first();
        $subtotal = $invoice->amount_paid;

        $taxes = $subtotal * 0.10;

        $discounts = 5.00;

        $totalAmount = $subtotal + $taxes - $discounts;
        $admin = Auth::user();
        $company = Company::first();

        // Preparing data to pass to the view
        $data = [
            'invoice' => $invoice,
            'admin' => $admin,
            'subtotal' => $invoice->facteurDetails->sum(function ($detail) {
                return $detail->quantite * $detail->article->prix_unitaire;
            }),
            'taxes' => $invoice->facteurDetails->sum(function ($detail) {
                return $detail->quantite * $detail->article->prix_unitaire * 0.10; // 10% tax
            }),
            'discounts' => 5.00, // Example: fixed discount, or you can calculate dynamically
            'totalAmount' => $invoice->facteurDetails->sum(function ($detail) {
                return $detail->quantite * $detail->article->prix_unitaire;
            }) * 1.10 - 5.00, // Subtotal + 10% tax - discount
            'company' => $company,
        ];

        // Load the view for the PDF with the data
        $pdf = PDF::loadView('factures.pdf', $data);

        // Download the PDF file
        return $pdf->download('facture-'.$invoice->invoice_number.'.pdf');
    }

}
