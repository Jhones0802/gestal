<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            EmpleadoSeeder::class,
            VacanteSeeder::class,
            CandidatoSeeder::class,
            ProcesoSeleccionSeeder::class,
        ]);
    }
}