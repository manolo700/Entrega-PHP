<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones para crear la tabla 'audits'.
     */
    public function up(): void
    {
        Schema::create('audits', function (Blueprint $table) {
            $table->id();                                    // Clave primaria autoincremental
            $table->string('titulo');                        // Título de la auditoría
            $table->text('descripcion')->nullable();          // Descripción detallada (opcional)
            $table->string('estado')->default('pendiente');  // Estado: pendiente, en_proceso, completado
            $table->timestamps();                            // created_at y updated_at
        });
    }

    /**
     * Revierte las migraciones eliminando la tabla 'audits'.
     */
    public function down(): void
    {
        Schema::dropIfExists('audits');
    }
};
