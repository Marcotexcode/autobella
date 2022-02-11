<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OrdineRiga;
use App\Models\OrdineTestata;
use App\Models\Ricambio;



class CarrelloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Quando le condizioni sono tutte false 
        $ordineRighe = [];
        $idCarrello = null;
        // Se in sessione c'è un carrello 
        if (session('idCarrello')) {

            // Prendi le righe del carrello anonimo 
            $ordineRighe = OrdineRiga::where('ordine_testata_id', session('idCarrello'))->get();
            
            // Prendi l'id del carrello anonimo 
            $idCarrello = OrdineTestata::where('id', session('idCarrello'))->value('id');
            
        // Se sei autenticato 
        } elseif(Auth::user()) {

            // Prendi l'id dell' utente autenticato 
            $idCarrello = OrdineTestata::where('user_id', Auth::user()->id)->where('tipo', 0)->value('id');

            // Prendi le righe del carrello autenticato
            $ordineRighe = OrdineRiga::where('ordine_testata_id', $idCarrello)->get();
        }

        // PREZZO TOTALE ********************************************************************************************************

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

        // Totale prezzo di un singolo ricambio 

        //  ********************************************************************************************************
        
        return view('carrello.index', compact('ordineRighe', 'sommaTotale',  'totalePrezzoPerQuantità'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ordineRiga = OrdineRiga::find($id);
        //dd($ordineRiga);
        return view('carrello.edit', compact('ordineRiga'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantità' => 'required|numeric|min:0|not_in:0'
        ]);

        $ordineRiga = OrdineRiga::find($id)->update($request->all());

        return redirect()->route('carrello.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        OrdineRiga::find($id)->delete();
        return redirect()->route('carrello.index');
    }
}
