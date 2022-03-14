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

/*
======================
    Page principale
======================
*/

//route racine pour utilisateur non authentifié
Route::get('/', [PizzaController::class,'index'])->name('index');
// Route::get('/', [PizzaController::class,'index'])->middleware('auth')->name('index');//auth probleme de route

//route pour utilisateur authentifié
Route::get('/home',[PizzaController::class,'home'])->middleware('auth')->name('home'); //pour user

/*
=======================
    L'enregistrement
=======================
*/

//enregistrement des nouveaux utilisateurs
Route::get('/register',[RegisterUserController::class,'register_form'])->name('auth.register_form'); //formulaire enregistrement
Route::post('/register',[RegisterUserController::class,'enregistrer']); //enregistrement

/*
===============
    Le login
===============
*/

Route::get('/login',[AuthenticatedSessionController::class,'login_form'])->name('login'); //formulaire de connexion
Route::post('/login',[AuthenticatedSessionController::class,'login']); //connexion
Route::get('/logout',[AuthenticatedSessionController::class,'logout'])->name('logout')->middleware('auth'); //deconnexion

/*
============
    Admin
============
*/

Route::get('/admin',[CompteController::class,'admin_home'])->middleware('auth')->middleware('is_admin');//pour admin
Route::get('/ajout_pizza',[PizzaController::class,'ajout_form'])->middleware('auth')->middleware('is_admin')->name('pizza.ajout_form'); //formulaire ajout
Route::post('/ajout_pizza',[PizzaController::class,'ajout_pizza'])->middleware('auth')->middleware('is_admin')->name('pizza.ajout'); //ajout
Route::get('/edit_pizza/{id}',[PizzaController::class,'edit_form'])->middleware('auth')->middleware('is_admin')->name('pizza.edit_form'); //formulaire edition
Route::post('/edit_pizza/{id}',[PizzaController::class,'edit_pizza'])->middleware('auth')->middleware('is_admin')->name('pizza.edit'); //edition
Route::get('/supp_pizza/{id}',[PizzaController::class,'suppPizza_form'])->middleware('auth')->middleware('is_admin')->name('admin.supp_form');//formulaire de suppression
Route::post('/supp_pizza/{id}',[PizzaController::class,'suppPizza'])->middleware('auth')->middleware('is_admin')->name('admin.supp_pizza');//supression

/*
============
    User
============
*/

//gestion du compte
Route::get('/mon_compte',[CompteController::class,'mon_compte'])->name('mon_compte');
Route::get('/mon_compte/edit_mdp',[CompteController::class,'edit_mdp_form'])->name('edit_mdp_form');
Route::post('/mon_compte/edit_mdp',[CompteController::class,'edit_mdp'])->name('edit_mdp');

//panier
Route::get('/mon_panier',[CompteController::class,'mon_panier'])->middleware('auth')->name('mon_panier');
//ajout de pizza au panier
Route::post('/mon_panier/ajout/{id}',[PizzaController::class,'mon_panier_ajout'])->middleware('auth')->name('mon_panier_ajout');//ajout si exite pas / exite 
Route::post('/mon_panier/delete/{id}',[PizzaController::class,'mon_panier_delete'])->middleware('auth')->name('mon_panier_delete');
Route::post('/mon_panier/mise_a_jour',[PizzaController::class,'mon_panier_miseajour'])->middleware('auth')->name('mon_panier_miseajour');
Route::post('/mon_panier/deleteall/{id}',[PizzaController::class,'mon_panier_deleteall'])->middleware('auth')->name('mon_panier_deleteall');
//ajout commande
Route::get('/mon_panier/commander',[CompteController::class,'cree_commande'])->middleware('auth')->name('cree_commande');

//user mes commandes
Route::get('/user/commande/mes_commandes',[CompteController::class,'mes_commandes'])->middleware('auth')->name('user.mes_commandes');
Route::get('/user/commande/mes_commandes_nonRecup',[CompteController::class,'mes_commandes_nonRecup'])->middleware('auth')->name('user.mes_commande_nonRecup');
//voir les details de la commandes
Route::get('/user/commande/mes_commandes/details/{id}',[CompteController::class,'mes_commandes_details'])->middleware('auth')->name('user.mes_commandes_details');

/*
============
    Cook
============
*/
//cook
Route::get('/cook_liste',[CompteController::class,'cook_liste'])->middleware('auth')->middleware('is_cook')->name('cook_liste');//_>middleware('cook')
Route::get('/commande_details/{id}',[CompteController::class,'commande_details'])->middleware('auth')->middleware('is_cook')->name('commande_details');

Route::post('/cook/change_statut_traitement/{id}',[CompteController::class,'change_statut_traitement'])->middleware('auth')->middleware('is_cook')->name('change_statut_traitement');
Route::post('/cook/change_statut_pret/{id}',[CompteController::class,'change_statut_pret'])->middleware('auth')->middleware('is_cook')->name('change_statut_pret');
Route::post('/cook/change_statut_recupere/{id}',[CompteController::class,'change_statut_recupere'])->middleware('auth')->middleware('is_cook')->name('change_statut_recupere');