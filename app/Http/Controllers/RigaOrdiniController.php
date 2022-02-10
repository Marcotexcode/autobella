<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\OrdineTestata;
use App\Models\OrdineRiga;
use App\Models\Ricambio;


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

        // Quando non sono loggato 
        if (!Auth::user()) {
            // Se la sessione e vuota o non la trova
            if ($request->session()->missing('idCarrello') || !OrdineTestata::find(session('idCarrello'))) {
                // Creo un carrello anonimo e aggiungo alla sessione l'id del carrello 
                session()->put('idCarrello', OrdineTestata::create(['tipo' => 0])->id);
            }
        } 

        // Se la sessione e vuota e l'utente non ha non carrello creane uno 
        if (!session('idCarrello')) {
            $idCarrello = OrdineTestata::firstOrCreate([ 'user_id' => Auth::user()->id, 'tipo' => 0])->id;
        }

        $idCarrello = session('idCarrello');
   

        // Se la richiesta ricambio_id  e uguale alla colonna ricambio_id SE HA UGUALE 'ordine_testata_id' $idCarrello
        if (in_array($request->ricambio_id, OrdineRiga::where('ordine_testata_id', $idCarrello)->pluck('ricambio_id')->toArray())) {
            
            // Dove ricambo_id e request->ricambio_id sono uguali e 'ordine_testata_id', $idCarrello sono uguali incrementare la quantità in base alla $request->quantità
            OrdineRiga::where('ricambio_id', $request->ricambio_id)->where('ordine_testata_id', $idCarrello)->increment('quantità', $request->quantità);
        } else {
            $ordine = new OrdineRiga;
            // Se la sessione non è vuota allora aggiungi l'id che si trova nella sessione (carrello anonimo), se e vuota allora aggiungi l'id del (carrello utente)  
            $ordine->ordine_testata_id = $idCarrello ? $idCarrello : OrdineTestata::where('user_id', Auth::user()->id)->value('id');
            $ordine->ricambio_id = $request->ricambio_id;
            $ordine->quantità = $request->quantità;
            $ordine->prezzo = Ricambio::where('id', $request->ricambio_id)->value('prezzo');
            $ordine->save();
        }
        return redirect('/');
    }
}
