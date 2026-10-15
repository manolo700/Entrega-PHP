<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // crea la tabla de tipos de auditoria
    public function up(): void
    {
        Schema::create('audit_types', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_norma'); // nombre de la norma ej ISO 9001
            $table->text('descripcion');    // que evalua la norma
            $table->timestamps();
        });
    }

    // elimina la tabla si se hace rollback
    public function down(): void
    {
        Schema::dropIfExists('audit_types');
    }
};
