<?php

namespace App\Http\Controllers;

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

        // Se la sessione e vuota crea un carrello
        if (!$request->session()->has('idCarrello')) {
            $testataOrdine = OrdineTestata::create(['tipo' => 0]);
            session()->put('idCarrello', $testataOrdine->id);
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
