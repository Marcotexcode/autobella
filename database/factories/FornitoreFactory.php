<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FornitoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ragione_sociale' => 'Jessica Archer',
            'indirizzo' => 'Jessica Archer',
            'comune' => 'Jessica Archer',
            'cap' => '64025',
            'provincia' => 'Jessica Archer',
            'p_iva' => '3447',
        ];
    }
}
