<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Display a listing of the categories
    public function index()
    {
        $categories = Categorie::with('sousCategories')->get();
        return view('categories.index', compact('categories'));
    }

    // Show the form for creating a new category
    public function create(Request $request)
    {
        $parent_id = $request->input('parent_id');
        return view('categories.create', compact('parent_id'));
    }

    // Store a newly created category in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category = new Category();
        $category->name = $request->input('name');
        $category->parent_id = $request->input('parent_id');
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    // Show the form for editing the specified category
    public function edit(Category $Category)
    {
        return view('categories.edit', compact('category'));
    }

    // Update the specified category in storage
    public function update(Request $request, Category $Category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->name = $request->input('name');
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    // Remove the specified category from storage
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
