<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Autor;
use Faker\Factory as Faker;

class AutorSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 10; $i++) {
            Autor::create([
                'nombre' => $faker->firstName,
                'apellido' => $faker->lastName,
                'fecha_nacimiento' => $faker->date('Y-m-d', '1990-01-01'),
                'nacionalidad' => $faker->country,
                'biografia' => $faker->paragraph,
            ]);
        }
    }
}
