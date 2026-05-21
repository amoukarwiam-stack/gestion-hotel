<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $adminRole = Role::where('libelle', 'Admin')->firstOrFail();
$userRole = Role::where('libelle', 'User')->firstOrFail();

User::create([
    'name' => 'Admin',
    'email' => 'admin@gmail.com',
    'password' => Hash::make('12345678'),
    'role_id' => $adminRole->id
]);

        // User
        User::create([
            'name' => 'Client Test',
            'email' => 'client@gmail.com',
            'password' => Hash::make('12345678'),
            'role_id' => $userRole->id
        ]);
    }
}
