<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@evento.com',
            'password' => Hash::make('admin123'),
            'rol' => 'admin',
        ]);

        // Registros
        User::create([
            'name' => 'Usuario Registros',
            'email' => 'registros@example.com',
            'password' => Hash::make('registros123'),
            'rol' => 'registros',
        ]);

        // Ingresos
        User::create([
            'name' => 'Usuario Ingresos',
            'email' => 'ingresos@example.com',
            'password' => Hash::make('ingresos123'),
            'rol' => 'ingresos',
        ]);
    }
}

                
      