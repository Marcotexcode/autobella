<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OrdineRiga;
use App\Models\OrdineTestata;


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

        // Se in sessione c'è un carrello 
        if (session('idCarrello')) {

            // Prendi le righe del carrello anonimo 
            $ordineRighe = OrdineRiga::where('ordine_testata_id', session('idCarrello'))->get();
        
        // Se sei autenticato 
        } elseif(Auth::user()) {

            // Prendi l'id dell' utente autenticato 
            $idCarrello = OrdineTestata::where('user_id', Auth::user()->id)->value('id');

            // Prendi le righe del carrello autenticato
            $ordineRighe = OrdineRiga::where('ordine_testata_id', $idCarrello)->get();
        }

        return view('carrello.index', compact('ordineRighe'));
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
