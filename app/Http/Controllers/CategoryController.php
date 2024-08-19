<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Caracteristique;
use App\Models\CategorieCaracteristique;
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

    // Remove the specified category from storage
    public function destroy($id)
    {
        $category = Categorie::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
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

}