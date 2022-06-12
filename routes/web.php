<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FornitoriController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\RicambiController;
use App\Http\Controllers\MarcheController;
use App\Http\Controllers\ModelliController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\RigaOrdiniController;
use App\Http\Controllers\CarrelloController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndirizzoController;
use App\Http\Controllers\OrdiniController;
use App\Mail\OrdineInviato;
use App\Mail\OrdineSpedito;



use App\Http\Middleware\Carrello;

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



Auth::routes();

// middleweare carrello
Route::middleware(Carrello::class)->group(function () {
    Route::view('/', 'welcome');
    Route::resource('/', WelcomeController::class);
    Route::resource('ordine', RigaOrdiniController::class);
    Route::resource('carrello', CarrelloController::class);
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});



// Rotte per amministratore
Route::middleware('can:administer')->prefix('admin')->group(function () {
    Route::resource('categorie', CategorieController::class);
    Route::resource('modelli', ModelliController::class);
    Route::resource('marche', MarcheController::class);
    Route::resource('ricambi', RicambiController::class);
    Route::resource('fornitori', FornitoriController::class);
});

Route::post('/filtro', [WelcomeController::class, 'filtroRicerca'])->name('filtroRicerca');


// Indirizzo conferma
Route::view('/indirizzo', 'indirizzo.indirizzo');
Route::view('/ordine_effettuato', 'indirizzo.spedito')->name('speditoOrdine');

Route::get('/indirizzo', [indirizzoController::class, 'index'])->name('indirizzo');
Route::post('/indirizzo', [IndirizzoController::class, 'store'])->name('indirizzo.store');


// Ordini effettuati
Route::view('/ordini', 'ordini.index');
Route::get('/ordini', [OrdiniController::class, 'index'])->name('ordini');
Route::put('ordini/{id}', [OrdiniController::class, 'update'])->name('ordini.update');

// Ordine spedito
Route::view('/ordine_spedito', 'ordineConfermato.index');


// Template Mail
Route::get('/email_inviato', function () {
    return new OrdineInviato();
});

Route::get('/email_spedito', function () {
    return new OrdineSpedito();
});
