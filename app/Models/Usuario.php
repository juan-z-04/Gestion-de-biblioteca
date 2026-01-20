<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'usuarios';

    // Campos asignables masivamente
    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'fecha_registro',
        'estado',
    ];

    // Casts de tipos
    protected $casts = [
        'fecha_registro' => 'date',
    ];

    /**
     * Relación: un usuario tiene muchos préstamos
     */
    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }
}
