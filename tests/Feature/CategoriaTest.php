<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Categoria;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class CategoriaTest extends TestCase
{
    use RefreshDatabase;

    public function test_aggiungere_categoria()
    {
        //$this->withoutExceptionHandling();

        // Creo utente amministratore con factory
        $user = User::factory()->create(['livello_accesso' => '1']);

        // Aggiungo un record 
        $response = $this->actingAs($user)->post(route('categorie.store'), [
            'descrizione' => 'pippo',
        ]);

        $this->assertDatabaseHas('categorie', [
            'descrizione' => 'pippo',
        ]);

        //Controlla se viene ridirezionato in: 
        $response->assertRedirect(route('categorie.index'));
    }



    public function test_descrizione_aggiunta_è_required()
    {
        $user = User::factory()->create(['livello_accesso' => '1']);

        $response = $this->actingAs($user)->post(route('categorie.store'), [
            'descrizione' => '',
        ]);

        //Mi deve dire required
        $response->assertSessionHasErrors('descrizione');
    }



    public function test_modifica_categoria()
    {
        $user = User::factory()->create(['livello_accesso' => '1']);

        $categoria = Categoria::factory()->create();

        //Creo Record e Cambio il record
        $response = $this->actingAs($user)->put(route('categorie.update', $categoria->id), [
            'descrizione' => 'contenuto',
        ]);

        //Controllo se modificato
        $this->assertDatabaseHas('categorie', [
            'descrizione' => 'contenuto',
        ]);    

        //Controlla se viene ridirezionato in: 
        $response->assertRedirect(route('categorie.index'));
    }



    public function test_descrizione_modifica_è_required()
    {
        $user = User::factory()->create(['livello_accesso' => '1']);

        $categoria = Categoria::factory()->create();

        $response = $this->actingAs($user)->put(route('categorie.update', $categoria->id), [
            'descrizione' => '',
        ]);

        //Mi deve dire required
        $response->assertSessionHasErrors('descrizione');
    }



    public function test_elimina_categoria()
    {
        $user = User::factory()->create(['livello_accesso' => '1']);

        $categoria = Categoria::factory()->create();

        //Creo Record ed Elimino il record
        $response = $this->actingAs($user)->delete(route('categorie.destroy', $categoria->id));

        //Controllo se la tabella ha 0 record
       // $this->assertCount(0, Categoria::all());

        //Controlla se viene ridirezionato in: 
        $response->assertRedirect(route('categorie.index'));
    }


    // ********************************                        **************************************
    // ********************************                        **************************************
    // ******************************** UTENTE NON AUTORIZZATO **************************************
    // ********************************                        **************************************
    // ********************************                        **************************************


    public function test_utente_non_autorizzato_aggiunta_categoria()
    {
        // Creo utente non amministratore con factory
        $user = User::factory()->create(['livello_accesso' => '0']);

        //Aggiungo record 
        $response = $this->actingAs($user)->post(route('categorie.store'), [
            'descrizione' => 'descrizione',
        ]);
        
        //Codice 403 cioè non autorizzato 
        $response->assertStatus(403);
    }



    public function test_utente_non_autorizzato_modifica_categoria()
    {
        // Creo utente non amministratore con factory
        $user = User::factory()->create(['livello_accesso' => '0']);

        // Creo record con factory
        $categoria = Categoria::factory()->create();

        //Creo Record e Cambio il record
        $response = $this->actingAs($user)->put(route('categorie.update', $categoria->id), [
            'descrizione' => 'contenuto',
        ]);

        //Codice 403 cioè non autorizzato
        $response->assertStatus(403);
    }



    public function test_utente_non_autorizzato_elimina_categoria()
    {
        // Creo utente non amministratore con factory
        $user = User::factory()->create(['livello_accesso' => '0']);

        // Creo record con factory per categoria
        $categoria = Categoria::factory()->create();

        //Creo Record ed Elimino il record
        $response = $this->actingAs($user)->delete(route('categorie.destroy', $categoria->id));

        //Codice 403 cioè non autorizzato
        $response->assertStatus(403);
    }

}















