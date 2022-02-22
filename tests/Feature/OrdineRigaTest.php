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
    use RefreshDatabase;

    public function test_aggiunta_ordine_al_carrello_anonimo()
    {
        // Creare un record ricambio per poter creare un record ordine
        $ricambio = Ricambio::factory()
            ->for(Categoria::factory())
            ->for(Fornitore::factory())
            ->create();
        
        // Controllo che nel db non ci sono carrelli *********
        $this->assertDatabaseCount('ordine_testate', 0);

        // Aggiungo un ordine al carrello
        $response = $this->post(route('ordine.store'), [
            'ricambio_id' =>  $ricambio->id,
            'quantità' =>  1,
        ]);

        // Prendo l'id del carrello che ha tipo 0 (carrello) ********
        $idCarrello = OrdineTestata::where('tipo', 0)->value('id');


        // ************ PRIMO ASSERT **************
        // Controllo se in sessione c'è l'id del carrello creato dall' ordine che ho inserito 
        $response->assertSessionHas('idCarrello', $idCarrello);


        // ************ TERZO ASSERT **************
        // Controllo se l'ordine e stato aggiunto 
        $this->assertDatabaseHas('ordine_righe', [
            'ordine_testata_id' => $idCarrello,
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
      
        // Controllo che nel db non ci sono carrelli ********
        $this->assertDatabaseCount('ordine_testate', 0);

        // Aggiungo un ordine al carrello
        $response = $this->actingAs($user)->post(route('ordine.store'), [
            'ricambio_id' =>  $ricambio->id,
            'quantità' =>  1,
        ]);

        // Prendo l'id del carrello che ha tipo 0 (carrello) ********
        $idCarrello = OrdineTestata::where('tipo', 0)->value('id');

        // Controllare se la sessione e vuota
        $response->assertSessionMissing('idCarrello');


        // ************ SECONDO ASSERT **************
        // Controllo se l'ordine e stato aggiunto 
        $this->assertDatabaseHas('ordine_righe', [
            'ordine_testata_id' => $idCarrello, 
            'ricambio_id' =>  $ricambio->id,
            'quantità' =>  1,
        ]);

    }
    
}































// public function test_creazione_carrello_anonimo()
//     {
//         $ricambio = Ricambio::factory()
//             ->for(Categoria::factory())
//             ->for(Fornitore::factory([
//                 'p_iva' => '3417',
//             ]))
//             ->create();

//         // Aggiungo un ordine al carrello
//         $response = $this->post(route('ordine.store'), [
//             'ricambio_id' =>  $ricambio->id,
//             'quantità' =>  1,
//         ]);

//         // Prendo l'id del carrello che ha tipo 0 (carrello) ********
//         $idCarrello = OrdineTestata::where('tipo', 0)->value('id');

//         $response->assertSessionHas('idCarrello', $idCarrello);
//         // Controllare se la sessione e vuota
//     }