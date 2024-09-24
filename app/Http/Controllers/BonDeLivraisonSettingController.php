<?php

namespace App\Http\Controllers;

use App\Models\Company;

use Illuminate\Http\Request;

class BonDeLivraisonSettingController extends Controller
{
    public function index() {
        $company = Company::first();
        return view('configuration.bon_de_livraison', compact('company'));
    }
    
    public function update(Request $request, $id)
    {
        
        // Validate the request
        $request->validate([
            'terms_conditions' => 'required|string',
        ]);
        
       
        $company = Company::findOrFail($id);
        $company->terms_conditions_livraison = $request->input('terms_conditions');
        
        $company->save();
        // Redirect back with a success message
        return redirect()->route('bon_de_livraison.settings')->with('success', 'Settings updated successfully');
    }
}
