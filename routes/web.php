<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
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

Route::get('/vente', [VenteController::class, 'index'])->name('vente')->middleware('auth');;
Route::get('/client', [ClientController::class, 'index'])->name('client')->middleware('auth');;
Route::get('/article', [ArticleController::class, 'index'])->name('article')->middleware('auth');;
Route::get('/fournisseur', [FournisseurController::class, 'index'])->name('fournisseur')->middleware('auth');;
Route::get('/commande', [CommandeController::class, 'index'])->name('commande')->middleware('auth');;
Route::get('/categorie', [CategorieController::class, 'index'])->name('categorie')->middleware('auth');;
Route::get('/magasin', [MagasinController::class, 'index'])->name('magasin')->middleware('auth');;
Route::get('/configuration', [ConfigurationController::class, 'index'])->name('configuration')->middleware('auth');;

