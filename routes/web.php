<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
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
use App\Http\Controllers\CompanySettingsController;
use App\Http\Controllers\CompanyInfoController;
use App\Http\Controllers\ProfileSettingsController;
use App\Http\Controllers\DepotSettingsController;
use App\Http\Controllers\FacteurController;
use App\Http\Controllers\FacteurSettingController;
use App\Http\Controllers\BonDeDemandeSettingController;
use App\Http\Controllers\BonDeLivraisonSettingController;







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
Route::get('/commande/search', [CommandeController::class, 'search'])->name('commande.search');
Route::get('/fournisseurs/search', [FournisseurController::class, 'search'])->name('fournisseurs.search');
Route::get('/utilisateurs/search', [UtilisateurController::class, 'search'])->name('utilisateurs.search');
Route::get('/categories/search', [CategoryController::class, 'search'])->name('categories.search');
Route::get('/commandes/search', [CommandeController::class, 'search'])->name('commandes.search');
Route::get('articles/create', [ArticleController::class, 'create'])->name('articles.create');



Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');




// Routes for Login
Auth::routes();


/*
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
*/
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/dashboard/search', [DashboardController::class, 'search'])->name('dashboard.search');



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
Route::get('/get-demandes/{deliveryAddress}', [BonDeLivraisonController::class, 'getDemandes'])->name('get.demandes');
Route::get('/bons_de_livraison/{id}', [BonDeLivraisonController::class, 'status'])->name('bons_de_livraison.status');
Route::get('/bons_de_livraison/{id}/document', [BonDeLivraisonController::class, 'showDocument'])->name('bons_de_livraison.document');
Route::get('/bons_de_livraison/{id}/bon de livraison/download', [BonDeLivraisonController::class, 'pdfDownload'])->name('bondelivraison.download');


Route::get('/configuration', [ConfigurationController::class, 'index'])->name('configuration')->middleware('auth');

// Report routes
Route::get('/report', [ReportController::class, 'index'])->name('report.index')->middleware('auth');
Route::post('report/download', [ReportController::class, 'downloadReport'])->name('report.download');

// route demande
Route::get('/demandes', [DemandeController::class, 'index'])->name('demande.index')->middleware('auth');
Route::get('/demandes/create', [DemandeController::class, 'create'])->name('demande.create');
Route::post('/demandes', [DemandeController::class, 'store'])->name('demande.store');
Route::get('/demandes/{id}/edit', [DemandeController::class, 'edit'])->name('demande.edit');
Route::put('/demandes/{id}', [DemandeController::class, 'update'])->name('demande.update');
Route::delete('/demandes/{id}', [DemandeController::class, 'destroy'])->name('demande.destroy');
Route::get('/demandes/table', [DemandeController::class, 'Table'])->name('demande.Table');
Route::get('/demandes/magasiniers', [DemandeController::class, 'getMagasiniers'])->name('demande.getMagasiniers');
Route::get('/demandes/status/{id}',[DemandeController::class, 'changeStatus'])->name('demande.status');
Route::get('/demandes/{id}', [DemandeController::class, 'show'])->name('demande.show');
Route::get('/demandes/{id}/bon de demande', [DemandeController::class, 'showbondedemande'])->name('demande.showbondedemande');
Route::get('/demandes/{id}/bon de demande/download', [DemandeController::class, 'pdfDownload'])->name('bondedemande.download');




