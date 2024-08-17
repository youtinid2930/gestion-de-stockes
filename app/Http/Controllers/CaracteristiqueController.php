<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Models\Caracteristique;
use App\Models\CategorieCaracteristique;
use Illuminate\Support\Facades\DB;



class CaracteristiqueController extends Controller
{
    public function index() {
        $caracteristiques = Caracteristique::all();

        return view('characteristics.index',compact('caracteristiques'));
    }
    public function characteristics($categorie_id)
    {
        $category = Categorie::findOrFail($categorie_id);
        $caracteristique = Caracteristique::all();
        $characteristics = DB::table('categorie_caracteristique')
            ->join('caracteristiques', 'categorie_caracteristique.caracteristique_id', '=', 'caracteristiques.id')
            ->where('categorie_caracteristique.categorie_id', $categorie_id)
            ->select('caracteristiques.*')
            ->get();
        return view('characteristics.ofcategorie', compact('characteristics','category','caracteristique'));
    }

    public function StoreCharacteristicsByCategorie(Request $request,$categorie_id) {
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

    public function destroy($id_caracteristique) {
        DB::table('categorie_caracteristique')
            ->where('caracteristique_id', $id_caracteristique)
            ->delete();
        DB::table('caracteristiques')
            ->where('id', $id_caracteristique)
            ->delete();
        
        return redirect()->back()->with('success', 'Characteristic deleted successfully.');
    }
    public function edit($id) {
        $editCharacteristic = Caracteristique::find($id);
        $caracteristiques = Caracteristique::all();
        return view('characteristics.index', compact('editCharacteristic', 'caracteristiques'));
    }

    public function update(Request $request,$caracteristique_id) {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $characteristic = Caracteristique::find($caracteristique_id);
            $characteristic->name = $request->name;
            $characteristic->save();
        
        return redirect()->route('caracteristique.index')->with('success', 'Characteristic updated successfully');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $caracteristique = new Caracteristique();
        $caracteristique->name = $request->input('name');
        $caracteristique->save();
        
        return redirect()->route('caracteristique.index')->with('success', 'Characteristic added successfully');
    }
}
