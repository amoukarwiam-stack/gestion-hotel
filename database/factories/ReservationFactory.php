<?php

namespace Database\Factories;

use App\Models\Chambre;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'date_debut' => $this->faker->dateTimeBetween('+1 days', '+1 month'),
            'date_fin' => $this->faker->dateTimeBetween('+1 month', '+2 months'),
            'etat' => 'confirmée',
            'id_client' => Client::inRandomOrder()->first()->id_client,
            'id_chambre' => Chambre::inRandomOrder()->first()->id_chambre
        ];
    }
}
