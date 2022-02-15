<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class OrdineRiga extends Model
{
    use HasFactory;

    protected $table = 'ordine_righe';

    protected $fillable = [
        'ordine_testata_id',
        'ricambio_id',
        'quantità',
        'prezzo',
    ];

    public function ricambio()
    {
        return $this->belongsTo(Ricambio::class);
    }

    public function ordine_testata()
    {
        return $this->belongsTo(OrdineTestata::class);
    }

    // Righe carrello anonimo o autenticato
    public static function righeAnonimoAutenticato()
    {
        $righeCarrello = [];
        
        if (session('idCarrello')) {

            $righeCarrello = OrdineRiga::where('ordine_testata_id', session('idCarrello'))->get();
            
            
        } elseif(Auth::user()) {

            $idCarrello = OrdineTestata::where('user_id', Auth::user()->id)->where('tipo', 0)->value('id');

            $righeCarrello = OrdineRiga::where('ordine_testata_id', $idCarrello)->get();
        }

        return $righeCarrello;
    }

    // Somma totale di ogni riga 
    public static function totaleRiga()
    {
        $idCarrello = null;

        if (session('idCarrello')) {

            $idCarrello = OrdineTestata::carrelloAnonimo()->value('id');

        } elseif(Auth::user()) {

            $idCarrello = OrdineTestata::carrelloUtente()->value('id');

        }

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

        return $totalePrezzoPerQuantità;
    }
  
}
