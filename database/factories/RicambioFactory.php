<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RicambioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'descrizione' => 'sdjhsadfjhsdfòjh',
            'prezzo' => 50.00,
            'codice' => 'pnealjkfadf',
        ];
    }
}
