<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\RegisterUserController;

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
//une fois authentifier
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