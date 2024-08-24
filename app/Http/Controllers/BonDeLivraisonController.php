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
        $bonsDeLivraison = BonDeLivraison::with('bonDeLivraisonDetails.demande')->get();
        return view('bons_de_livraison.index', compact('bonsDeLivraison'));
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
       $demande = Demande::where('delivery_address', $validated['demande_id'])->firstOrFail();
   
       // Create the BonDeLivraison (Delivery Note)
       $bonDeLivraison = BonDeLivraison::create([
           'date_livraison' => $validated['date_livraison'],
           'user_id' => $user->id,
       ]);
   
       // Iterate through the demande details and handle the articles
       foreach ($demande->demandeDetails as $detail) {
           $availableQuantity = DepotArticle::where('article_id', $detail->article_id)->sum('quantity');
   
           if ($availableQuantity >= $detail->quantity) {
               // Update the depot article stock (subtract the delivered quantity)
               DepotArticle::where('article_id', $detail->article_id)
                   ->decrement('quantity', $detail->quantity);
   
               // Create a record in the bon_de_livraison_details table
               BonDeLivraisonDetail::create([
                   'bon_de_livraison_id' => $bonDeLivraison->id,
                   'demande_id' => $validated['demande'],
               ]);
           } else {
               // Handle the case where the requested quantity exceeds available stock
               return back()->withErrors([
                   'error' => "La quantité demandée pour l'article {$detail->article->name} dépasse la quantité disponible."
               ]);
           }
       }
   
       // Update the status of the demande to indicate it has been delivered
       $demande->status = 'Livrée';
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