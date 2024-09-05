<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class CompanySettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $company = Company::where('user_id', $user->id)->first(); // Adapter cela à votre logique réelle
        
        return view('configuration.company-settings', compact('company'));
    }

    public function store(Request $request)
    {
        // Valider la requête
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact' => 'required|string|max:20',
        ]);

        // Obtenir l'utilisateur authentifié actuel
        $user = Auth::user();

        // Créer une nouvelle entrée de paramètres de l'entreprise
        $company = Company::create([
            'user_id' => $user->id,
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'email' => $request->input('email'),
            'contact' => $request->input('contact'),
        ]);

        // Ajouter un message de succès dans la session
        session()->flash('success', 'Company settings saved successfully.');

        // Rediriger avec un message de succès
        return redirect()->route('configuration.index');
    }

    public function update(Request $request, Company $company)
    {
        // Valider la requête
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact' => 'required|string|max:20',
        ]);
        
        // Mettre à jour les paramètres de l'entreprise
        $company->update([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'email' => $request->input('email'),
            'contact' => $request->input('contact'),
        ]);
       

        // Ajouter un message de succès dans la session
        session()->flash('success', 'Les paramètres d\'entreprise ont été mis à jour avec succès.');

        // Rediriger avec un message de succès
        return redirect()->route('configuration.index');
    }
}

