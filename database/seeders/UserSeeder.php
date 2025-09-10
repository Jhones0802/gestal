<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Crear usuario administrador
        User::create([
            'name' => 'Administrador Sistema',
            'email' => 'admin@localizamos.co',
            'cedula' => '12345678',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'cargo' => 'Gerente General',
            'estado' => 'activo'
        ]);

        // Crear analista de RRHH
        User::create([
            'name' => 'Angie Viviana Villa Olarte',
            'email' => 'rrhh@localizamos.co',
            'cedula' => '87654321',
            'password' => Hash::make('rrhh123'),
            'role' => 'analista_rh',
            'cargo' => 'Analista de Recursos Humanos',
            'estado' => 'activo'
        ]);
    }
}