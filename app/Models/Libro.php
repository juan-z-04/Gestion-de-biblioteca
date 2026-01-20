<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Libro extends Model
{
    use HasFactory, SoftDeletes;

    // Nombre de la tabla
    protected $table = 'libros';

    // Campos asignables masivamente
    protected $fillable = [
        'titulo',
        'isbn',
        'anio_publicacion',
        'numero_paginas',
        'descripcion',
        'stock_disponible',
    ];

    // Casts
    protected $casts = [
        'anio_publicacion' => 'integer',
        'numero_paginas' => 'integer',
        'stock_disponible' => 'integer',
    ];

    /**
     * Relación muchos a muchos con autores
     */
    public function autores()
    {
        return $this->belongsToMany(Autor::class, 'autor_libro')
                    ->withPivot('orden_autor')
                    ->withTimestamps();
    }
}