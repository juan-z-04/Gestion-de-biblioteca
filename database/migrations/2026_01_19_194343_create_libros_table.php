<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('libros', function (Blueprint $table) {
        $table->id();
        $table->string('titulo');
        $table->string('isbn')->unique();
        $table->integer('anio_publicacion')->nullable();
        $table->integer('numero_paginas')->nullable();
        $table->text('descripcion')->nullable();
        $table->integer('stock_disponible')->default(0);
        $table->softDeletes(); // deleted_at
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libros');
    }
};
