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

        // Se l'utente e loggato
        if (Auth::user()) {
            // Se in sessione c'è un carrello e user_id e null (whereNull) aggiungi alla colonna user_id l'id dell utente *********** risolto
            if(session('idCarrello') && OrdineTestata::whereNull('user_id') ) {
                // aggiungi alla colonna user_id l'id dell utente
                $CarrelloUtente = OrdineTestata::where('id', $idCarrello)->update(['user_id' => Auth::user()->id]);
            
            // Se la sessione e vuota e l'utente autenticato non a un carrello crea un carrello autenticato risolto
            } elseif (!session('idCarrello') || !OrdineTestata::find(session('idCarrello'))) {
                $idCarrello = OrdineTestata::firstOrCreate([ 'user_id' => Auth::user()->id, 'tipo' => 0]);
            
            /**
             * PRIMA DI RISOLVERE L'ULTIMO PROBLEMA CORREGGERE L'ERRORE CHE SE ELIMINO GLI ELEMENTI DAL DB, E NELLA SESSIONE RIMANE 
             * SALVATO UN NUMERO MI DA ARRORE PERCHE NON RIESCE A TROVARLO
             */
            
            // Se l’utente loggato ha un carrello aggiungere la roba che sta nel  carrello in sessione e poi eliminarlo risolvere questo problema
            // } elseif(OrdineTestata::where('user_id' , Auth::user()->id)->get()) {
            //     dd('ciao');
            }

        } elseif ($request->session()->missing('idCarrello') || !OrdineTestata::find(session('idCarrello'))) {
            session()->put('idCarrello', OrdineTestata::create(['tipo' => 0])->id);
        } 

        $idCarrello = session('idCarrello');


        $ordine = new OrdineRiga;
        $ordine->ordine_testata_id = $idCarrello;
        $ordine->ricambio_id = $request->ricambio_id;
        $ordine->quantità = $request->quantità;
        $ordine->save();

        return redirect('/');
    }
}
