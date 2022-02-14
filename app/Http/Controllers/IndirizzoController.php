<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdineTestata;
use App\Models\OrdineRiga;
use App\Models\User;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

use App\Mail\OrdineInviato;


class IndirizzoController extends Controller
{   
    public function index()
    {
        // FUNZIONE 
        $idCarrello = OrdineTestata::carrelloUtente()->value('id');

        // FUNZIONE 
        $totalePrezzoPerQuantità = OrdineRiga::totaleRiga();

        // Sommo il totale degli elementi
        $sommaTotale = array_sum($totalePrezzoPerQuantità);

        return view('indirizzo.indirizzo', compact('sommaTotale', 'idCarrello' ));
    }

    public function store(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->get();

        OrdineTestata::where('user_id', Auth::user()->id)->update([
            'indirizzo' => $request->indirizzo,
            'telefono' => $request->telefono,
            'tipo' => 1
        ]);

        // Per inviare una notifica customizzata inserendo l'utente autenticato
        Mail::to($user)->send(new OrdineInviato);     
        
        return redirect()->route('speditoOrdine');
    }
}
