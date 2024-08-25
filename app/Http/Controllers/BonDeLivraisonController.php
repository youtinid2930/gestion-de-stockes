<?php

namespace App\Http\Controllers;

use App\Models\BonDeLivraison;
use App\Models\BonDeLivraisonDetail;
use App\Models\Demande;
use Illuminate\Http\Request;
use App\Models\DepotArticle;
use Illuminate\Support\Facades\Auth;

class BonDeLivraisonController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if($user->hasRole('admin')) {
            // pour les commandes
            $bonsDeLivraisonCommande = BonDeLivraison::with('bonDeLivraisonDetails.commande')
                ->where('user_id',$user->id)
                ->whereHas('bonDeLivraisonDetails.commande', function ($query) {
                    $query->whereNull('demande_id');
                })
                ->get();
            // pour les demandes
            $bonsDeLivraisonDemande = BonDeLivraison::with('bonDeLivraisonDetails.demande')
                ->where('user_id',$user->id)
                ->whereHas('bonDeLivraisonDetails.demande', function ($query) {
                    $query->whereNull('commande_id');
                })
                ->get();
            return view('bons_de_livraison.index', compact('bonsDeLivraisonCommande', 'bonsDeLivraisonDemande'));
        }
        else if($user->hasRole('magasinier')) {
            $meBonsDeLivraison = BonDeLivraison::with('bonDeLivraisonDetails.demande')
                ->where('user_id',$user->id)
                ->get();
            $bonDeLivraisonrecus = BonDeLivraison::with('bonDeLivraisonDetails.demande')
                ->whereHas('bonDeLivraisonDetails.demande', function ($query) use ($user) {
                    $query->where('delivery_address', $user->depot->adresse);
                })
                ->whereHas('user', function ($query) {
                    $query->whereHas('roles', function ($query) {
                        $query->where('name', 'admin');
                    });
                })
                ->get();
            return view('bons_de_livraison.index', compact('meBonsDeLivraison', 'bonDeLivraisonrecus'));
        }
        else {
            $bonDeLivraisonrecus = BonDeLivraison::with('bonDeLivraisonDetails.demande')
                ->whereHas('bonDeLivraisonDetails.demande', function ($query) use ($user) {
                    $query->where('delivery_address', $user->depot->adresse);
                })
                ->whereHas('user', function ($query) {
                    $query->whereHas('roles', function ($query) {
                        $query->where('name', 'magasinier');
                    });
                })
                ->get();
            return view('bons_de_livraison.index', compact('bonDeLivraisonrecus'));
        }

    }

    public function create()
    {
        $user = Auth::user();
        if($user->hasRole('admin')) {
            $demandes = Demande::with('magasinier')
                ->whereNull('gestionnaire_id')
                ->where('status', '!=', 'Complétée')
                ->get();
        } else {
            $demandes = Demande::with('gestionnaire')
            ->whereNull('admin_id')
            ->where('status', '!=', 'Complétée')
            ->get();
        }

        $demandesUnique = $demandes->unique(function ($item) {
            return $item->delivery_address;
        });


        return view('bons_de_livraison.create', ['demandes' => $demandesUnique]);
    }

    public function getDemandes($deliveryAddress)
    {
    // Fetch demandes based on the recipient
    $user = Auth::user();
    if($user->hasRole('admin')) {
        $demandes = Demande::with('demandeDetails.article')
        ->where('delivery_address', $deliveryAddress)
        ->whereNull('gestionnaire_id')
        ->where('status', '!=', 'Complétée')
        ->get();
    } else {
        $demandes = Demande::with('demandeDetails.article')
        ->where('delivery_address', $deliveryAddress)
        ->where('status', '!=', 'Complétée')
        ->whereNull('admin_id')
        ->get();
    }

    $depotArticles = DepotArticle::with('article')->get()->keyBy('article_id');

    // Load the view for the table content
    return view('bons_de_livraison.partials.demandes_table', compact('demandes','depotArticles'));
   }

   public function store(Request $request)
{
    $user = Auth::user();
    // Validate the incoming request data
    $validated = $request->validate([
        'demande_id' => 'required',
        'date_livraison' => 'required|date',
        'demande' => 'nullable|exists:demandes,id'
    ]);

    // Get the demande (request) based on the selected delivery address
    $demande = Demande::findOrFail($validated['demande_id']);
    // Create the BonDeLivraison (Delivery Note)
    $bonDeLivraison = BonDeLivraison::create([
        'date_livraison' => $validated['date_livraison'],
        'user_id' => $user->id,
    ]);
    // Iterate through the demande details and handle the articles
    foreach ($demande->demandeDetails as $detail) {
        $availableQuantity = DepotArticle::where('article_id', $detail->article_id)->sum('quantity');
        $quantityToDeliver = min($availableQuantity, $detail->quantity);

        // Handle the quantity to deliver
        if ($quantityToDeliver > 0) {
            // Update the depot article stock
            DepotArticle::where('article_id', $detail->article_id)
                ->decrement('quantity', $quantityToDeliver);
            // Create a record in the bon_de_livraison_details table
            BonDeLivraisonDetail::create([
                'bon_de_livraison_id' => $bonDeLivraison->id,
                'demande_id' => $validated['demande'],
            ]);

            // Update the demande detail
            $detail->quantity_livree += $quantityToDeliver;
            $detail->quantity_restant = max(0, $detail->quantity - $quantityToDeliver);
            $detail->save();
        }

        // Handle the case where the requested quantity exceeds available stock
        if ($quantityToDeliver < $detail->quantity) {
            BonDeLivraisonDetail::create([
                'bon_de_livraison_id' => $partialDelivery->id,
                'demande_id' => $validated['demande'],
            ]);
            $detail->quantity_restant = $detail->quantity - $quantityToDeliver;
            $detail->save();
        }
    }

    // Update the status of the demande to indicate it has been delivered if fully delivered
    $demande->status = $demande->demandeDetails->sum('quantity_restant') > 0 ? 'Livrée partiellement' : 'Livrée';
    $demande->save();

    // Redirect back with a success message
    return redirect()->route('bons_de_livraison.index')->with('message', [
        'type' => 'success',
        'text' => 'Le bon de livraison a été créé avec succès.',
    ]);
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