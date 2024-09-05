<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileSettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $profile = User::where('id', $user->id)->first(); // Adapter cela à votre logique
        
        return view('configuration.profile-settings', compact('profile'));
    }

    public function store(Request $request)
    {
        // Valider la requête
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'telephone' => 'nullable|string|max:255',
            'adresse' => 'nullable|string|max:255',
        ]);

        // Obtenir l'utilisateur authentifié actuel
        $user = Auth::user();
        
        // Créer une nouvelle entrée de paramètres de profil
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'telephone' => $request->input('telephone'),
            'adresse' => $request->input('adresse'),
        ]);
        

        // Ajouter un message de succès dans la session
        session()->flash('success', 'Les paramètres de Profile ont été mis à jour avec succès.');


        // Rediriger avec un message de succès
        return redirect()->route('configuration.index');
    }
}
