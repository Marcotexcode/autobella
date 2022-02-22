@component('mail::message')
# <h1>Ciao!!</h1>

Il suo ordine è stato inviato, le invieremo una mail quando l'ordine verra spedito

{{-- TABELLA --}}
@foreach ($elencoArticoli as $elencoArticolo)

   Nome: {{$elencoArticolo->ricambio->codice}}
   <br>
   Prezzo: {{$elencoArticolo->ricambio->prezzo}}
   <br>
   Quantità: {{$elencoArticolo->quantità}}

@endforeach

Quantità totale: {{$totQuantità}}
<br>
Prezzo totale: {{$totPrezzo}} €



Thanks,<br>
Autobella
@endcomponent
