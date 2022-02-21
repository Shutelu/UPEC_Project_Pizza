<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PizzaController;

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

//route racine
Route::get('/', [PizzaController::class,'index'])->name('index');

//route ajout
Route::get('/ajout_pizza',[PizzaController::class,'ajout_form'])->name('pizza.ajout_form');
Route::post('/ajout_pizza',[PizzaController::class,'ajout_pizza'])->name('pizza.ajout');

//route edit
Route::get('/edit_pizza/{id}',[PizzaController::class,'edit_form'])->name('pizza.edit_form');
Route::post('/edit_pizza/{id}',[PizzaController::class,'edit_pizza'])->name('pizza.edit');