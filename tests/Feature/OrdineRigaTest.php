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
        
        // Aggiungo un ordine al carrello
        $response = $this->post(route('ordine.store'), [
            'ricambio_id' =>  $ricambio->id,
            'quantità' =>  1,
        ]);

        
        // Prendo l'id del carrello anonimo creato dall' ordine che ho inserito  
        $idCarrelloAnonimo = OrdineRiga::where('ricambio_id', $ricambio->id)->value('ordine_testata_id');


        // ************ PRIMO ASSERT **************
        // Controllo se in sessione c'è l'id del carrello creato dall' ordine che ho inserito 
        $response->assertSessionHas('idCarrello', $idCarrelloAnonimo);


        // ************ SECONDO ASSERT **************
        // Controllo se l'ordine ha creato un carrello (tipo = 0) anonimo (null)
        $this->assertDatabaseHas('ordine_testate', [
            'id' =>  $idCarrelloAnonimo,
            'user_id' =>  null,
            'tipo' =>  0,
        ]);

        
        // ************ SECONDO ASSERT **************
        // Controllo se l'ordine e stato aggiunto 
        $this->assertDatabaseHas('ordine_righe', [
            'ordine_testata_id' => $idCarrelloAnonimo,
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
      

        // Aggiungo un ordine al carrello
        $response = $this->actingAs($user)->post(route('ordine.store'), [
            'ricambio_id' =>  $ricambio->id,
            'quantità' =>  1,
        ]);

        // Prendo l'id del carrello autenticato dell'ordine che ho inserito  
        $idCarrelloAutenticato = OrdineRiga::where('ricambio_id', $ricambio->id)->value('ordine_testata_id');


        // ************ PRIMO ASSERT **************
        // Controllo se l'ordine ha creato un carrello (tipo = 0) autenticato (user->id)
        $this->assertDatabaseHas('ordine_testate', [
            'id' =>  $idCarrelloAutenticato,
            'user_id' =>  $user->id,
            'tipo' =>  0,
        ]);

        // ************ SECONDO ASSERT **************
        // Controllo se l'ordine e stato aggiunto 
        $this->assertDatabaseHas('ordine_righe', [
            'ordine_testata_id' => $idCarrelloAutenticato, 
            'ricambio_id' =>  $ricambio->id,
            'quantità' =>  1,
        ]);

    }
}
