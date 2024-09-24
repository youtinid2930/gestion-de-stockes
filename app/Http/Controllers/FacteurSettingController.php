<?php

namespace App\Http\Controllers;
use App\Models\Company;
use App\Models\Facteur;

use Illuminate\Http\Request;

class FacteurSettingController extends Controller
{
    public function index() {
        $facteur = Company::first();
        return view('configuration.facteur', compact('facteur'));
    }
    
    public function update(Request $request, $id)
    {
        
        // Validate the request
        $request->validate([
            'terms_conditions' => 'required|string',
            'payment_instructions' => 'required|string',
            'bank_details' => 'required|string',
            'payment_terms' => 'required|string',
        ]);
        
        // Find the Company instance (replace with appropriate logic)
        $company = Company::findOrFail($id);
        $company->terms_conditions_commandes = $request->input('terms_conditions');
        $company->payment_instructions = $request->input('payment_instructions');
        $company->bank_details = $request->input('bank_details');
        $company->payment_terms = $request->input('payment_terms');
        
        $company->save();
        // Redirect back with a success message
        return redirect()->route('facteur.settings')->with('success', 'Settings updated successfully');
    }

}

