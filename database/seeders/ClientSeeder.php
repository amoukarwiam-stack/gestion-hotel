<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $user = User::where('role_id', 2)->first(); // user role

    if ($user) {
        $user->client()->create([
            'nom' => 'Test',
            'prenom' => 'Client',
            'email' => $user->email,
            'telephone' => '0600000000',
        ]);
}}
}