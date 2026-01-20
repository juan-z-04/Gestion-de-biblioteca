<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestamo;
use App\Models\Libro;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

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
    $validator = Validator::make($request->all(), [
        'usuario_id' => 'required|exists:usuarios,id',
        'libro_id' => 'required|exists:libros,id',
        'fecha_prestamo' => 'required|date',
        'fecha_devolucion' => 'required|date|after_or_equal:fecha_prestamo'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }

    $usuario = Usuario::findOrFail($request->usuario_id);
    $libro = Libro::findOrFail($request->libro_id);

    if ($libro->stock_disponible <= 0) {
        return response()->json(['error' => 'No hay stock disponible'], 400);
    }

    if ($usuario->prestamos()->where('estado', 'activo')->count() >= 3) {
        return response()->json(['error' => 'El usuario ya tiene 3 préstamos activos'], 400);
    }

    $prestamo = Prestamo::create([
        'usuario_id' => $request->usuario_id,
        'libro_id' => $request->libro_id,
        'fecha_prestamo' => $request->fecha_prestamo,
        'fecha_devolucion' => $request->fecha_devolucion,
        'fecha_devolucion_real' => null,
        'estado' => 'activo',
    ]);

    $libro->decrement('stock_disponible');

    return response()->json($prestamo->load(['usuario', 'libro']), 201);
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
