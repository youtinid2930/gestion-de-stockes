<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Categorie;

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

        $articlesQuery = Article::query();

        if ($request->filled('name')) {
            $articlesQuery->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->filled('category_id')) {
            $articlesQuery->where('category_id', $request->input('category_id'));
        }

        $total_articles = $articlesQuery->count();
        $total_pages = ceil($total_articles / $limit);

        $articles = $articlesQuery->skip($offset)->take($limit)->get();

        return view('articles.index', compact('articles', 'categories', 'page', 'total_pages','finalCategories'));
    }

    public function create()
    {
        $categories = Categorie::all();
        return view('articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $article = Article::create($request->all());
        return redirect()->route('articles.index')->with('success', 'Article créé avec succès.');
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $categories = Categorie::all();
        return view('articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $article->update($request->all());
        return redirect()->route('articles.index')->with('success', 'Article mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
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
