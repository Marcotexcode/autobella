<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FornitoriController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\RicambiController;
use App\Http\Controllers\MarcheController;



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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/fori', function () {
    return view('fornitori.index');
});

//Route::view('/forintori', 'fornitori.index');

Auth::routes();

Route::resource('fornitori', FornitoriController::class);
Route::resource('categorie', CategorieController::class);
Route::resource('ricambi', RicambiController::class);
Route::resource('marche', MarcheController::class);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
