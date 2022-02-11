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
        // Prendi tutti gli ordini(tipo1)
        $elencoOrdini = OrdineTestata::where('tipo', 1)->get();

        return view('ordini.index', compact('elencoOrdini'));
    }

    public function update(Request $request, $id)
    {
        // modifica l'ordine(tipo1) in ordine spedito(tipo2)
        $ordineRiga = OrdineTestata::find($id)->update(['tipo' => 2]);

        return redirect()->route('ordini.index');
    }

}
