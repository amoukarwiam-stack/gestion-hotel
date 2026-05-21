<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chambre>
 */
class ChambreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
             'numero' => $this->faker->unique()->numberBetween(200, 300),
            'type' => $this->faker->randomElement(['Simple', 'Double', 'Suite']),
            'prix' => $this->faker->numberBetween(400, 1200),
            'disponible' =>true
        ];
    }
}
