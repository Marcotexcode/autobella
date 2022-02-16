<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\OrdineTestata;
use App\Models\OrdineRiga;
use App\Models\Ricambio;
use App\Models\Categoria;
use App\Models\Fornitore;




class OrdineRigaTest extends TestCase
{
    //use RefreshDatabase;

    public function test_aggiunta_ordine_al_carrello_anonimo()
    {
        // Creare un record ricambio per poter creare un record ordine
        $ricambio = Ricambio::factory()
            ->for(Categoria::factory())
            ->for(Fornitore::factory())
            ->create();
        

        // Creare un carrello anonimo 
        $carrelloAnonimo = OrdineTestata::factory()->create([
            'user_id' => null,
            'tipo' => 0 // Stato carrello
        ]);

        // Agiungo il carrello anonimo in sessione 
        session()->put('idCarrello', $carrelloAnonimo->id);

        // Carrello anonimo in sessione
        $carr = session('idCarrello');

        
        // Aggiungo un ordine al carrello
        $response = $this->post(route('ordine.store'), [
            'ordine_testata_id' => $carr,
            'ricambio_id' =>  $ricambio->id,
            'quantità' =>  1,
        ]);

        // ************ PRIMO ASSERT **************
        // Controllo se in sessione c'è il carrello anonimo 
        $response->assertSessionHas('idCarrello', $carrelloAnonimo->id);


        // ************ SECONDO ASSERT **************
        // Controllo se l'ordine e stato aggiunto 
        $this->assertDatabaseHas('ordine_righe', [
            'ordine_testata_id' => $carr,
            'ricambio_id' =>  $ricambio->id,
            'quantità' =>  1,
            'prezzo' =>  50,
        ]);
    }

    public function test_aggiunta_ordine_al_carrello_autenticato()
    {
        // Creo un utente 
        $user = User::factory()->create();

        // Creare un record ricambio per poter creare un record ordine
        $ricambio = Ricambio::factory()
            ->for(Categoria::factory())
            ->for(Fornitore::factory([
                'p_iva' => '3417',
            ]))
            ->create();
        
        // Creare un carrello Autenticato 
        $carrelloAutenticato = OrdineTestata::factory()->create([
            'user_id' => $user->id,
            'tipo' => 0 // Stato carrello
        ]);

        // Agiungo il carrello Autenticato in sessione 
        session()->put('idCarrello', $carrelloAutenticato->id);

        // Carrello Autenticato in sessione
        $carr = session('idCarrello');

        // Aggiungo un ordine al carrello
        $response = $this->post(route('ordine.store'), [
            'ordine_testata_id' => $carr,
            'ricambio_id' =>  $ricambio->id,
            'quantità' =>  1,
        ]);



        // ************ PRIMO ASSERT **************

        // Controllo se in sessione c'è il carrello Autenticato 
        $response->assertSessionHas('idCarrello', $carrelloAutenticato->id);


        // ************ SECONDO ASSERT **************
        
        // Controllo se l'ordine e stato aggiunto 
        $this->assertDatabaseHas('ordine_righe', [
            'ordine_testata_id' => $carr,
            'ricambio_id' =>  $ricambio->id,
            'quantità' =>  1,
        ]);
    }
}
