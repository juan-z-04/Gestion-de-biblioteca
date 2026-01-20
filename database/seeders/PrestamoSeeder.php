<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prestamo;
use App\Models\Usuario;
use App\Models\Libro;
use Faker\Factory as Faker;

class PrestamoSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $usuarios = Usuario::all();
        $libros = Libro::all();

        for ($i = 1; $i <= 10; $i++) {
            $usuario = $usuarios->random();
            $libro = $libros->where('stock_disponible', '>', 0)->random(); // solo libros con stock

            Prestamo::create([
                'usuario_id' => $usuario->id,
                'libro_id' => $libro->id,
                'fecha_prestamo' => $faker->dateTimeBetween('-1 month', 'now'),
                'fecha_devolucion' => $faker->dateTimeBetween('now', '+15 days'),
                'estado' => 'activo',
            ]);

            // Disminuir stock del libro
            $libro->decrement('stock_disponible');
        }
    }
}
