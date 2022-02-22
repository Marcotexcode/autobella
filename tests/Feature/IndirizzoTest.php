<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrdineInviato;
use Illuminate\Support\Facades\Auth;
use App\Mail\JustTesting;

use App\Models\OrdineRiga;
use App\Models\Ricambio;
use App\Models\Categoria;
use App\Models\Fornitore;
use App\Models\User;
use App\Models\OrdineTestata;

class IndirizzoTest extends TestCase
{
    use RefreshDatabase;

    public function test_da_carrello_a_ordine()
    {
        // Crere un utente 
        $user = User::factory()->create();
        
        // Creare un ordine 
        $ordine = OrdineTestata::factory([
            'user_id' => $user->id,
            'tipo' => 0
        ])->create();

        // Simulare una chiamata http di modifica con utente autenticato
        $response = $this->actingAs($user)->post(route('indirizzo.store'), [
            'indirizzo' => 'nazionale',
            'telefono' => '32455654',
        ]);

        // ************ PRIMO ASSERT **************
        // Testare che quando si fa la chiamata http update l'ordine da tipo 0 (carrello) diventa di tipo 1 (ordine)
        $this->assertDatabaseHas('ordine_testate', [
            'indirizzo' => 'nazionale',
            'telefono' => '32455654',
            'id' => $ordine->id,
            'tipo' => 1
        ]);
    }



}
































// // Creare tre ordini
// $carrello = OrdineTestata::factory([
//     'user_id' => $user->id,
//     'tipo' => 1
// ])->count(3)->create();

// // Conto se ha creato 3 ordini
// $this->assertDatabaseCount('ordine_testate', 3);