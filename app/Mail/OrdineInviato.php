<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\OrdineTestata;
use App\Models\OrdineRiga;
use Illuminate\Support\Facades\Auth;


class OrdineInviato extends Mailable
{
    use Queueable, SerializesModels;

    public $elencoArticoli;
    public $totPrezzo;
    public $totQuantità;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($idCarrello)
    {
        // Prende tutti gli articoli del carrello
        $this->elencoArticoli = OrdineRiga::where('ordine_testata_id', $idCarrello)->get();

        // Prendere la quantità di ogni riga e le metto in un array
        $quantitaRiga =  OrdineRiga::where('ordine_testata_id',  $idCarrello)->pluck('quantità')->toArray();

        // Prendere il prezzo di ogni riga e li metto in un array
        $prezzoRicambio = OrdineRiga::where('ordine_testata_id',  $idCarrello)->pluck('prezzo')->toArray();
        
        $totalePrezzoPerQuantità = [];
        
        for ($i=0; $i < count($prezzoRicambio); $i++) { 
            // Moltiplico gli elementi e il risultato l'ho aggiungo in un altro array
            array_push($totalePrezzoPerQuantità, $prezzoRicambio[$i] * $quantitaRiga[$i]);
        }

        $this->totPrezzo = array_sum($totalePrezzoPerQuantità);

        $this->totQuantità = array_sum($quantitaRiga);
    }   

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.ordine.inviato');
    }
}
