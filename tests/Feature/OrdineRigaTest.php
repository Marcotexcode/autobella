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
            ->count(1)
            ->for(Categoria::factory())
            ->for(Fornitore::factory())
            ->create();
        

        // Aggiungo un ordine al carrello
        $response = $this->post(route('ordine.store'), [
            'ricambio_id' =>  1,
            'quantità' =>  1,
        ]);

        // Controllo se l'ordine e stato aggiunto 
        $this->assertDatabaseHas('ordine_righe', [
            'ordine_testata_id' => 1,
            'ricambio_id' =>  1,
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
            ->count(1)
            ->for(Categoria::factory())
            ->for(Fornitore::factory([
                'p_iva' => '3417',
            ]))
            ->create();
        

        // Aggiungo un ordine al carrello
        $response = $this->actingAs($user)->post(route('ordine.store'), [
            'ricambio_id' =>  2,
            'quantità' =>  1,
        ]);

        // Controllo se l'ordine e stato aggiunto 
        $this->assertDatabaseHas('ordine_righe', [
            'ordine_testata_id' => 2,
            'ricambio_id' =>  2,
            'quantità' =>  1,
            'prezzo' =>  50,
        ]);
    }
}
