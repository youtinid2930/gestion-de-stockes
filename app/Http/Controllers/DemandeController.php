<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Demande;
use App\Models\Article;
use App\Models\Depot;
use App\Models\User;
use App\Models\DemandeDetail;

class DemandeController extends Controller
{
    public function index()
    {
        if(auth()->user()->hasRole('gestionnaire')){
            $Medemandes = Demande::with('demandeDetails.article','magasinier')->whereNull('admin_id')->get();
            return view('demandes.index', compact('Medemandes'));
        }
        else if(auth()->user()->hasRole('magasinier')){
            $Medemandes = Demande::with('demandeDetails.article','admin')->whereNull('gestionnaire_id')->get();
            $demandesRecus = Demande::with('demandeDetails.article','gestionnaire')->whereNull('admin_id')->get();
            return view('demandes.index', compact('Medemandes','demandesRecus'));
        }
        else {
            $demandesRecus = Demande::with('demandeDetails.article','magasinier')->whereNull('gestionnaire_id')->get();
            return view('demandes.index',compact('demandesRecus'));
        }
    }

    
    public function create()
    {
        // Get the currently authenticated user
        $user = auth()->user();
        $allArticles = Article::all();

        // Initialize variables for the data to be passed to the view
        $admins = [];
        $magasins = [];

        // Check user role and set data accordingly
        if ($user->hasRole('magasinier')) {
            $admins = User::role('admin')->get();
        }

        if ($user->hasRole('gestionnaire')) {
            // Fetch all admins and magasinier users for gestionnaire role
            $magasins = Depot::where('type', 'Magasin')->get();
        }

        // Pass the data to the view
        return view('demandes.create', compact('admins', 'magasins','allArticles'));
    }
    
    public function getMagasiniers(Request $request)
    {
        $magasinId = $request->input('magasin_id');

        // Fetch magasinier users based on the selected magasin
        $magasiniers = User::get()->where('depot_id',$magasinId);

        return response()->json($magasiniers);
    }


    public function store(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'admin' => 'nullable|exists:users,id', // Only if the user is a magasinier
            'magasinier' => 'nullable|exists:users,id', // Only if the user is a gestionnaire
            'articles.*.id_article' => 'required|exists:articles,id',
            'articles.*.quantite' => 'required|integer|min:1',
            'notes' => 'nullable|string',
            'delivery_address' => 'nullable|string|max:255',
        ]);

        // Create a new Demande
        $demande = new Demande();
        $demande->magasinier_id = $request->magasinier; // Assign magasinier ID
        $demande->admin_id = $request->admin; // Assign admin ID
        if(auth()->user()->hasRole('gestionnaire')) {
            $demande->gestionnaire_id = auth()->user()->id;
        }
        if(auth()->user()->hasRole('magasinier')) {
            $demande->magasinier_id = auth()->user()->id;
        }
        $demande->notes = $request->notes;
        $demande->delivery_address = $request->delivery_address;
        $demande->save(); // Save the demande first to get its ID

        // Loop through the articles and save them in DemandeDetails
        foreach ($request->articles as $articleData) {
            $article = Article::findOrFail($articleData['id_article']);
            $demandeDetail = new DemandeDetail();
            $demandeDetail->demande_id = $demande->id;
            $demandeDetail->article_id = $article->id;
            $demandeDetail->quantity = $articleData['quantite'];
            $demandeDetail->save();
        }

        // Optionally, redirect back with a success message
        return redirect()->route('demande.index')->with('message', [
            'type' => 'success',
            'text' => 'Demande créée avec succès.',
        ]);
    }

    public function edit($id)
    {
        $demande = Demande::findOrFail($id); // Fetch the demande by ID
        return view('demandes.edit', compact('demande')); // Pass the demande to the view
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required',
            'notes' => 'nullable',
            'status' => 'nullable',
            'delivery_address' => 'nullable',
        ]);

        $demande = Demande::findOrFail($id);
        $demande->update($request->all());

        return redirect()->route('demande.showDemandes')->with('message', [
            'type' => 'success',
            'text' => 'Demande mise à jour avec succès.'
        ]);
    }
    public function Table()
    {
        $demandes = Demande::all(); // Récupérer toutes les demandes
        return view('demandes.Tabledemandes', compact('demandes')); // Passer les demandes à la vue
    }
    public function showDemandes()
    {
        $demandes = Demande::all(); // Assurez-vous que vous récupérez les données correctement
        return view('demandes.Formulairedemandes', compact('demandes'));
    }

    public function destroy($id)
    {
        $demande = Demande::with('demandeDetails')->findOrFail($id);
        $demande->delete();

        return redirect()->route('demande.index')->with('message', [
            'type' => 'success',
            'text' => 'Demande supprimée avec succès.'
        ]);
    }
    
    public function changeStatus($id) {
    // Find the demande by its ID
    $demande = Demande::findOrFail($id);

    // Define the sequence of statuses
    $statuses = [
        'En attente' => 'En cours de traitement',
        'En cours de traitement' => 'Livrée',
        'Livrée' => 'Complétée',
        'Complétée' => 'Complétée', // Or keep as 'Complétée' if it shouldn't change
    ];

    // Get the current status
    $currentStatus = $demande->status;

    // Determine the next status
    if (array_key_exists($currentStatus, $statuses)) {
        $demande->status = $statuses[$currentStatus];
    } else {
        // Handle unexpected status (optional)
        return redirect()->route('demande.index')->with('error', 'Statut invalide.');
    }

    // Save the changes to the database
    $demande->save();

    // Redirect with a success message
    return redirect()->route('demande.index')->with('success', 'Le statut de la demande a été mis à jour avec succès.');
    }

    public function show($id)
   {
    // Retrieve the demande by ID, including related models
    $demande = Demande::with(['demandeDetails.article', 'admin', 'magasinier', 'gestionnaire'])->findOrFail($id);
    
    // Pass the data to the view
    return view('demandes.show', compact('demande'));
   }

   

}    

