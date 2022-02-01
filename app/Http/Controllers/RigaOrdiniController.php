<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\OrdineTestata;
use App\Models\OrdineRiga;


class RigaOrdiniController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'quantità' => 'required',
        ],
        [
            'quantità.required' => 'Inserire quantità!!'
        ]);
        
        $idCarrello = session('idCarrello');
       // dd($idCarrello);
        // Se l'utente e loggato
        if (Auth::user()) {
            // Se in sessione c'è un carrello e user_id e null (whereNull) aggiungi alla colonna user_id l'id dell utente *********** risolto
            // Quando la sessione e piena e la trova con find()
            if(session('idCarrello') && OrdineTestata::whereNull('user_id') && OrdineTestata::find(session('idCarrello'))) {
                // aggiungi alla colonna user_id l'id dell utente
                // dd('pluto');
                $idCarrelloUtente = OrdineTestata::where('id', $idCarrello)->update(['user_id' => Auth::user()->id]);
            
            // Se la sessione e vuota o non la trova l'utente autenticato non a un carrello crea un carrello autenticato 
            } elseif (!session('idCarrello') || !OrdineTestata::find(session('idCarrello'))) {
                $idCarrello = OrdineTestata::firstOrCreate([ 'user_id' => Auth::user()->id, 'tipo' => 0])->id;
                //dd('pippo');
                
                 /**
                  * Quando un utente non loggato aggiunge un carrello in sessione
                  * appena si logga quel carrello in sessione si deve trasferire nel carrello dell utente loggato
                  */
            
            // Se l’utente loggato ha un carrello aggiungere la roba che sta nel  carrello in sessione e poi eliminarlo risolvere questo problema
            // } elseif(OrdineTestata::where('user_id' , Auth::user()->id)->get()) {
            //     dd('ciao');
            }
            /**
             *  Se non sei autenticato la sessione e vuota o non trova l'id della sessione 
             * aggiungi un nuovo id alla sessione
            */ 
        } elseif ($request->session()->missing('idCarrello') || !OrdineTestata::find(session('idCarrello'))) {
            //dd('pluto');
            session()->put('idCarrello', OrdineTestata::create(['tipo' => 0])->id);
        } 


        $ordine = new OrdineRiga;
        $ordine->ordine_testata_id = $idCarrello;
        $ordine->ricambio_id = $request->ricambio_id;
        $ordine->quantità = $request->quantità;
        $ordine->save();

        return redirect('/');
    }
}

// Spostare la getsione del carrelo da un altra parte

// Se un Articolo e gia ce nel db viene riaggiunto sovrascriverlo aggiungendo la quantita totale 