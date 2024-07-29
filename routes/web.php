<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\CommandeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|


Route::get('/', function () {
    return view('welcome');
});
*/


Route::get('/', [AuthController::class, 'showLoginForm']);
Route::post('login', [AuthController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Auth::routes();
/*
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
*/
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('/vente', [VenteController::class, 'index'])->name('vente')->middleware('auth');
Route::get('/client', [ClientController::class, 'index'])->name('client')->middleware('auth');
Route::get('/article', [ArticleController::class, 'index'])->name('article')->middleware('auth');
// route fournisseur
Route::get('/fournisseur', [FournisseurController::class, 'index'])->name('fournisseur.index')->middleware('auth');
Route::get('/fournisseurs/create', [FournisseurController::class, 'create'])->name('fournisseur.create');
Route::post('/fournisseurs', [FournisseurController::class, 'store'])->name('fournisseur.store');
Route::get('/fournisseurs/{id}/edit', [FournisseurController::class, 'edit'])->name('fournisseur.edit');
Route::put('/fournisseurs/{id}', [FournisseurController::class, 'update'])->name('fournisseur.update');

// Commande routes
Route::get('/commandes', [CommandeController::class, 'index'])->name('commande')->middleware('auth');
Route::get('/commandes/create', [CommandeController::class, 'create'])->name('commande.create');
Route::post('/commandes', [CommandeController::class, 'store'])->name('commande.store');
Route::get('/commandes/{id}/edit', [CommandeController::class, 'edit'])->name('commande.edit');
Route::put('/commandes/{id}', [CommandeController::class, 'update'])->name('commande.update');
Route::get('/commandes/{id}', [CommandeController::class, 'show'])->name('commande.show');
Route::get('/commandes/annuler', [CommandeController::class, 'destroy'])->name('commande.annuler');


Route::get('/categorie', [CategorieController::class, 'index'])->name('categorie')->middleware('auth');
Route::get('/magasin', [MagasinController::class, 'index'])->name('magasin')->middleware('auth');
Route::get('/configuration', [ConfigurationController::class, 'index'])->name('configuration')->middleware('auth');

