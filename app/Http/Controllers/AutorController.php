<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Autor;

class AutorController extends Controller
{
    public function index()
    {
        return response()->json(Autor::all());
    }

    public function show($id)
    {
        return response()->json(Autor::with('libros')->findOrFail($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'fecha_nacimiento' => 'nullable|date',
            'nacionalidad' => 'nullable|string',
            'biografia' => 'nullable|string'
        ]);

        $autor = Autor::create($request->all());
        return response()->json($autor, 201);
    }

    public function update(Request $request, $id)
    {
        $autor = Autor::findOrFail($id);
        $autor->update($request->all());
        return response()->json($autor);
    }

    public function destroy($id)
    {
        $autor = Autor::findOrFail($id);

        if ($autor->libros()->exists()) {
            return response()->json(['error' => 'No se puede eliminar un autor con libros asociados'], 400);
        }

        $autor->delete();
        return response()->json(['message' => 'Autor eliminado']);
    }
}
