<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    use HasFactory;

    // Nombre de la tabla (porque no es el plural en inglés)
    protected $table = 'autores';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'apellido',
        'fecha_nacimiento',
        'nacionalidad',
        'biografia',
    ];

    // Casts para tipos de datos
    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];
}
