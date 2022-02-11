<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdineTestata;
use App\Models\OrdineRiga;
use App\Models\User;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;


//use App\Notifications\ordineInviato;

use Illuminate\Support\Facades\Auth;
use App\Mail\OrdineInviato;


class IndirizzoController extends Controller
{   
    public function index()
    {

        // Prendi l'id dell'carrello(tipo0) dell' utente autenticato 
        $idCarrello = OrdineTestata::where('user_id', Auth::user()->id)->where('tipo', 0)->value('id');

        // Prendi le righe del carrello(tipo0) autenticato
        $ordineRighe = OrdineRiga::where('ordine_testata_id', $idCarrello)->get();

        // Prendere la quantità di ogni riga e le metto in un array
        $quantitaRiga =  OrdineRiga::where('ordine_testata_id',  $idCarrello)->pluck('quantità')->toArray();

        // Prendere il prezzo di ogni riga e li metto in un array
        $prezzoRicambio = OrdineRiga::where('ordine_testata_id',  $idCarrello)->pluck('prezzo')->toArray();

        // Creo un array per inserire il prezzo del ricambio per la quantità
        $totalePrezzoPerQuantità = [];

        // Creo un ciclo per moltiplicare gli elementi dei due array
        for ($i=0; $i < count($prezzoRicambio); $i++) { 

            // Moltiplico gli elementi e il risultato l'ho aggiungo in un altro array
            array_push($totalePrezzoPerQuantità, $prezzoRicambio[$i] * $quantitaRiga[$i]);
        }

        // Sommo il totale degli elementi
        $sommaTotale = array_sum($totalePrezzoPerQuantità);

        return view('indirizzo.indirizzo', compact('sommaTotale', 'idCarrello' ));
    }

    public function store(Request $request)
    {
        // $userId = auth()->user()->id;

        $user = User::where('id', Auth::user()->id)->get();

        OrdineTestata::where('user_id', Auth::user()->id)->update([
            'indirizzo' => $request->indirizzo,
            'telefono' => $request->telefono,
            'tipo' => 1
        ]);

        
        // Per inviare una notifica inserendo l'utente autenticato
        //Notification::send($user, new ordineInviato());

        // Per inviare una notifica customizzata inserendo l'utente autenticato
        Mail::to($user)->send(new OrdineInviato);     
        
        return redirect()->route('speditoOrdine');
    }
}
