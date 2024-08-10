<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Fournisseur;
use App\Models\Article;
use App\Models\CommandeDetail;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = Commande::with('fournisseur', 'commandeDetails.article')->get();
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
    $id_admin = auth()->user()->id;
    $validated = $request->validate([
        'id_fournisseur' => 'required|exists:fournisseurs,id',
        'articles.*.id_article' => 'required|exists:articles,id',
        'articles.*.quantite' => 'required|integer|min:1',
    ]);

    $commande = new Commande();
    $commande->fournisseur_id = $request->id_fournisseur;
    $commande->admin_id = $id_admin;
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

    return redirect()->route('commande.index')->with('message', ['text' => 'Commande ajoutée avec succès', 'type' => 'success']);
    }

    public function show($id)
    {
        $commande = Commande::with('fournisseur', 'commandeDetails.article')->findOrFail($id); // Load related details and articles
        return view('commande.show', compact('commande'));
    }

    public function edit($id) {
    // Retrieve the specific commande by its ID
    $commande = Commande::with('fournisseur', 'commandeDetails.article')->findOrFail($id);

    // Retrieve all fournisseurs to populate the dropdown
    $fournisseurs = Fournisseur::all();

    // Retrieve all articles to populate the selection
    $articles = Article::all();

    // Pass the data to the edit view
    return view('commande.edit', compact('commande', 'fournisseurs', 'articles'));
    }

    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'id_fournisseur' => 'required|exists:fournisseurs,id',
        'articles.*.id_article' => 'required|exists:articles,id',
        'articles.*.quantite' => 'required|integer|min:1',
    ]);

    $commande = Commande::findOrFail($id);
    $commande->update(['fournisseur_id' => $request->id_fournisseur]);

    // Delete existing details and replace with the new ones
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

    public function destroy($idCommande)
    {
        $commande = Commande::findOrFail($idCommande);
        $commande->commandeDetails()->delete(); 
        $commande->delete();


        return redirect()->route('commande.index')->with('message', ['text' => 'Commande annulée avec succès', 'type' => 'success']);
    }
}
