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
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Auth::routes();
/*
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
*/
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::resource('utilisateur', UserController::class)->parameters(['utilisateur' => 'id'])->middleware('auth');


Route::get('/demande', [DemandeController::class, 'index'])->name('demande')->middleware('auth');
Route::get('/article', [ArticleController::class, 'index'])->name('article')->middleware('auth');

// routes fournisseur
Route::resource('fournisseur', FournisseurController::class)->parameters(['fournisseur' => 'id'])->middleware('auth');
// routes commandes
Route::resource('commande', CommandeController::class)->parameters(['commande' => 'id'])->middleware('auth');



/*
Route::get('/commandes', [CommandeController::class, 'index'])->name('commande')->middleware('auth');
Route::get('/commandes/create', [CommandeController::class, 'create'])->name('commande.create');
Route::post('/commandes', [CommandeController::class, 'store'])->name('commande.store');
Route::get('/commandes/{id}/edit', [CommandeController::class, 'edit'])->name('commande.edit');
Route::put('/commandes/{id}', [CommandeController::class, 'update'])->name('commande.update');
Route::get('/commandes/{id}', [CommandeController::class, 'destroy'])->name('commande.destroy');
Route::get('/commandes/{id}', [CommandeController::class, 'show'])->name('commande.show');
*/

// categories routes
Route::resource('categories', CategoryController::class)->parameters(['categories' => 'id'])->middleware('auth');
// caracteristiques routes
Route::get('categories/{id}/characteristics', [CaracteristiqueController::class, 'characteristics'])->name('category.characteristics');
Route::post('categories/{id}/characteristics', [CaracteristiqueController::class, 'StoreCharacteristicsByCategorie'])->name('characteristicsbycategorie.store');
Route::delete('categories/{id_categorie}/characteristics/{id_charateristics}', [CaracteristiqueController::class, 'DestroyCharacteristics'])->name('characteristics.destroy');
Route::get('/characteristics', [CaracteristiqueController::class, 'index'])->name('caracteristique.index');
Route::post('/characteristics', [CaracteristiqueController::class, 'store'])->name('characteristics.store');
Route::delete('/characteristics/{id_caracteristique}', [CaracteristiqueController::class, 'destroy'])->name('characteristics.destroy');
Route::get('/characteristics/{id_caracteristique}/edit', [CaracteristiqueController::class, 'edit'])->name('characteristics.edit');
Route::put('/characteristics/{id_caracteristique}', [CaracteristiqueController::class, 'update'])->name('characteristics.update');




Route::get('/bondelivraison', [BonDeLivraisonController::class, 'index'])->name('bondelivraison')->middleware('auth');
Route::get('/configuration', [ConfigurationController::class, 'index'])->name('configuration')->middleware('auth');
Route::get('/report', [ConfigurationController::class, 'index'])->name('report')->middleware('auth');

// route demande
Route::get('/demandes', [DemandeController::class, 'showDemandes'])->name('demande.showDemandes');
Route::get('/demandes/create', [DemandeController::class, 'create'])->name('demande.create');
Route::post('/demandes', [DemandeController::class, 'store'])->name('demande.store');
Route::get('/demandes/{id}/edit', [DemandeController::class, 'edit'])->name('demande.edit');
Route::put('/demandes/{id}', [DemandeController::class, 'update'])->name('demande.update');
Route::get('/demandes/table', [DemandeController::class, 'Table'])->name('demande.Table');


Route::get('articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('articles/create', [ArticleController::class, 'create'])->name('articles.create');
Route::post('articles', [ArticleController::class, 'store'])->name('articles.store');
Route::get('articles/{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
Route::put('articles/{id}', [ArticleController::class, 'update'])->name('articles.update');
Route::delete('articles/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');

Route::resource('bons_de_livraison', BonDeLivraisonController::class);


/*
Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/admin', function () {
        
    });
});
Route::group(['middleware' => ['role:gestionnaire']], function () {
    Route::get('/gestionnaire', function () {
        
    });
});
Route::group(['middleware' => ['role:magasinier']], function () {
    Route::get('/magasinier', function () {
        
    });
});
*/