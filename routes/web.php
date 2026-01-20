<?php

use App\Http\Controllers\AutorController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::prefix('/api')->group(function () {
    // Libros
Route::get('/libros', [LibroController::class, 'index']);
Route::get('/libros/{id}', [LibroController::class, 'show']);
Route::post('/libros', [LibroController::class, 'store']);
Route::put('/libros/{id}', [LibroController::class, 'update']);
Route::delete('/libros/{id}', [LibroController::class, 'destroy']);

// Autores
Route::get('/autores', [AutorController::class, 'index']);
Route::get('/autores/{id}', [AutorController::class, 'show']);
Route::post('/autores', [AutorController::class, 'store']);
Route::put('/autores/{id}', [AutorController::class, 'update']);
Route::delete('/autores/{id}', [AutorController::class, 'destroy']);

// Usuarios
Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::get('/usuarios/{id}', [UsuarioController::class, 'show']);
Route::post('/usuarios', [UsuarioController::class, 'store']);
Route::put('/usuarios/{id}', [UsuarioController::class, 'update']);
Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']);

// Préstamos
Route::get('/prestamos', [PrestamoController::class, 'index']);
Route::get('/prestamos/{id}', [PrestamoController::class, 'show']);
Route::post('/prestamos', [PrestamoController::class, 'store']);
Route::put('/prestamos/{id}/devolver', [PrestamoController::class, 'devolver']);

});