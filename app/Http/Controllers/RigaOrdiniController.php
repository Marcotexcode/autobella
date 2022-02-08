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

        // Se l'utente e loggato
        if (Auth::user()) {
            
            // Se in sessione c'è un carrello e user_id ed è null (whereNull) aggiungi alla colonna user_id l'id dell utente 
            // Quando la sessione e piena e la trova con find()
            if(session('idCarrello') && OrdineTestata::whereNull('user_id')) {
                $idCarrello = session('idCarrello');

                $idCarrelloUtente = OrdineTestata::where('id', $idCarrello)->update(['user_id' => Auth::user()->id]);
                
            // Se la sessione e vuota o non la trova l'utente autenticato non a un carrello crea un carrello autenticato 
            } elseif (!session('idCarrello') /*|| !OrdineTestata::find(session('idCarrello'))*/) {
                $idCarrello = session('idCarrello');
                $idCarrello = OrdineTestata::firstOrCreate([ 'user_id' => Auth::user()->id, 'tipo' => 0])->id;
            }
            // Se l'elemento non e presente nella sessione oppure non riesce a recuperare la riga carrello dal database
        } elseif ($request->session()->missing('idCarrello') || !OrdineTestata::find(session('idCarrello'))) {
            $idCarrello = session('idCarrello');
            session()->put('idCarrello', OrdineTestata::create(['tipo' => 0])->id);
        } 

        $idCarrello = session('idCarrello');
       
        // Se la richiesta ricambio_id  e uguale alla colonna ricambio_id SE HA UGUALE 'ordine_testata_id' $idCarrello
        if (in_array($request->ricambio_id, OrdineRiga::where('ordine_testata_id', $idCarrello)->pluck('ricambio_id')->toArray())) {
            // Dove ricambo_id e request->ricambio_id sono uguali e 'ordine_testata_id', $idCarrello sono uguali incrementare la quantità in base alla $request->quantità
            OrdineRiga::where('ricambio_id', $request->ricambio_id)->where('ordine_testata_id', $idCarrello)->increment('quantità', $request->quantità);
        } else {
            $ordine = new OrdineRiga;
            $ordine->ordine_testata_id = $idCarrello;
            $ordine->ricambio_id = $request->ricambio_id;
            $ordine->quantità = $request->quantità;
            $ordine->save();
        }
        return redirect('/');
    }
}