Route::get('articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('articles/{id}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('articles/{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
Route::put('articles/{id}', [ArticleController::class, 'update'])->name('articles.update');






// route principale to configuration
Route::get('/configuration', [ConfigurationController::class, 'index'])->name('configuration.index');



Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/search', [CategoryController::class, 'search'])->name('categories.search');

Route::get('/commandes', [CommandeController::class, 'index'])->name('commandes.index');

// Route for Profile Information settings
Route::get('configuration/profile-settings', [ProfileSettingsController::class, 'index'])->name('profile.settings');
Route::post('configuration/profile-settings', [ProfileSettingsController::class, 'store'])->name('profile.settings.store');
// Route for Depot Settings
Route::get('configuration/depot-settings', [DepotSettingsController::class, 'index'])->name('depot.settings');
Route::post('configuration/depot-settings', [DepotSettingsController::class, 'store'])->name('depot.settings.store');
Route::put('configuration/depot-settings', [DepotSettingsController::class, 'store'])->name('depot.settings.update');

Route::group(['middleware' => ['auth','role:admin']], function () {
Route::get('configuration/company-info', [CompanyInfoController::class, 'index'])->name('company.info');

Route::prefix('configuration')->group(function () {
    // Route for Company Information settings
    Route::get('/company-settings', [CompanySettingsController::class, 'index'])->name('company.settings');
    Route::post('/company-settings', [CompanySettingsController::class, 'store'])->name('company.settings.store');
    Route::put('/company-settings/{company}', [CompanySettingsController::class, 'update'])->name('company.settings.update');
    
    // Routes pour les paramètres de facteur
    Route::get('/facteur-settings', [FacteurSettingController::class, 'index'])->name('facteur.settings');
    Route::post('/facteur-settings', [FacteurSettingController::class, 'store'])->name('facteur.settings.store');
    Route::put('/facteur-settings/{facteur}', [FacteurSettingController::class, 'update'])->name('facteur.settings.update');
    // Route pour les paramètres de bon de demande
    Route::get('/bon de demande-settings', [BonDeDemandeSettingController::class, 'index'])->name('bon_de_demande.settings');
    Route::post('/bon de demande-settings', [BonDeDemandeSettingController::class, 'store'])->name('bon_de_demande.settings.store');
    Route::put('/bon de demande-settings/{bondedemande}', [BonDeDemandeSettingController::class, 'update'])->name('bon_de_demande.settings.update');
    // Routes pour les paramètres de bon de livraison
    Route::get('/bon de livraison-settings', [BonDeLivraisonSettingController::class, 'index'])->name('bon_de_livraison.settings');
    Route::post('/bon de livraisonr-settings', [BonDeLivraisonSettingController::class, 'store'])->name('bon_de_livraison.settings.store');
    Route::put('/bon de livraison-settings/{bondelivraison}', [BonDeLivraisonSettingController::class, 'update'])->name('bon_de_livraison.settings.update');
});

Route::delete('articles/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');
Route::get('articles/caracteristiques/{category_id}', [ArticleController::class, 'getCaracteristiques'])->name('articles.caracteristiques');
Route::get('/articles/search', [ArticleController::class, 'search'])->name('articles.search');
    
Route::get('/factures', [FacteurController::class, 'index'])->name('facteurs.index');
Route::delete('/factures/{id}', [FacteurController::class, 'destroy'])->name('facteurs.destroy');
Route::get('/factures/{id}/edit', [FacteurController::class, 'edit'])->name('factures.edit');
Route::put('/factures/{id}', [FacteurController::class, 'update'])->name('factures.update');
Route::get('/factures/{id}/print', [FacteurController::class, 'print'])->name('factures.print');
Route::get('/factures/{id}', [FacteurController::class, 'show'])->name('factures.show');
Route::get('/factures/{id}/details', [FacteurController::class, 'showone'])->name('factures.showone');
Route::get('/factures/create/{id}', [FacteurController::class, 'create'])->name('factures.create');
Route::post('/factures/{id}', [FacteurController::class, 'store'])->name('factures.store');
Route::get('/factures/{id}/download', [FacteurController::class, 'downloadPDF'])->name('factures.download');

// Utilisateur
Route::get('/utilisateurs/search', [UserController::class, 'search'])->name('utilisateurs.search');
Route::resource('utilisateur', UserController::class)->parameters(['utilisateur' => 'id']);
// Commande
Route::resource('commande', CommandeController::class)->parameters(['commande' => 'id']);


// Fournisseur
Route::resource('fournisseur', FournisseurController::class)->parameters(['fournisseur' => 'id'])->middleware('auth');
// Articles
Route::get('articles/create', [ArticleController::class, 'create'])->name('articles.create');
Route::post('articles', [ArticleController::class, 'store'])->name('articles.store');


Route::delete('articles/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');
Route::get('articles/caracteristiques/{category_id}', [ArticleController::class, 'getCaracteristiques'])->name('articles.caracteristiques');
Route::get('/articles/search', [ArticleController::class, 'search'])->name('articles.search');




Route::get('/fournisseurs/search', [FournisseurController::class, 'search'])->name('fournisseurs.search');
});

Route::group(['middleware' => ['auth','role:magasinier']], function () {
    Route::get('articles/add/{id}', [ArticleController::class, 'addStock'])->name('articles.add');
    Route::post('articles/update-stock/{id}', [ArticleController::class, 'updateStock'])->name('articles.updateStock');
    Route::delete('articles/cancel-stock/{id}', [ArticleController::class, 'cancelStock'])->name('articles.cancelStock');
});
/*
Route::get('test-role', function () {
    return 'Role middleware is working correctly';
})->middleware(['auth', 'role:admin']);

Route::group(['middleware' => ['role:gestionnaire']], function () {
    
});

*/