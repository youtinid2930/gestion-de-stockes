<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CaracteristiqueController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BonDeLivraisonController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\ReportController;


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


// Routes pour la recherche
Route::get('/commande/search', [CommandeController::class, 'search'])->name('commandes.search');
Route::get('/fournisseurs/search', [FournisseurController::class, 'search'])->name('fournisseurs.search');
Route::get('/utilisateurs/search', [UtilisateurController::class, 'search'])->name('utilisateurs.search');
Route::get('/categories/search', [CategoryController::class, 'search'])->name('categories.search');
Route::get('/commandes/search', [CommandeController::class, 'search'])->name('commandes.search');




Route::get('/', [AuthController::class, 'showLoginForm']);
Route::post('login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Auth::routes();
/*
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
*/
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/dashboard/search', [DashboardController::class, 'search'])->name('dashboard.search');


Route::get('/article', [ArticleController::class, 'index'])->name('article')->middleware('auth');

// routes fournisseur
Route::get('/fournisseurs/search', [FournisseurController::class, 'search'])->name('fournisseurs.search');

// categories routes
Route::resource('categories', CategoryController::class)->parameters(['categories' => 'id'])->middleware('auth');
// caracteristiques routes
Route::get('categories/{id}/characteristics', [CaracteristiqueController::class, 'characteristics'])->name('category.characteristics');
Route::post('categories/{id}/characteristics', [CaracteristiqueController::class, 'StoreCharacteristicsByCategorie'])->name('characteristicsbycategorie.store');
Route::delete('categories/{id_categorie}/characteristics/{id_charateristics}', [CaracteristiqueController::class, 'DestroyCharacteristics'])->name('characteristicsCategorie.destroy');
Route::get('/characteristics', [CaracteristiqueController::class, 'index'])->name('caracteristique.index');
Route::post('/characteristics', [CaracteristiqueController::class, 'store'])->name('characteristics.store');
Route::delete('/characteristics/{id_caracteristique}', [CaracteristiqueController::class, 'destroy'])->name('characteristics.destroy');
Route::get('/characteristics/{id_caracteristique}/edit', [CaracteristiqueController::class, 'edit'])->name('characteristics.edit');
Route::put('/characteristics/{id_caracteristique}', [CaracteristiqueController::class, 'update'])->name('characteristics.update');


Route::get('/bons_de_livraison', [BonDeLivraisonController::class, 'index'])->name('bons_de_livraison.index');
Route::get('/bons_de_livraison/create', [BonDeLivraisonController::class, 'create'])->name('bons_de_livraison.create');
Route::post('/bons_de_livraison', [BonDeLivraisonController::class, 'store'])->name('bons_de_livraison.store');
Route::get('/bons_de_livraison/{id}/edit', [BonDeLivraisonController::class, 'edit'])->name('bons_de_livraison.edit');
Route::put('/bons_de_livraison/{id}', [BonDeLivraisonController::class, 'update'])->name('bons_de_livraison.update');
Route::delete('/bons_de_livraison/{id}', [BonDeLivraisonController::class, 'destroy'])->name('bons_de_livraison.destroy');



Route::get('/configuration', [ConfigurationController::class, 'index'])->name('configuration')->middleware('auth');

// Report routes
Route::get('/report', [ReportController::class, 'index'])->name('report.index')->middleware('auth');

// route demande
Route::get('/demande', [DemandeController::class, 'index'])->name('demande')->middleware('auth');
Route::get('/demandes', [DemandeController::class, 'showDemandes'])->name('demande.showDemandes');
Route::get('/demandes/create', [DemandeController::class, 'create'])->name('demande.create');
Route::post('/demandes', [DemandeController::class, 'store'])->name('demande.store');
Route::get('/demandes/{id}/edit', [DemandeController::class, 'edit'])->name('demande.edit');
Route::put('/demandes/{id}', [DemandeController::class, 'update'])->name('demande.update');
Route::get('/demandes/table', [DemandeController::class, 'Table'])->name('demande.Table');


Route::get('articles', [ArticleController::class, 'index'])->name('articles.index');


Route::resource('livraison', BonDeLivraisonController::class)->parameters(['livraison' => 'id'])->middleware('auth');


Route::get('/configuration', [ConfigurationController::class, 'index'])->name('configuration.index');
Route::post('/configuration/update', [ConfigurationController::class, 'update'])->name('configuration.update');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/search', [CategoryController::class, 'search'])->name('categories.search');

Route::get('/commandes', [CommandeController::class, 'index'])->name('commandes.index');
Route::get('/commandes/search', [CommandeController::class, 'search'])->name('commandes.search');

Route::group(['middleware' => ['auth','role:admin']], function () {
    
    // Utilisateur
    Route::get('/utilisateurs/search', [UserController::class, 'search'])->name('utilisateurs.search');
    Route::resource('utilisateur', UserController::class)->parameters(['utilisateur' => 'id']);
    // Commande
    Route::resource('commande', CommandeController::class)->parameters(['commande' => 'id']);
    Route::get('/commande/search', [CommandeController::class, 'search'])->name('commandes.search');

    // Fournisseur
    Route::resource('fournisseur', FournisseurController::class)->parameters(['fournisseur' => 'id'])->middleware('auth');
    // Articles
    Route::get('articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('articles/{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('articles/{id}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('articles/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');


    Route::get('/fournisseurs/search', [FournisseurController::class, 'search'])->name('fournisseurs.search');
});
/*
Route::get('test-role', function () {
    return 'Role middleware is working correctly';
})->middleware(['auth', 'role:admin']);

Route::group(['middleware' => ['role:gestionnaire']], function () {
    Route::get('/gestionnaire', function () {
        
    });
});
Route::group(['middleware' => ['role:magasinier']], function () {
    Route::get('/magasinier', function () {
        
    });
});
*/