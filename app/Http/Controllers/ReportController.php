<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Categorie;
use PDF; // Assurez-vous que cette ligne est incluse en haut du fichier

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Filtrage par dates, catégorie, et quantité minimale
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $categoryId = $request->input('category');
        $minQuantity = $request->input('quantity', 0);
    
        $query = Article::query();
    
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
    
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }
    
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
    
        if ($minQuantity) {
            $query->where('quantity', '>=', $minQuantity);
        }
    
        // Récupération des articles filtrés
        $articles = $query->get();
    
        // Données pour le graphique des stocks par article
        $articleChartData = [
            'labels' => $articles->pluck('name'), // noms des articles
            'data' => $articles->pluck('quantity') // quantités des articles
        ];
    
        // Données pour le graphique des stocks par catégorie (exemple)
        $chartData = [
            'labels' => ['Catégorie 1', 'Catégorie 2'], // Remplacez par vos catégories réelles
            'data' => [10, 20] // Remplacez par les niveaux de stock
        ];
    
        // Récupération des catégories pour le formulaire
        $categories = Categorie::all();
    
        // Retourne la vue avec les données nécessaires
        return view('report.index', compact('chartData', 'articleChartData', 'categories'));
    }
    



    public function downloadReport(Request $request)
    {
        // Validation des paramètres de requête
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'category' => 'nullable|exists:categories,id',
            'quantity' => 'nullable|numeric|min:0',
        ]);
        $user = Auth::user();
        // Récupération des paramètres de filtrage
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $categoryId = $request->input('category');
        $minQuantity = $request->input('quantity');

        // Filtrer les articles en fonction des paramètres
        $query = Article::query();

        $query->select('articles.*', 'depot_articles.quantity');

        if ($startDate) {
            $query->whereDate('articles.created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('articles.created_at', '<=', $endDate);
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        // Join with depot_articles to filter by quantity and depot
        $query->join('depot_articles', 'articles.id', '=', 'depot_articles.article_id')
            ->where('depot_articles.depot_id', $user->depot_id);

        // Filter by quantity
        if ($minQuantity) {
            $query->where('depot_articles.quantity', '>=', $minQuantity);
        }

        $articles = $query->get();

        // Calculer la quantité totale d'articles
        $totalQuantity = $articles->sum('quantity');

        // Préparer les données pour le PDF
        $data = [
            'articles' => $articles,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'category' => $categoryId ? Categorie::find($categoryId)->name : 'Toutes les catégories',
            'totalQuantity' => $totalQuantity, // Ajouter la somme des quantités d'articles
        ];

        // Générer le PDF avec les données
        $pdf = \PDF::loadView('report.pdf', $data);

        // Télécharger le PDF
        return $pdf->download('report.pdf');
    }

    public function getChartData($articles)
{
    $chartData = [
        'labels' => [],
        'data' => []
    ];

    // Boucle sur les articles pour récupérer les noms et quantités
    foreach ($articles as $article) {
        $chartData['labels'][] = $article->name; // Ajout des noms d'articles comme labels
        $chartData['data'][] = $article->quantity; // Ajout des quantités pour chaque article
    }

    return $chartData;
}



}