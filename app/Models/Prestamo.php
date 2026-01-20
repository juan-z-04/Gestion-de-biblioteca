<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'prestamos';

    // Campos asignables masivamente
    protected $fillable = [
        'usuario_id',
        'libro_id',
        'fecha_prestamo',
        'fecha_devolucion_estimada',
        'fecha_devolucion_real',
        'estado',
    ];

    // Casts de tipos
    protected $casts = [
        'fecha_prestamo' => 'date',
        'fecha_devolucion_estimada' => 'date',
        'fecha_devolucion_real' => 'date',
    ];

    /**
     * Relación: un préstamo pertenece a un usuario
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    /**
     * Relación: un préstamo pertenece a un libro
     */
    public function libro()
    {
        return $this->belongsTo(Libro::class);
    }
}