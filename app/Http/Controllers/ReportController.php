<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Categorie;
use PDF; // Assurez-vous que cette ligne est incluse en haut du fichier

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Filtrage des articles
        $articlesQuery = Article::query();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $articlesQuery->whereBetween('created_at', [$request->input('start_date'), $request->input('end_date')]);
        }

        if ($request->filled('category')) {
            $articlesQuery->where('category_id', $request->input('category'));
        }

        $articles = $articlesQuery->with('category')->get();

        $categories = Categorie::all(); // Pour le sélecteur de catégorie

        // Préparer les données pour le graphique
        $categoriesData = $articles->groupBy('category_id')->map(function ($group) {
            return $group->sum('stock');
        });

        $chartData = [
            'labels' => $categoriesData->keys()->map(function ($id) {
                $category = Categorie::find($id);
                return $category ? $category->name : 'Catégorie inconnue';
            })->toArray(),
            'data' => $categoriesData->values()->toArray(),
        ];

        // Préparer les données pour le graphique des articles
        $articleChartData = [
            'labels' => $articles->pluck('name')->toArray(),
            'data' => $articles->pluck('stock')->toArray(),
        ];

        return view('report.index', [
            'chartData' => $chartData,
            'articleChartData' => $articleChartData,
            'categories' => $categories
        ]);
    }

    public function downloadReport(Request $request)
{
    // Validation des paramètres de requête
    $request->validate([
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date',
        'category' => 'nullable|exists:categories,id',
    ]);

    // Récupération des paramètres de filtrage
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $categoryId = $request->input('category');

    // Filtrer les articles en fonction des paramètres
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

    $articles = $query->get();

    // Préparer les données pour le PDF
    $data = [
        'articles' => $articles,
        'startDate' => $startDate,
        'endDate' => $endDate,
        'category' => $categoryId ? Categorie::find($categoryId)->name : 'Toutes les catégories',
    ];

    // Générer le PDF avec les données
    $pdf = \PDF::loadView('report.pdf', $data);

    // Télécharger le PDF
    return $pdf->download('report.pdf');
}

}
