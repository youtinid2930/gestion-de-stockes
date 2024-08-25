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
        $depotArticles = DepotArticle::where('depot_id', $user->depot_id)->get()->keyBy('article_id');
    
        if ($user->hasRole('admin')) {
            $demandes = Demande::with('demandeDetails.article')
                ->where('delivery_address', $deliveryAddress)
                ->whereNull('gestionnaire_id')
                ->where(function ($query) {
                    $query->where('status', 'En cours de traitement')
                        ->orWhere('status', 'Livrée partiellement');
                })
                ->get();
    
            // Filter the demandes based on quantity restant and available quantity
            $demandes = $demandes->filter(function ($demande) use ($depotArticles) {
                if ($demande->status === 'Livrée partiellement') {
                    // Filter demandeDetails with quantity_restant > 0 and stock quantity > 0
                    $demande->demandeDetails = $demande->demandeDetails->filter(function ($detail) use ($depotArticles) {
                        $availableQuantity = $depotArticles->get($detail->article_id)->quantity ?? 0;
                        return $detail->quantity_restant > 0 && $availableQuantity > 0;
                    });
    
                    // Include the demande only if it has any demandeDetails left
                    return $demande->demandeDetails->isNotEmpty();
                }
    
                // For 'En cours de traitement', filter details where stock quantity > 0
                $demande->demandeDetails = $demande->demandeDetails->filter(function ($detail) use ($depotArticles) {
                    $availableQuantity = $depotArticles->get($detail->article_id)->quantity ?? 0;
                    return $availableQuantity > 0;
                });
    
                // Include the demande only if it has any demandeDetails left
                return $demande->demandeDetails->isNotEmpty();
            });
        } else {
            // Fetch demandes with the specified criteria
            $demandes = Demande::with('demandeDetails.article')
                ->where('delivery_address', $deliveryAddress)
                ->where(function ($query) {
                    $query->where('status', 'En cours de traitement')
                        ->orWhere('status', 'Livrée partiellement');
                })
                ->whereNull('admin_id')
                ->get();
    
            // Filter the demandes based on quantity restant and available quantity
            $demandes = $demandes->filter(function ($demande) use ($depotArticles) {
                if ($demande->status === 'Livrée partiellement') {
                    // Filter demandeDetails with quantity_restant > 0 and stock quantity > 0
                    $demande->demandeDetails = $demande->demandeDetails->filter(function ($detail) use ($depotArticles) {
                        $availableQuantity = $depotArticles->get($detail->article_id)->quantity ?? 0;
                        return $detail->quantity_restant > 0 && $availableQuantity > 0;
                    });
    
                    // Include the demande only if it has any demandeDetails left
                    return $demande->demandeDetails->isNotEmpty();
                }
    
                // For 'En cours de traitement', filter details where stock quantity > 0
                $demande->demandeDetails = $demande->demandeDetails->filter(function ($detail) use ($depotArticles) {
                    $availableQuantity = $depotArticles->get($detail->article_id)->quantity ?? 0;
                    return $availableQuantity > 0;
                });
    
                // Include the demande only if it has any demandeDetails left
                return $demande->demandeDetails->isNotEmpty();
            });
        }
    
        // Load the view for the table content
        return view('bons_de_livraison.partials.demandes_table', compact('demandes', 'depotArticles'));
    }
    

   public function store(Request $request)
{
    $user = Auth::user();
    
    // Validate the incoming request data
    $validated = $request->validate([
        'demandes' => 'required|array',
        'demandes.*' => 'exists:demandes,id',
        'date_livraison' => 'required|date',
    ]);

    $demandeIds = $validated['demandes'];
    
    // Create the BonDeLivraison (Delivery Note)
    $bonDeLivraison = BonDeLivraison::create([
        'date_livraison' => $validated['date_livraison'],
        'user_id' => $user->id,
    ]);
    foreach ($demandeIds as $demandeId) {
        $demande = Demande::findOrFail($demandeId);
        // Iterate through the demande details and handle the articles
        foreach ($demande->demandeDetails as $detail) {
            $availableQuantity = DepotArticle::where('depot_id', $user->depot_id)->where('article_id', $detail->article_id)->sum('quantity');
            if(($detail->quantity_restant == 0)&&($detail->quantity_livree == 0)) {
                $quantityToDeliver = min($availableQuantity, $detail->quantity);
            }
            else if (($detail->quantity_restant == 0)&&($detail->quantity_livree > 0)) {
                continue;
            }
            else {
                $quantityToDeliver = min($availableQuantity, $detail->quantity_restant);
            }
            

            // Handle the quantity to deliver
            if ($quantityToDeliver > 0) {
                // Update the depot article stock
                DepotArticle::where('depot_id', $user->depot_id)
                    ->where('article_id', $detail->article_id)
                    ->decrement('quantity', $quantityToDeliver);
                // Create a record in the bon_de_livraison_details table
                BonDeLivraisonDetail::create([
                    'bon_de_livraison_id' => $bonDeLivraison->id,
                    'demande_id' => $demandeId,
                ]);
                $detail->quantity_livree += $quantityToDeliver;
                $detail->quantity_restant -= $quantityToDeliver;
                $detail->save();
            }
        }

        // Update the status of the demande to indicate it has been delivered if fully delivered
        $demande->status = $demande->demandeDetails->sum('quantity_restant') > 0 ? 'Livrée partiellement' : 'Livrée';
        $demande->save();
    }
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