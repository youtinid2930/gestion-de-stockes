<?php

namespace App\Http\Controllers;
use App\Models\Commande;
use App\Models\CommandeDetail;
use App\Models\Article;
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
        $articles = Article::all();
        $recentCommandes = Commande::with('fournisseur','commandeDetails.article')->latest()->take(2)->get(); // Exemple de récupération des commandes récentes
        $commandesCount = Commande::count();
        $articlesCount = Article::count(); // Ajustez selon vos besoins
        $commandeDetail = CommandeDetail::all();


        $lastCommande = $commandes->sortByDesc('updated_at')->first();
        $lastArticle = $articles->sortByDesc('updated_at')->first();

        $timeSinceLastCommande = $lastCommande ? $lastCommande->updated_at->diffForHumans() : 'N/A';
        $timeSinceLastArticle = $lastArticle ? $lastArticle->updated_at->diffForHumans() : 'N/A';


        $data = [
            'recentCommandes' => $recentCommandes,
            'commandeDetail' => $commandeDetail,
            'commandes' => [
                'nbre' => $commandesCount,
                'timeSinceLastUpdate' => $timeSinceLastCommande,
            ],
            'articles' => [
                'nbre' => $articlesCount,
                'timeSinceLastUpdate' => $timeSinceLastArticle,
            ],
        ];
       
       }
       return view('dashboard', compact('data'));
    }
    
}
