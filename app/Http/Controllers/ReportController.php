<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Categorie;

class ReportController extends Controller
{
    public function index()
{
    // Fetch all articles with their stock levels
    $articles = Article::with('category')->get();

    // Prepare data for the chart
    $categories = $articles->groupBy('category_id')->map(function ($group) {
        return $group->sum('stock');
    });

    $chartData = [
        'labels' => $categories->keys()->map(function ($id) {
            $category = Categorie::find($id);
            return $category ? $category->name : 'Catégorie inconnue';
        })->toArray(),
        'data' => $categories->values()->toArray(),
    ];

    // Prepare data for article chart
    $articles = Article::all();
    $articleChartData = [
        'labels' => $articles->pluck('name')->toArray(),
        'data' => $articles->pluck('stock')->toArray(),
    ];

    return view('report.index', [
        'chartData' => $chartData,
        'articleChartData' => $articleChartData
    ]);
}

}
