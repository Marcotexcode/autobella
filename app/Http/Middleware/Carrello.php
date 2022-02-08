<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OrdineTestata;
use App\Models\OrdineRiga;


class Carrello
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        // se l'utente ha gia un carrello appena si logga se ce un carrello in sessione lo aggiunge a quello dell'utente
        if (Auth::user()) {

            // Prendi il carrello dove 'user_id' ha l'id dell utente autenticato
            $carrello = OrdineTestata::where('user_id', Auth::user()->id)->value('user_id');
            if ($carrello) {

                // Prendi l'id dell carrello dell utente autenticato
                $idCarrelloUtente = OrdineTestata::where('user_id', Auth::user()->id)->value('id');

                // Prendi l'id dell carrello anonimo
                $carrelloAnonimo = OrdineTestata::where('user_id', null)->value('id');


                //modifica solo il record che ha come ordine_testata_id null
                OrdineRiga::where('ordine_testata_id', $carrelloAnonimo)->update(['ordine_testata_id' => $idCarrelloUtente]);

                //Alla fine il record con user_id null viene eliminato
                OrdineTestata::where('user_id', null)->delete();

                // Dato che quando elimino il carrello anonimo nella Sessione rimane salvato e mi da errore,
                // Devo aggiungere un nuovo carrello alla sessione
                // Aggiuggendo l'id del carrello del lutente autenticato
                session()->put('idCarrello', $idCarrelloUtente);



                // Prendo tutti gli id del ricambio dell utente autenticato e li metto in un array
                $ArrayRicambiUtente =  OrdineRiga::where('ordine_testata_id',  $idCarrelloUtente)->pluck('ricambio_id')->toArray();

                // Creo un array vuoto
                $ArrayRicambiUnici = [];

                // Ciclo l'$ArrayRicambiUtente con gli id dei ricambi
                for ($i=0; $i < count($ArrayRicambiUtente); $i++) {

                    // Controllo se nell' $ArrayRicambiUnici si trova l'id del ricambio

                    // Se non lo trova 
                    if (!in_array($ArrayRicambiUtente[$i], $ArrayRicambiUnici)) {

                        // Aggiunge nell' array $ArrayRicambiUnici l'id ricambio
                        array_push($ArrayRicambiUnici, $ArrayRicambiUtente[$i]);

                    // Se lo trova
                    } elseif(in_array($ArrayRicambiUtente[$i], $ArrayRicambiUnici)) {

                        // creo una variabile dove inserisco la quantita del ricambio con  chiave i 
                        $incrementoQuantita = OrdineRiga::where('ordine_testata_id', $idCarrelloUtente)->where('ricambio_id', $ArrayRicambiUtente[$i])->value('quantità');

                        // Incremento la quantita dei ricambi uguali 
                        OrdineRiga::where('ordine_testata_id',  $idCarrelloUtente)->where('ricambio_id', $ArrayRicambiUtente[$i])->increment('quantità', $incrementoQuantita);

                        // Elimino il ricambio un dei due ricambi con indice uguale 
                        OrdineRiga::where('ordine_testata_id',  $idCarrelloUtente)->where('ricambio_id', $ArrayRicambiUtente[$i])->limit(1)->delete();
                    }

                }

                // 1 - Creo un array vuoto
                // 2 - Ciclo l'array con gli id dei ricambi
                // 3 - Controllo se nell' array vuoto si trova l'id del ricambio
                // 4 - se non lo trova lo aggiunge, se lo trova somma la quantita

            }
        }

        return $next($request);
    }
}
