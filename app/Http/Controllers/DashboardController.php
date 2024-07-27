<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CommandeService;
use App\Services\ArticleService;
use App\Services\CAService;
use App\Services\RecentCommandesService;

class DashboardController extends Controller
{
    protected $commandeService;
    protected $articleService;
    protected $caService;
    protected $recentCommandesService;

    public function __construct(
        CommandeService $commandeService,
        ArticleService $articleService,
        CAService $caService,
        RecentCommandesService $recentCommandesService
    ) {
        $this->middleware('auth');
        $this->commandeService = $commandeService;
        $this->articleService = $articleService;
        $this->caService = $caService;
        $this->recentCommandesService = $recentCommandesService;
    }

    public function index()
    {
        $data = [];

        $userRole = auth()->user()->role;

        if ($userRole == 'admin' || $userRole == 'gestionnaire') {
            $data['commandes'] = $this->commandeService->getAllCommandes();
            $data['articles'] = $this->articleService->getAllArticles();
        }

        if ($userRole == 'admin') {
            $data['ca'] = $this->caService->getTotalRevenue();
        }

        if ($userRole == 'admin' || $userRole == 'gestionnaire') {
            $data['recentCommandes'] = $this->recentCommandesService->getRecentCommandes();
        }

        return view('dashboard', compact('data'));
    }
}
