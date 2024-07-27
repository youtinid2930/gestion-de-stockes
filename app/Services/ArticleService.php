<?php

namespace App\Services;

use App\Models\Article;

class ArticleService
{
    /**
     * Get all articles with their count.
     *
     * @return array
     */
    public function getAllArticles()
    {
        $articles = Article::all();
        return [
            'nbre' => $articles->count(),
        ];
    }

    /**
     * Get the most popular articles.
     *
     * @return mixed
     */
    public function getMostSoldArticles()
    {
        // Example query for most sold articles, adjust as needed.
        return Article::withCount('commandes')
            ->orderBy('commandes_count', 'desc')
            ->take(5)
            ->get();
    }
}
