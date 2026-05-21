<?php

namespace Database\Seeders;

use App\Models\Chambre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChambreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Chambre::create([
            'numero' => '101',
            'type' => 'Simple',
            'prix' => 500,
            'disponible' => true
        ]);

        Chambre::create([
            'numero' => '102',
            'type' => 'Double',
            'prix' => 800,
            'disponible' => false
        ]);
        Chambre::factory()->count(3)->create();
    }
}
