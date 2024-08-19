<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Caracteristique;
use App\Models\Categorie;
use App\Models\DepotArticle;
use App\Models\Depot;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $limit = 10; // Nombre d'articles par page
        $offset = ($page - 1) * $limit;

        $categories = Categorie::all();
        $finalCategories = collect();

        foreach ($categories as $categorie) {
            $this->collectFinalSubcategories($categorie, $finalCategories);
        }

        $articlesQuery = Article::query()
        ->leftJoin('depot_articles', 'articles.id', '=', 'depot_articles.article_id')
        ->select('articles.id', 'articles.name', 'articles.description', 'articles.unit_price', 'articles.sku', 'articles.serial_number', 'articles.batch_number', 'articles.combined_code', 'articles.category_id', DB::raw('SUM(depot_articles.quantity) as total_quantity'))
        ->groupBy('articles.id', 'articles.name', 'articles.description', 'articles.unit_price', 'articles.sku', 'articles.serial_number', 'articles.batch_number', 'articles.combined_code', 'articles.category_id');


        if ($request->filled('name')) {
            $articlesQuery->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->filled('category_id')) {
            $articlesQuery->where('category_id', $request->input('category_id'));
        }

        $total_articles = $articlesQuery->count();
        $total_pages = ceil($total_articles / $limit);

        $articles = $articlesQuery->skip($offset)->take($limit)->get();

        return view('articles.index', compact('articles', 'categories', 'page', 'total_pages'));
    }

    public function create()
    {
        $categories = Categorie::all();
        $caracteristiques = Caracteristique::all();
        $finalCategories = collect();

        foreach ($categories as $categorie) {
            $this->collectFinalSubcategories($categorie, $finalCategories);
        }
        return view('articles.create', compact('finalCategories','caracteristiques'));
    }

    public function store(Request $request)
   {
    
    // Validate the incoming request data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'unit_price' => 'required|numeric',
        'category_id' => 'required|exists:categories,id',
        'date_de_fabrication' => 'nullable|date',
        'date_d_expiration' => 'nullable|date',
        'quantity' => 'required|numeric|min:0',
        'caracteristiques' => 'array', // Add this for characteristics
        'caracteristiques.*.id' => 'exists:caracteristiques,id', // Validate each characteristic ID
        'caracteristiques.*.valeur' => 'required|string', // Validate each characteristic value
    ]);
    
    // Create the article with validated data
    
    $article = Article::create($validatedData);
    
    if ($request->has('caracteristiques')) {
        $caracteristiques = $request->input('caracteristiques');
        foreach ($caracteristiques as $caracteristique) {
            $article->characteristics()->attach($caracteristique['id'], ['valeur' => $caracteristique['valeur']]);
        }
    }


    // Generate and assign additional attributes
    $article->sku = Article::generateSku($article);
    $article->serial_number = Article::generateSerialNumber();
    $article->batch_number = Article::generateBatchNumber();
    $article->combined_code = Article::generateCombinedCode($article);
    $article->save();

    // Retrieve the depot_id from the authenticated user
    $depotId = auth()->user()->depot_id;

    // Handle depot_article creation
    if ($depotId) {
        DepotArticle::updateOrCreate(
            [
                'article_id' => $article->id,
                'depot_id' => $depotId
            ],
            ['quantity' => $request->input('quantity')] // Use provided quantity
        );
    }

    return redirect()->route('articles.index')->with('success', 'Article created successfully.');
    }

    public function getCaracteristiques($category_id)
{
    try {
        // Initialize an empty collection to store characteristics
       $caracteristiques = collect();

        // Create a function to recursively fetch characteristics for a category and its ancestors
        $fetchCaracteristiquesForCategoryAndAncestors = function ($currentCategoryId) use (&$fetchCaracteristiquesForCategoryAndAncestors, &$caracteristiques) {
        // Fetch characteristics for the current category
        $currentCaracteristiques = DB::table('categorie_caracteristique')
            ->join('caracteristiques', 'categorie_caracteristique.caracteristique_id', '=', 'caracteristiques.id')
            ->where('categorie_caracteristique.categorie_id', $currentCategoryId)
            ->select('caracteristiques.id', 'caracteristiques.name')
            ->get();

        // Merge the current category's characteristics into the collection
        $caracteristiques = $caracteristiques->merge($currentCaracteristiques);

        // Get the parent category ID
        $parentCategoryId = DB::table('categories')
            ->where('id', $currentCategoryId)
            ->value('parent_id');

        if ($parentCategoryId) {
            // Recursively fetch characteristics for the parent category
            $fetchCaracteristiquesForCategoryAndAncestors($parentCategoryId);
        }
        };

        // Start the recursive fetching process
        $fetchCaracteristiquesForCategoryAndAncestors($category_id);
        return response()->json($caracteristiques);
    } catch (\Exception $e) {
        // Log the exception
        \Log::error($e->getMessage());
        return response()->json(['error' => 'Failed to fetch characteristics'], 500);
    }
}
    public function edit($id)
    {
        $article = Article::with('characteristics')->findOrFail($id);
        $categories = Categorie::all(); // Fetch categories for the dropdown
        $finalCategories = collect();

        foreach ($categories as $categorie) {
            $this->collectFinalSubcategories($categorie, $finalCategories);
        }

        return view('articles.edit', [
            'article' => $article,
            'finalCategories' => $finalCategories
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'unit_price' => 'required|numeric',
            'quantity' => 'nullable|integer',
            'category_id' => 'nullable|exists:categories,id',
            'date_de_fabrication' => 'nullable|date',
            'date_d_expiration' => 'nullable|date',
            'caracteristiques.*.valeur' => 'nullable|string',
            'caracteristiques.*.id' => 'required|exists:caracteristiques,id'
        ]);
    
        $article = Article::findOrFail($id);
        $article->update($validatedData);
    
        // Sync characteristics
        $caracteristiques = $request->input('caracteristiques', []);
        foreach ($caracteristiques as $id => $data) {
            $article->characteristics()->updateExistingPivot($data['id'], ['valeur' => $data['valeur']]);
        }
    
        return redirect()->route('articles.index')->with('message', ['type' => 'success', 'text' => 'Article mis à jour avec succès!']);
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->commandeDetails()->delete();
        $article->characteristics()->detach();
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article supprimé avec succès.');
    }

    private function collectFinalSubcategories($categorie, &$finalCategories)
    {
        if ($categorie->sousCategories->isEmpty()) {
            // Add the final subcategory (leaf node) to the collection
            if (!$finalCategories->contains($categorie)) {
                $finalCategories->push($categorie);
            }
        } else {
            // Recursively collect final subcategories from children
            foreach ($categorie->sousCategories as $child) {
                $this->collectFinalSubcategories($child, $finalCategories);
            }
        }
    }
}
