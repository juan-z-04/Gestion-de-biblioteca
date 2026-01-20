<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestamo;
use App\Models\Libro;
use App\Models\Usuario;
use Carbon\Carbon;

class PrestamoController extends Controller
{
    public function index()
    {
        return response()->json(Prestamo::with(['usuario','libro'])->get());
    }

    public function show($id)
    {
        return response()->json(Prestamo::with(['usuario','libro'])->findOrFail($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'libro_id' => 'required|exists:libros,id',
            'fecha_prestamo' => 'required|date',
            'fecha_devolucion_estimada' => 'required|date|after_or_equal:fecha_prestamo'
        ]);

        $usuario = Usuario::findOrFail($request->usuario_id);
        $libro = Libro::findOrFail($request->libro_id);

        // Reglas de negocio
        if ($libro->stock_disponible <= 0) {
            return response()->json(['error'=>'No hay stock disponible del libro'], 400);
        }

        if ($usuario->prestamos()->where('estado','activo')->count() >= 3) {
            return response()->json(['error'=>'El usuario ya tiene 3 préstamos activos'], 400);
        }

        // Crear préstamo
        $prestamo = Prestamo::create($request->all());
    
        // Disminuir stock
        $libro->decrement('stock_disponible');

        return response()->json($prestamo->load(['usuario','libro']), 201);
    }

    public function devolver($id)
    {
        $prestamo = Prestamo::findOrFail($id);

        if ($prestamo->estado == 'devuelto') {
            return response()->json(['error'=>'El préstamo ya fue devuelto'], 400);
        }

        $prestamo->estado = 'devuelto';
        $prestamo->fecha_devolucion_real = Carbon::now();
        $prestamo->save();

        // Aumentar stock
        $prestamo->libro->increment('stock_disponible');

        return response()->json($prestamo->load(['usuario','libro']));
    }
}
