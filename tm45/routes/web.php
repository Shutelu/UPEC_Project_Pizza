<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\CompteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//route racine pas encore authentifier
Route::get('/', [PizzaController::class,'index'])->name('index');
// Route::get('/', [PizzaController::class,'index'])->middleware('auth')->name('index');//auth probleme de route

Route::get('/home',[PizzaController::class,'home'])->middleware('auth')->name('home');

Route::get('/admin',[PizzaController::class,'admin_home'])->middleware('auth')->middleware('is_admin');

//route ajout
Route::get('/ajout_pizza',[PizzaController::class,'ajout_form'])->name('pizza.ajout_form');
Route::post('/ajout_pizza',[PizzaController::class,'ajout_pizza'])->name('pizza.ajout');

//route edit
Route::get('/edit_pizza/{id}',[PizzaController::class,'edit_form'])->name('pizza.edit_form');
Route::post('/edit_pizza/{id}',[PizzaController::class,'edit_pizza'])->name('pizza.edit');

//register user
Route::get('/register',[RegisterUserController::class,'register_form'])->name('auth.register_form');
Route::post('/register',[RegisterUserController::class,'enregistrer']);

//login user
Route::get('/login',[AuthenticatedSessionController::class,'login_form'])->name('login');
Route::post('/login',[AuthenticatedSessionController::class,'login']);
Route::get('/logout',[AuthenticatedSessionController::class,'logout'])->name('logout')->middleware('auth');

//mon compte
Route::get('/mon_compte',[CompteController::class,'mon_compte'])->name('mon_compte');
Route::get('/mon_compte/edit_mdp',[CompteController::class,'edit_mdp_form'])->name('edit_mdp_form');
Route::post('/mon_compte/edit_mdp',[CompteController::class,'edit_mdp'])->name('edit_mdp');

//panier
Route::get('/mon_panier',[CompteController::class,'mon_panier'])->middleware('auth')->name('mon_panier');
//ajout de pizza au panier
Route::post('/mon_panier/ajout/{id}',[PizzaController::class,'mon_panier_ajout'])->middleware('auth')->name('mon_panier_ajout');//ajout si exite pas / exite 
Route::post('/mon_panier/delete/{id}',[PizzaController::class,'mon_panier_delete'])->middleware('auth')->name('mon_panier_delete');
Route::post('/mon_panier/mise_a_jour',[PizzaController::class,'mon_panier_miseajour'])->middleware('auth')->name('mon_panier_miseajour');
// Route::post();
//ajout commande
Route::get('/mon_panier/commander',[CompteController::class,'cree_commande'])->middleware('auth')->name('cree_commande');