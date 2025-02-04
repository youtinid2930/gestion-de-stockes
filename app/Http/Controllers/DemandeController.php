<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Demande;
use App\Models\Article;
use App\Models\DepotArticle;
use App\Models\Depot;
use App\Models\User;
use App\Models\Company;
use App\Models\Employer;
use App\Models\DemandeDetail;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

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
        $depot_id = $user->depot_id;
        $allArticles = DepotArticle::select('article_id')
              ->where('depot_id', $depot_id)
              ->get();
        $articles = null;
        $i = 0;
        foreach($allArticles as $articleId) {
            $articles[$i] = Article::findOrFail($articleId);
            $i++;
        }
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
        return view('demandes.create', compact('admins', 'magasins','articles'));
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
        $user = Auth::user();
        // Validate the incoming request
        if(auth()->user()->hasRole('gestionnaire')) {
            $validatedData = $request->validate([
                'admin' => 'nullable|exists:users,id', // Only if the user is a magasinier
                'magasinier' => 'nullable|exists:users,id', // Only if the user is a gestionnaire
                'articles.*.id_article' => 'required|exists:articles,id',
                'articles.*.quantite' => 'required|integer|min:1',
                'first_name' => 'required|string|max:255',
                'second_name' => 'required|string|max:255',
                'departement' => 'required|string|max:255',
                'contact' => 'required|string|max:255',
                'urgence' => 'string|max:255',
                'notes' => 'nullable|string',
            ]);
        }else {
            $validatedData = $request->validate([
                'admin' => 'nullable|exists:users,id', // Only if the user is a magasinier
                'magasinier' => 'nullable|exists:users,id', // Only if the user is a gestionnaire
                'articles.*.id_article' => 'required|exists:articles,id',
                'articles.*.quantite' => 'required|integer|min:1',
                'urgence' => 'string|max:255',
                'notes' => 'nullable|string',
            ]);
        }
        
        $users = User::with('depot')->find($user->id);
        $delivery_address = $users->depot->adresse;
        // Create a new Demande
        $demande = new Demande();
        $demande->magasinier_id = $request->magasinier; // Assign magasinier ID
        $demande->admin_id = $request->admin; // Assign admin ID
        if(auth()->user()->hasRole('gestionnaire')) {
            $demande->gestionnaire_id = auth()->user()->id;

            // Store the employer information in the employers table
            $employer = new Employer();
            $employer->first_name = $request->first_name;
            $employer->second_name = $request->second_name;
            $employer->department = $request->departement;
            $employer->contact = $request->contact;
            $employer->save();

            $demande->employer_id = $employer->id;
        }
        if(auth()->user()->hasRole('magasinier')) {
            $demande->magasinier_id = auth()->user()->id;
        }
        $demande->notes = $request->notes;
        $demande->delivery_address = $delivery_address;
        $demande->urgence = $request->urgence;
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
        $demande = Demande::with('demandeDetails.article')->findOrFail($id);
        $articles = Article::all(); // Assuming you want to show all available articles for editing
        return view('demandes.edit', compact('demande', 'articles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'details.*.article_id' => 'required|exists:articles,id',
            'details.*.quantity' => 'required|integer|min:1',
            'urgence' => 'string|max:255',
        ]);
    
        $demande = Demande::findOrFail($id);
        
        $demande->update([
            'urgence' => $request->input('urgence'),
        ]);
        
        // Update demande details
        foreach ($request->input('details') as $detailData) {
            $demandeDetail = DemandeDetail::findOrFail($detailData['id']);
            $demandeDetail->update([
                'article_id' => $detailData['article_id'],
                'quantity' => $detailData['quantity'],
            ]);
        }
    
        return redirect()->route('demande.index')->with('success', 'Demande mise à jour avec succès');
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

   public function showbondedemande($id) {
        // Fetch the demande and its details
        $demande = Demande::with('demandeDetails.article', 'gestionnaire')->findOrFail($id);

        // Fetch the company and employer data
        $company = Company::find(3); // Assuming you want the company with ID 1
        $employer = Employer::find($demande->employer_id); // Assuming the gestionnaire is the employer

        return view('demandes.bon_de_demande', [
            'demande' => $demande,
            'company' => $company,
            'employer' => $employer,
        ]);
   }

   public function pdfDownload($id) {
    // Retrieve the demande by its ID
    $demande = Demande::with('demandeDetails.article', 'magasinier', 'gestionnaire')->find($id);
    $company = Company::find(3);
    $employer = Employer::find($demande->employer_id);
    // Pass the demande data to the view
    $pdf = PDF::loadView('demandes.pdf', compact('demande','company','employer'));
    
    // Download the PDF
    return $pdf->download('bon_de_demande_' . $demande->numero . '.pdf');
   }

}    

