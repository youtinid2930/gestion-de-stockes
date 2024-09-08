<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Fournisseur;
use App\Models\Article;
use App\Models\CommandeDetail;
use App\Models\BonDeLivraisonDetail;
use App\Models\BonDeLivraison;
use App\Models\Facteur;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = Commande::with('fournisseur', 'commandeDetails.article','factures')->get();
        $fournisseurs = Fournisseur::all();
        
        return view('commande.index', compact('commandes', 'fournisseurs'));
    }

    public function create()
    {
        $fournisseurs = Fournisseur::all();
        $allArticles = Article::all();
        return view('commande.create', compact('fournisseurs', 'allArticles'));
    }

    public function store(Request $request)
    {
        
        // Validation des données
        $validated = $request->validate([
            'id_fournisseur' => 'required|exists:fournisseurs,id',
            'articles.*.quantite' => 'required|integer|min:1',
            'articles.*.prix' => 'required|numeric',
            'articles.*.id_article' => 'required|exists:articles,id',
            'articles.*.quantite' => 'required|integer|min:1',
        ]);

        // Ajout de l'admin_id dans les données validées
        $validated['admin_id'] = auth()->user()->id;
        $commandeExist = Commande::where('fournisseur_id',$validated['id_fournisseur'])
            ->where('status','En attente')
            ->first();
        // Création de la commande
        $commande = new Commande();
        $commande->fournisseur_id = $validated['id_fournisseur'];
        $commande->admin_id = $validated['admin_id'];
        $commande->save();

        foreach ($request->articles as $articleData) {
            $article = Article::find($articleData['id_article']);
            $price = $article->unit_price * $articleData['quantite'];

            $commande->commandeDetails()->create([
                'article_id' => $articleData['id_article'],
                'quantite' => $articleData['quantite'],
                'prix' => $price,
            ]);
        }
        
        if($commandeExist) {
            $bondelivraison = BonDeLivraisonDetail::where('commande_id',$commandeExist->id)
                ->first();
            
            BonDeLivraisonDetail::create([
                'bon_de_livraison_id' => $bondelivraison->bon_de_livraison_id,
                'commande_id' => $commande->id,
            ]);
        }
        else {
            // Automatically create a BonDeLivraison
            $bonDeLivraison = new BonDeLivraison();
            $bonDeLivraison->date_livraison = now(); // Current date and time
            $bonDeLivraison->user_id = auth()->user()->id; // Current authenticated user
            $bonDeLivraison->save();

            // Create BonDeLivraisonDetails for each article in the commande
            $bonDeLivraison->bonDeLivraisonDetails()->create([
                'commande_id' => $commande->id,
            ]);
        }
        

        return redirect()->route('commande.index')->with('message', ['text' => 'Commande ajoutée avec succès', 'type' => 'success']);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_fournisseur' => 'required|exists:fournisseurs,id',
            'articles.*.id_article' => 'required|exists:articles,id',
            'articles.*.quantite' => 'required|integer|min:1',
        ]);

        $commande = Commande::findOrFail($id);
        $commande->update([
            'fournisseur_id' => $validated['id_fournisseur'],
        ]);

        // Supprime les détails existants et remplace-les par les nouveaux
        $commande->commandeDetails()->delete();
        foreach ($request->articles as $articleData) {
            $article = Article::find($articleData['id_article']);
            $price = $article->unit_price * $articleData['quantite'];

            $commande->commandeDetails()->create([
                'article_id' => $articleData['id_article'],
                'quantite' => $articleData['quantite'],
                'prix' => $price,
            ]);
        }

        return redirect()->route('commande.index')->with('message', ['text' => 'Commande mise à jour avec succès', 'type' => 'success']);
    }

    public function show($id)
    {
        $commande = Commande::with('fournisseur', 'commandeDetails.article')->findOrFail($id);
        return view('commande.show', compact('commande'));
    }

    public function destroy($id)
    {
        $commandes = Commande::with('commandeDetails','bonDeLivraisondetails')
            ->where('id',$id)
            ->get();
        foreach ($commandes as $commande) {
            $commande->commandeDetails()->delete();
            $commande->bonDeLivraisondetails()->delete();
            $commande->delete();  
        }

        return redirect()->route('commande.index')->with('message', ['text' => 'Commande annulée avec succès', 'type' => 'success']);
    }

    public function edit($id)
    {
        $commande = Commande::findOrFail($id);
        $fournisseurs = Fournisseur::all();
        $articles = Article::all(); // Vous devez aussi passer tous les articles pour l'édition
        return view('commande.edit', compact('commande', 'fournisseurs', 'articles'));
    }
    public function createLivraison()
    {
    $commandes = Commande::all(); // Récupère toutes les commandes
    return view('livraison.create', compact('commandes')); // Passe les commandes à la vue
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        $articleName = $request->input('article_name');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $status = $request->input('status');

        $commandes = Commande::with('fournisseur', 'commandeDetails.article')
            ->when($query, function ($q) use ($query) {
                // Recherche par ID
                $q->where('id', 'LIKE', "%$query%");
                
                // Recherche par nom de fournisseur
                $q->orWhereHas('fournisseur', function ($queryFournisseur) use ($query) {
                    $queryFournisseur->where('name', 'LIKE', "%$query%");
                });
                
                // Recherche par nom d'article
                $q->orWhereHas('commandeDetails.article', function ($queryArticle) use ($query) {
                    $queryArticle->where('name', 'LIKE', "%$query%");
                });
            })
            ->when($status, function ($q) use ($status) {
                // Recherche par status
                $q->where('status', $status);
            })
            ->when($dateFrom && $dateTo, function ($q) use ($dateFrom, $dateTo) {
                // Recherche par date
                $q->whereBetween('created_at', [$dateFrom, $dateTo]);
            })
            ->get();


        // Vérifie les résultats de la requête

        return view('commande.index', compact('commandes'));
    }

}
