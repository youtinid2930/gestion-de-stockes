<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
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

    public function characteristics($categorie_id)
    {
        $category = Categorie::findOrFail($categorie_id);
        $characteristics = DB::table('categorie_caracteristique')
            ->join('caracteristiques', 'categorie_caracteristique.caracteristique_id', '=', 'caracteristiques.id')
            ->where('categorie_caracteristique.categorie_id', $categorie_id)
            ->select('caracteristiques.*')
            ->get();
        return view('characteristics.ofcategorie', compact('characteristics','category'));
    }

    public function StoreCharacteristics(Request $request,$categorie_id) {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $exists = DB::table('caracteristiques')
            ->where('name', $request->input('name'))
            ->exists();

        if ($exists) {
            $caracteristique = DB::table('caracteristiques')
            ->where('name', $request->input('name'))
            ->select('id')
            ->first();
            DB::table('categorie_caracteristique')->insert([
                'categorie_id' => $categorie_id,
                'caracteristique_id' => $caracteristique->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            return redirect()->route('category.characteristics', $categorie_id)->with('success', 'Characteristic added successfully');
        }

        // Store the new characteristic
        $caracteristique = new Caracteristique();
        $caracteristique->name = $request->input('name');
        $caracteristique->save();
        
        DB::table('categorie_caracteristique')->insert([
            'categorie_id' => $categorie_id,
            'caracteristique_id' => $caracteristique->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('category.characteristics', $categorie_id)->with('success', 'Characteristic added successfully');
    }

    public function DestroyCharacteristics($categorie_id,$caracteristique_id) {

        $deleted = DB::table('categorie_caracteristique')
            ->where('categorie_id', $categorie_id)
            ->where('caracteristique_id', $caracteristique_id)
            ->delete();

        if ($deleted) {
            // Redirect back with success message if deletion was successful
            return redirect()->back()->with('success', 'Characteristic removed successfully.');
        } else {
            // Redirect back with error message if deletion failed
            return redirect()->back()->with('error', 'Failed to remove characteristic.');
        }
    }
}
