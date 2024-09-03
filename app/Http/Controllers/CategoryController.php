<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Caracteristique;
use App\Models\CategorieCaracteristique;
use App\Models\Article;
use App\Models\BonDeLivraisonDetail;
use App\Models\ArticleCaracteristique;
use Illuminate\Support\Facades\DB;


class CategoryController extends Controller
{
    // Display a listing of the categories
    public function index()
    {
        $categories = Categorie::whereNull('parent_id')->with('sousCategories')->get();
        return view('categories.index', compact('categories'));
    }

    // Show the form for creating a new category
    public function create(Request $request)
    {
        $categories = Categorie::whereNull('parent_id')->with('sousCategories')->get();
        return view('categories.create', compact('categories'));
    }

    // Store a newly created category in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category = new Categorie();
        $category->name = $request->input('name');
        $category->parent_id = $request->input('parent_id');
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    // Show the form for editing the specified category
    public function edit($id)
    {
        $categories = Categorie::whereNull('parent_id')->with('sousCategories')->get();
        $category = Categorie::findOrFail($id);
        return view('categories.edit', compact('category','categories'));
    }

    // Update the specified category in storage
    public function update(Request $request, $id)
    {
        $category = Categorie::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        $category->name = $request->input('name');

        $category->parent_id = $request->input('parent_id');
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    

    public function show($id) {
        $categorie = Categorie::findOrFail($id);
        return view('categories.show', compact('categorie'));
    }    
    public function search(Request $request)
    {
        $query = $request->input('query');
        // Filtrer les catégories par nom
        $categories = Categorie::where('name', 'LIKE', "%$query%")->whereNull('parent_id')->with('sousCategories')->get();
        return view('categories.index', compact('categories'));
    }

    public function deleteCategoryAndRelatedData($categorie) {
        foreach ($categorie->sousCategories as $souscategorie) {
            // Recursively delete subcategories and their related data
            $this->deleteSouscategorieAndRelatedData($souscategorie);
        }
    
        // Finally, delete the category itself
        $categorie->delete();
    }
    
    public function deleteSouscategorieAndRelatedData($souscategorie) {
        // Handle nested souscategories
        foreach ($souscategorie->sousCategories as $childSouscategorie) {
            $this->deleteSouscategorieAndRelatedData($childSouscategorie);
        }
    
        // Delete related articles and their characteristics
        foreach ($souscategorie->articles as $article) {
            // Delete related bon_de_livraison_details and bon_de_livraison
        foreach ($article->commandeDetails as $commandeDetail) {
            // Delete related bon_de_livraison_details
            $bonDeLivraisonDetails = BonDeLivraisonDetail::where('commande_id', $commandeDetail->commande_id)->get();
            foreach ($bonDeLivraisonDetails as $bonDeLivraisonDetail) {
                $bonDeLivraison = $bonDeLivraisonDetail->bonDeLivraison;
                $bonDeLivraisonDetail->delete();
                // Delete the bon_de_livraison if it has no more details
                if ($bonDeLivraison->bonDeLivraisonDetails->isEmpty()) {
                    $bonDeLivraison->delete();
                }
            }

            // Delete the commande_detail
            $commandeDetail->delete();

            // Delete the commande if it has no more details
            $commande = $commandeDetail->commande;
            if ($commande->commandeDetails->isEmpty()) {
                $commande->delete();
            }
        }

        // Delete related demande_details and demande
        foreach ($article->demandeDetails as $demandeDetail) {
            $bonDeLivraisonDetailsDemande = BonDeLivraisonDetail::where('demande_id', $demandeDetail->demande_id)->get();
            foreach ($bonDeLivraisonDetailsDemande as $bonDeLivraisonDetail) {
                $bonDeLivraison = $bonDeLivraisonDetail->bonDeLivraison;
                $bonDeLivraisonDetail->delete();

                // Delete the BonDeLivraison if it has no more details
                if ($bonDeLivraison->bonDeLivraisonDetails->isEmpty()) {
                    $bonDeLivraison->delete();
                }
            }

            // Delete the demande_detail
            $demandeDetail->delete();

            // Delete the demande if it has no more details
            $demande = $demandeDetail->demande;
            if ($demande->demandeDetails->isEmpty()) {
                $demande->delete();
            }
        }

        // Delete the article's characteristics
        $article->articleCaracteristiques()->delete();

        // Finally, delete the article itself
        $article->delete();
        }
    
        // Delete the souscategorie itself
        $souscategorie->delete();
    }

    // Remove the specified category from storage
    public function destroy($id)
    {
        $categorie = Categorie::with('sousCategories.articles.articleCaracteristiques')->find($id);
        if ($categorie) {
            $this->deleteCategoryAndRelatedData($categorie);
        }

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }

}