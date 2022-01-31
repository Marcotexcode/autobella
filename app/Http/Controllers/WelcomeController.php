<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ricambio;
use App\Models\Marca;
use App\Models\Modello;
use App\Models\OrdineTestata;
use Illuminate\Database\Eloquent\Builder;


use Illuminate\Support\Facades\Auth;


class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ricambi = Ricambio::query();
        
        $filtriRicerca = session('filtriRicerca');

        $prova = Ricambio::all();       
       
        // Filtri Search
        if(isset($filtriRicerca['nomeRicambio'])) {
            $ricambi = $ricambi->where('codice', 'LIKE', "%{$filtriRicerca['nomeRicambio']}%");
        }

        if(isset($filtriRicerca['marcaAuto'])) {
            $ricambi = $ricambi->whereHas('modelli.marca', function (Builder $query) use($filtriRicerca) {
                $query->where('nome', 'LIKE', "%{$filtriRicerca['marcaAuto']}%");
            });
        }

        if(isset($filtriRicerca['modelloAuto'])) { 
            $ricambi = $ricambi->whereHas('modelli', function (Builder $query) use($filtriRicerca) {
                $query->where('nome', 'LIKE', "%{$filtriRicerca['modelloAuto']}%");
            });
        }

        if(isset($filtriRicerca['annoAuto'])) {
            $ricambi = $ricambi->whereHas('modelli', function (Builder $query) use($filtriRicerca) {
                $query->where('anno_commercializzazione', 'LIKE', "%{$filtriRicerca['annoAuto']}%");
            });
        }

        // Vedere se l'utente ha un carrello
        $carrelli = OrdineTestata::where('id', session('idCarrello'))->get();

        $righeOrdine = 0;

        // Prendere tutti i record della colonna row_order_id 
        foreach ($carrelli as $carrello) { 
            // Sommare quantity 
            $righeOrdine = $righeOrdine + $carrello->ordine_righe->sum('quantità');  
        } 
        $idCarrello = session('idCarrello');
        $ricambi = $ricambi->get();
        
        return view('welcome', compact('ricambi','righeOrdine','idCarrello'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function filtroRicerca(Request $request)
    {
        $datiRicerca = array (
            'nomeRicambio' => $request->input('nomeRicambio'),
            'marcaAuto' => $request->input('marcaAuto'),
            'modelloAuto' => $request->input('modelloAuto'),
            'annoAuto' => $request->input('annoAuto'),
        );

        session()->put('filtriRicerca', $datiRicerca);
        
        return redirect('/');
    }
}
