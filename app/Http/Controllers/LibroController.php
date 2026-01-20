<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libro;
use App\Models\Autor;

class LibroController extends Controller
{
    public function index(Request $request)
    {
        $query = Libro::with('autores');

        // Filtros opcionales
        if ($request->has('titulo')) {
            $query->where('titulo', 'ILIKE', "%{$request->titulo}%");
        }

        if ($request->has('anio_publicacion')) {
            $query->where('anio_publicacion', $request->anio_publicacion);
        }

        if ($request->has('autor_id')) {
            $query->whereHas('autores', fn($q) => $q->where('id', $request->autor_id));
        }

        return response()->json($query->paginate(10));
    }

    public function show($id)
    {
        $libro = Libro::with('autores')->findOrFail($id);
        return response()->json($libro);
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string',
            'isbn' => 'required|string|unique:libros,isbn',
            'anio_publicacion' => 'nullable|integer',
            'numero_paginas' => 'nullable|integer',
            'descripcion' => 'nullable|string',
            'stock_disponible' => 'required|integer|min:0',
            'autores' => 'required|array|min:1',
            'autores.*' => 'exists:autores,id'
        ]);

        $libro = Libro::create($request->only(['titulo','isbn','anio_publicacion','numero_paginas','descripcion','stock_disponible']));
        $orden = 1;
        foreach ($request->autores as $autorId) {
            $libro->autores()->attach($autorId, ['orden_autor' => $orden]);
            $orden++;
        }

        return response()->json($libro->load('autores'), 201);
    }

    public function update(Request $request, $id)
    {
        $libro = Libro::findOrFail($id);

        $request->validate([
            'titulo' => 'sometimes|required|string',
            'isbn' => "sometimes|required|string|unique:libros,isbn,$id",
            'anio_publicacion' => 'nullable|integer',
            'numero_paginas' => 'nullable|integer',
            'descripcion' => 'nullable|string',
            'stock_disponible' => 'nullable|integer|min:0',
            'autores' => 'nullable|array|min:1',
            'autores.*' => 'exists:autores,id'
        ]);

        $libro->update($request->only(['titulo','isbn','anio_publicacion','numero_paginas','descripcion','stock_disponible']));

        if ($request->has('autores')) {
            $libro->autores()->sync($request->autores);
        }

        return response()->json($libro->load('autores'));
    }

    public function destroy($id)
    {
        $libro = Libro::findOrFail($id);
        $libro->delete(); // soft delete
        return response()->json(['message' => 'Libro eliminado']);
    }
}
