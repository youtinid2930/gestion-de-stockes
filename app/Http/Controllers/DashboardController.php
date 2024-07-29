<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CommandeService;
use App\Services\ArticleService;
use App\Services\RecentCommandesService;

class DashboardController extends Controller
{
    protected $commandeService;
    protected $articleService;
    protected $recentCommandesService;

    public function __construct(
        CommandeService $commandeService,
        ArticleService $articleService,
        RecentCommandesService $recentCommandesService
    ) {
        $this->middleware('auth');
        $this->commandeService = $commandeService;
        $this->articleService = $articleService;
        $this->recentCommandesService = $recentCommandesService;
    }

    public function index()
    {
        $data = [];

        $userRole = auth()->user()->role;

        
        $data['commandes'] = $this->commandeService->getAllCommandes();
        $data['articles'] = $this->articleService->getAllArticles();
        

        
        

        
        $data['recentCommandes'] = $this->recentCommandesService->getRecentCommandes();
        

        return view('dashboard', compact('data'));
    }
}
