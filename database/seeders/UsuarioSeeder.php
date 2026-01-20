<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Faker\Factory as Faker;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 15; $i++) {
            Usuario::create([
                'nombre' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'telefono' => $faker->phoneNumber,
                'fecha_registro' => $faker->date('Y-m-d'),
                'estado' => $faker->boolean,
            ]);
        }
    }
}
