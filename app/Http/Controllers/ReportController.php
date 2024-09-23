<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Article;
use App\Models\Categorie;
use PDF; // Assurez-vous que cette ligne est incluse en haut du fichier

class ReportController extends Controller
{
    public function index(Request $request)
    {
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

        // Filtrer et récupérer les catégories avec la somme des quantités d'articles par catégorie
        $categoryQuery = Categorie::query();
        $categoryQuery->select('categories.name', DB::raw('SUM(depot_articles.quantity) as total_quantity'))
                      ->join('articles', 'categories.id', '=', 'articles.category_id')
                      ->join('depot_articles', 'articles.id', '=', 'depot_articles.article_id')
                      ->where('depot_articles.depot_id', $user->depot_id)
                      ->groupBy('categories.id', 'categories.name');
    
        if ($startDate) {
            $categoryQuery->whereDate('articles.created_at', '>=', $startDate);
        }
    
        if ($endDate) {
            $categoryQuery->whereDate('articles.created_at', '<=', $endDate);
        }
    
        $categoriesWithQuantity = $categoryQuery->get();
    
        // Données pour le graphique des stocks par article
        $articleChartData = [
            'labels' => $articles->pluck('name'), // noms des articles
            'data' => $articles->pluck('quantity') // quantités des articles
        ];
    
        // Données pour le graphique des stocks par catégorie
        $chartData = [
            'labels' => $categoriesWithQuantity->pluck('name'), // noms des catégories
            'data' => $categoriesWithQuantity->pluck('total_quantity') // quantités totales par catégorie
        ];
        
        // Get stock movements for the user's depot
        $stockMovements = DB::table('stock_movements')
            ->join('articles', 'stock_movements.article_id', '=', 'articles.id')
            ->join('depot_articles', 'stock_movements.article_id', '=', 'depot_articles.article_id')
            ->where('depot_articles.depot_id', $user->depot_id)
            ->select(
                'articles.name', 
                'stock_movements.type', 
                'stock_movements.quantity', 
                'stock_movements.date_mouvement'
            )
            ->orderBy('stock_movements.date_mouvement', 'asc')
            ->get();

        // Prepare data for the line chart (quantity over time for each article)
        $lineChartData = [];
        foreach ($stockMovements as $movement) {
            $lineChartData['labels'][] = $movement->date_mouvement;
            $lineChartData['data'][$movement->name][] = $movement->quantity;
        }

        // Get stock movements filtered by depot
        $stockMovements = DB::table('stock_movements')
            ->join('articles', 'stock_movements.article_id', '=', 'articles.id')
            ->join('depot_articles', 'stock_movements.article_id', '=', 'depot_articles.article_id')
            ->where('depot_articles.depot_id', $user->depot_id)
            ->select('articles.name', 'stock_movements.type', DB::raw('SUM(stock_movements.quantity) as total_quantity'))
            ->groupBy('articles.name', 'stock_movements.type')
            ->get();

        // Prepare data for the bar chart (dividing Entrée and Sortie)
        $barChartData = [
            'labels' => [],
            'Entrée' => [],
            'Sortie' => []
        ];
        
        foreach ($stockMovements as $movement) {
            $barChartData['labels'][] = $movement->name;
            if ($movement->type == 'Entrée') {
                $barChartData['Entrée'][] = $movement->total_quantity;
            } else {
                $barChartData['Sortie'][] = $movement->total_quantity;
            }
        }
        

        // Get total Entrée and Sortie quantities for the depot
        $stockMovements = DB::table('stock_movements')
            ->join('depot_articles', 'stock_movements.article_id', '=', 'depot_articles.article_id')
            ->where('depot_articles.depot_id', $user->depot_id)
            ->select('stock_movements.type', DB::raw('SUM(stock_movements.quantity) as total_quantity'))
            ->groupBy('stock_movements.type')
            ->get();

        // Prepare data for the pie chart (percentage of Entrée vs Sortie)
        $totalEntrée = 0;
        $totalSortie = 0;
        
        foreach ($stockMovements as $movement) {
            if ($movement->type == 'Entrée') {
                $totalEntrée = $movement->total_quantity;
            } else {
                $totalSortie = $movement->total_quantity;
            }
        }
        
        $totalQuantity = $totalEntrée + $totalSortie;
        
        // Calculate percentages
        $EntréePercentage = ($totalEntrée / $totalQuantity) * 100;
        $SortiePercentage = ($totalSortie / $totalQuantity) * 100;
        
        $pieChartData = [
            'labels' => ['Entrée', 'Sortie'],
            'data' => [$EntréePercentage, $SortiePercentage]
        ];
        // Récupération des catégories pour le formulaire
        $categories = Categorie::all();
    
        // Retourne la vue avec les données nécessaires
        return view('report.index', compact('chartData', 'articleChartData', 'categories','lineChartData','barChartData','pieChartData'));
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
        // Get stock movements for the user's depot
        $stockMovements = DB::table('stock_movements')
            ->join('articles', 'stock_movements.article_id', '=', 'articles.id')
            ->join('depot_articles', 'stock_movements.article_id', '=', 'depot_articles.article_id')
            ->where('depot_articles.depot_id', $user->depot_id)
            ->select(
                'articles.name', 
                'stock_movements.type', 
                'stock_movements.quantity', 
                'stock_movements.date_mouvement'
            )
            ->orderBy('stock_movements.date_mouvement', 'asc')
            ->get();
        // Prepare data for the line chart (quantity over time for each article)
        $lineChartData = [];
        foreach ($stockMovements as $movement) {
            $lineChartData['labels'][] = $movement->date_mouvement;
            $lineChartData['data'][$movement->name][] = $movement->quantity;
        }

        // Get stock movements filtered by depot
        $stockMovements = DB::table('stock_movements')
            ->join('articles', 'stock_movements.article_id', '=', 'articles.id')
            ->join('depot_articles', 'stock_movements.article_id', '=', 'depot_articles.article_id')
            ->where('depot_articles.depot_id', $user->depot_id)
            ->select('articles.name', 'stock_movements.type', DB::raw('SUM(stock_movements.quantity) as total_quantity'))
            ->groupBy('articles.name', 'stock_movements.type')
            ->get();

        // Prepare data for the bar chart (dividing Entrée and Sortie)
        $barChartData = [
            'labels' => [],
            'Entrée' => [],
            'Sortie' => []
        ];
        
        foreach ($stockMovements as $movement) {
            $barChartData['labels'][] = $movement->name;
            if ($movement->type == 'Entrée') {
                $barChartData['Entrée'][] = $movement->total_quantity;
            } else {
                $barChartData['Sortie'][] = $movement->total_quantity;
            }
        }
        

        // Get total Entrée and Sortie quantities for the depot
        $stockMovements = DB::table('stock_movements')
            ->join('depot_articles', 'stock_movements.article_id', '=', 'depot_articles.article_id')
            ->where('depot_articles.depot_id', $user->depot_id)
            ->select('stock_movements.type', DB::raw('SUM(stock_movements.quantity) as total_quantity'))
            ->groupBy('stock_movements.type')
            ->get();

        // Prepare data for the pie chart (percentage of Entrée vs Sortie)
        $totalEntrée = 0;
        $totalSortie = 0;
        
        foreach ($stockMovements as $movement) {
            if ($movement->type == 'Entrée') {
                $totalEntrée = $movement->total_quantity;
            } else {
                $totalSortie = $movement->total_quantity;
            }
        }
        
        $totalQuantity = $totalEntrée + $totalSortie;
        
        // Calculate percentages
        $EntréePercentage = ($totalEntrée / $totalQuantity) * 100;
        $SortiePercentage = ($totalSortie / $totalQuantity) * 100;
        
        $pieChartData = [
            'labels' => ['Entrée', 'Sortie'],
            'data' => [$EntréePercentage, $SortiePercentage]
        ];

        // Préparer les données pour le PDF
        $data = [
            'articles' => $articles,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'category' => $categoryId ? Categorie::find($categoryId)->name : 'Toutes les catégories',
            'totalQuantity' => $totalQuantity, // Ajouter la somme des quantités d'articles
            'lineChartData' => $lineChartData,
            'barChartData' => $barChartData,
            'pieChartData' => $pieChartData
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