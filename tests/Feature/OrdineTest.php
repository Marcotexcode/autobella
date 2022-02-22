<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Factories\HasFactory;


use App\Mail\OrdineSpedito;
use Illuminate\Support\Facades\Mail;

use App\Models\OrdineRiga;
use App\Models\Ricambio;
use App\Models\Categoria;
use App\Models\Fornitore;
use App\Models\User;
use App\Models\OrdineTestata;


class OrdineTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_da_ordine_a_spedito()
    {
        // Crere un utente 
        $user = User::factory()->create();
        
        // Creare un ordine 
        $ordine = OrdineTestata::factory([
            'user_id' => $user->id,
            'tipo' => 1
        ])->create();

        // Simulare una chiamata http di modifica tipo automatico 
        $response = $this->put(route('ordini.update', $ordine->id));

        // ************ PRIMO ASSERT **************
        // Testare che quando si fa lachiamata http update diventa di tipo 2 (spedito)
        $this->assertDatabaseHas('ordine_testate', [
            'id' => $ordine->id,
            'tipo' => 2
        ]);
    }

    public function test_email_ordine_spedito()
    {   
        Mail::fake();

        Mail::send(new OrdineSpedito); 

        Mail::assertSent(OrdineSpedito::class);
    }
}
