<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    /**
     * Affiche la page de configuration.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Vous pouvez récupérer des configurations ou d'autres données ici
        // $configurations = Configuration::all();

        return view('configuration.index'); // Assurez-vous que cette vue existe
    }

    /**
     * Met à jour les configurations.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // Valider les données
        $validated = $request->validate([
            'option1' => 'required|string|max:255',
            'option2' => 'required|boolean',
            // Ajoutez d'autres règles de validation ici
        ]);

        // Enregistrez les configurations
        // Configuration::update($validated);

        return redirect()->route('configuration.index')->with('message', 'Configuration mise à jour avec succès');
    }
}
