<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ricambio;
use App\Models\Marca;
use App\Models\Modello;
use App\Models\OrdineTestata;
use App\Models\OrdineRiga;

use Illuminate\Support\Facades\DB;
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


        // PROVA **************************
        $ric = Ricambio::all();
        foreach ($ric as $value) {
            foreach ($value->modelli as $item) {
                //dd($item);

            }
        }
        // PROVA **************************




        $filtriRicerca = session('filtriRicerca');
        $modelli = Modello::all();
        $marche = Marca::all();


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

        // Creare variabile per il totale delle righe a 0
        $totaleRigheOrdine = 0;

        // Creare un array vuoto nel caso le condizioni sono false
        $carrelli= [];

        // Se in sessione c'è un carrello
        if (session('idCarrello')) {

            // FUNZIONE Prendi il carrello anonimo
            $carrelli = OrdineTestata::carrelloAnonimo()->get();

        // Se sei autenticato
        } elseif(Auth::user()) {

            // FUNZIONE Prendi il carrello autenticato
            $carrelli = OrdineTestata::carrelloUtente()->get();

        }

        // Prendere tutti i record della colonna row_order_id
        foreach ($carrelli as $carrello) {
            // Sommare quantity
            $totaleRigheOrdine = $totaleRigheOrdine + $carrello->ordine_righe->sum('quantità');
        }
        $idCarrello = session('idCarrello');
        $ricambi = $ricambi->get();
        
        return view('welcome', compact('ricambi','totaleRigheOrdine','idCarrello', 'modelli', 'marche'));
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
