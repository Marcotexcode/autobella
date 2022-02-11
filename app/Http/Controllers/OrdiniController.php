<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdineTestata;
use App\Models\OrdineRiga;
use App\Models\Ricambio;

use Illuminate\Support\Facades\Auth;


class OrdiniController extends Controller
{
    public function index()
    {
       $elencoOrdini = OrdineTestata::all();


        return view('ordini.index', compact('elencoOrdini'));
    }

    public function update(Request $request, $id)
    {
       // dd($id);
        $ordineRiga = OrdineTestata::find($id)->update(['tipo' => 2]);
        return redirect()->route('ordini.index');
    }

    // public function statoCarrello(Request $request, $id)
    // {
    //     dd($id);
    //     $carrello->update();
    //     $tipoOrdine = new OrdineTestata;


    //     return redirect()->route('ordini.index');
    // }
}
