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
        // Se l'utente è autenticato, e in sessine c'è un carrello
        if (Auth::user() && session('idCarrello')) {

            /**
             *  QUANDO MI LOGGO SE CE UN CARRELLO ANONIMO E L'UTENTE HA GIA UN CARRELLO, GLI ARTICOLI DEL CARRELLO ANONIMO 
             *  VENGONO PRESI DALL CARRELLO DELL UTENTE, E IL CARRELLO ANONIMO VIENE ELMINATO
             *  SE INVECE L'UTENTE NON HA UN CARRELLO IL CARRELLO ANONIMO DIVENTA IL CARRELLO DELL'UTENTE
            */ 
            
            // Se l'utente ha già un carrello 
            if(OrdineTestata::where('user_id', Auth::user()->id)->value('user_id')) {

                // Prendo l'id del carrello che era anonimo 
                $carrelloAnonimo = OrdineTestata::where('id', session('idCarrello'))->value('id');

                // Prendo l'id del carrello dell' utente autenticato
                $idCarrelloUtente = OrdineTestata::where('user_id', Auth::user()->id)->value('id');

                // Modifico tutti i record degli articoli che hanno come ordine_testata_id, il carrello che era anonimo, con l'id del carrello autenticato
                OrdineRiga::where('ordine_testata_id', $carrelloAnonimo)->update(['ordine_testata_id' => $idCarrelloUtente]);

                // Elimino il carrello che era anonimo che si trova nella sessione
                OrdineTestata::where('id', session('idCarrello'))->delete();
               
            }

            // Se l'utente non ha il carrello 
            // Prendo il carrello in sessione e aggiungo nell' user_id, l'id dell utente autenticato
            OrdineTestata::where('id', session('idCarrello'))->update(['user_id' => Auth::user()->id]);

           
            // Cancello l'id del carrello che era anonimo dalla sessinoe 
            session()->forget('idCarrello');

            /* *********************************************************************************************************************************** */

        }

         

        if (Auth::user()) {

            // Prendi il carrello dove 'user_id' ha l'id dell utente autenticato

            // Prendo il carrello dell' utente autenticato 
            $idCarrelloUtente = OrdineTestata::where('user_id', Auth::user()->id)->value('id');

            // Se esiste 
            if ($idCarrelloUtente) {

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
                    } else {

                        // creo una variabile dove inserisco la quantita del ricambio con  chiave i 
                        $incrementoQuantita = OrdineRiga::where('ordine_testata_id', $idCarrelloUtente)->where('ricambio_id', $ArrayRicambiUtente[$i])->value('quantità');

                        // Incremento la quantita dei ricambi uguali 
                        OrdineRiga::where('ordine_testata_id',  $idCarrelloUtente)->where('ricambio_id', $ArrayRicambiUtente[$i])->increment('quantità', $incrementoQuantita);

                        // Elimino uno dei due ricambi con indice uguale 
                        OrdineRiga::where('ordine_testata_id',  $idCarrelloUtente)->where('ricambio_id', $ArrayRicambiUtente[$i])->limit(1)->delete();
                    }
                }
            }
        }
        return $next($request);
    }
}



// 1 - Creo un array vuoto
// 2 - Ciclo l'array con gli id dei ricambi
// 3 - Controllo se nell' array vuoto si trova l'id del ricambio
// 4 - se non lo trova lo aggiunge, se lo trova somma la quantita

























   /**
             * SE LO STESSO CARRELLO HA COPIE DI RICAMBI DEVONO ESSERE ELIMINATE TUTTE LE COPIE E SOMMARE UN UNICA
             * QUANTITA' TOTALE
            */

            // // Creo un array dove inserire tutti i ricambi univoci
            // $arrRicambiUniovoci = [];

            // // Prendo tutte le righe del carrello
            // $Carrello = OrdineTestata::where('user_id', Auth::user()->id)->value('id');

            // $righeCarrello = OrdineRiga::where('ordine_testata_id',  $Carrello)->get();


            // // Per tutte le righe del carrello
            // foreach ($righeCarrello as $key => $rigaCarrello) {

            //     // Se l'id del ricambio non esiste nell' array $arrRicambiUniovoci
            //     if (!array_key_exists($righeCarrello[$key]->ricambio_id, $arrRicambiUniovoci)) {
            //         $arrRicambiUniovoci[$righeCarrello[$key]->ricambio_id] = $righeCarrello[$key]->quantità;

            //     } else {
            //         $arrRicambiUniovoci[$righeCarrello[$key]->ricambio_id] += $righeCarrello[$key]->quantità;

            //     }
                
            //     // Elimino tutte le righe del carrello
            //     // OrdineRiga::where('ordine_testata_id',  $Carrello)->delete();

            //     // Le rimetto da quelle dell array
            //     // OrdineRiga::create([
            //     //     'ordine_testata_id' =>  $Carrello,
            //     //     'ricambio_id' => $arrRicambiUniovoci[$righeCarrello[$key]->ricambio_id],
            //     //     'quantità' => $arrRicambiUniovoci[$righeCarrello[$key]->ricambio_id] += $righeCarrello[$key]->quantità,
            //     // ]);

            // }   