<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Libro;
use App\Models\Autor;   
use Faker\Factory as Faker;

class LibroSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $autorIds = Autor::pluck('id')->toArray(); // IDs de los autores

        for ($i = 1; $i <= 20; $i++) {
            $libro = Libro::create([
                'titulo' => $faker->sentence(3),
                'isbn' => $faker->unique()->isbn13,
                'anio_publicacion' => $faker->year,
                'numero_paginas' => $faker->numberBetween(100, 800),
                'descripcion' => $faker->paragraph,
                'stock_disponible' => $faker->numberBetween(0, 10),
            ]);

            // Asignar entre 1 y 3 autores al libro
            $autoresSeleccionados = $faker->randomElements($autorIds, rand(1, 3));
            $orden = 1;
            foreach ($autoresSeleccionados as $autorId) {
                $libro->autores()->attach($autorId, ['orden_autor' => $orden]);
                $orden++;
            }
        }
    }
}
