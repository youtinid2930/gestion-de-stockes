<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\CommandeDetail;
use App\Models\Article;
use App\Models\Fournisseur;
use App\Models\Demande;
use App\Models\User;
use App\Models\BonDeLivraison;
use App\Models\DepotArticle;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        Carbon::setLocale('fr');
        $user = Auth::user();
        $data = [];

        if ($user->hasRole('admin')) {
            $commandes = Commande::all();
            $commandesEnCours = $commandes->where('status', 'en attente');
            $commandesTerminees = $commandes->where('status', 'validée');
            $articles = Article::all();
            $recentCommandes = Commande::with('fournisseur', 'commandeDetails.article')->latest()->take(2)->get();
            $recentDemandes = Demande::with('magasinier', 'demandeDetails.article')->latest()->take(2)->get();
            $commandesCount = Commande::count();
            $articlesCount = Article::count();
            $articlesCreated = Article::whereDate('created_at', Carbon::today())->count();
            $depotId = $user->depot_id;

            // Articles en stock par dépôt
            $articlesInStock = DepotArticle::with('depot', 'article')
                ->where('depot_id', $depotId)
                ->count();

            $commandeDetail = CommandeDetail::all();
            $fournisseursCount = Fournisseur::count();
            $usersCount = User::count();

            $lastCommande = $commandes->sortByDesc('updated_at')->first();
            $lastArticle = $articles->sortByDesc('updated_at')->first();
            $timeSinceLastCommande = $lastCommande ? $lastCommande->updated_at->diffForHumans() : 'N/A';
            $timeSinceLastArticle = $lastArticle ? $lastArticle->updated_at->diffForHumans() : 'N/A';

            $data = [
                'recentCommandes' => $recentCommandes,
                'commandeDetail' => $commandeDetail,
                'recentDemandes' => $recentDemandes,
                'commandesEnCours' => [
                    'nbre' => $commandesEnCours->count(),
                    'timeSinceLastUpdate' => $timeSinceLastCommande,
                ],
                'commandesTerminees' => [
                    'nbre' => $commandesTerminees->count(),
                ],
                'articles' => [
                    'nbre' => $articlesCount,
                    'timeSinceLastUpdate' => $timeSinceLastArticle,
                    'createdToday' => $articlesCreated,
                ],
                'fournisseursCount' => $fournisseursCount,
                'usersCount' => $usersCount,
                'articlesInStock' => $articlesInStock,
            ];
        } elseif ($user->hasRole('magasinier')) {
            $depotId = $user->depot_id;

            // Articles en stock
            $articlesInStock = DepotArticle::with('article')
                ->where('depot_id', $depotId)
                ->count();

            // Livraisons en cours, livrées, et terminées
            $livraisonsEnCours = BonDeLivraison::where('user_id', $user->id)
                ->where('status', 'en attente')
                ->get();
            $livraisonsLivrees = BonDeLivraison::where('user_id', $user->id)
                ->where('status', 'livree')
                ->get();
            $livraisonsTerminees = BonDeLivraison::where('user_id', $user->id)
                ->where('status', 'terminee')
                ->get();

            // Demandes en cours et terminées
            $demandesEnCours = Demande::where('magasinier_id', $user->id)
                ->where('status', '!=', 'Complétée')
                ->count();
            $demandesTerminees = Demande::where('magasinier_id', $user->id)
                ->where('status', 'Complétée')
                ->count();

            // Dernières demandes
            $mesDernieresDemandes = Demande::with('admin', 'demandeDetails.article')
                ->whereNull('gestionnaire_id')
                ->orderBy('updated_at', 'desc')
                ->take(2)
                ->get();
            $derniereDemandesRecues = Demande::with('gestionnaire', 'demandeDetails.article')
                ->whereNull('admin_id')
                ->orderBy('updated_at', 'desc')
                ->take(2)
                ->get();

            // Dernière livraison
            $derniereLivraison = BonDeLivraison::with('bonDeLivraisonDetails')
                ->where('user_id', $user->id)
                ->orderBy('updated_at', 'desc')
                ->take(2)
                ->get();

            $data = [
                'articlesInStock' => $articlesInStock,
                'livraisonsEnCours' => $livraisonsEnCours,
                'livraisonsLivrees' => $livraisonsLivrees,
                'livraisonsTerminees' => $livraisonsTerminees,
                'demandesEnCours' => $demandesEnCours,
                'demandesTerminees' => $demandesTerminees,
                'mesDernieresDemandes' => $mesDernieresDemandes,
                'derniereDemandesRecues' => $derniereDemandesRecues,
                'derniereLivraison' => $derniereLivraison,
            ];
        }

        return view('Dashboard.index', compact('data'));
    }
}
