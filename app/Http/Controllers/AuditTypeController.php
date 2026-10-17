<?php

namespace App\Http\Controllers;

use App\Models\AuditType;
use Illuminate\Http\Request;

class AuditTypeController extends Controller
{
    // muestra la lista de tipos de auditoria
    public function index()
    {
        $auditTypes = AuditType::paginate(10);
        return view('audit_types.index', compact('auditTypes'));
    }

    // formulario para crear un nuevo tipo
    public function create()
    {
        return view('audit_types.create');
    }

    // guarda el nuevo tipo en la base de datos
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_norma' => 'required|string|min:3|max:255',
            'descripcion'  => 'required|string|min:10|max:1000',
        ], [
            'nombre_norma.required' => 'El nombre de la norma es obligatorio',
            'nombre_norma.min'      => 'El nombre debe tener al menos :min caracteres',
            'nombre_norma.max'      => 'El nombre no debe superar los :max caracteres',
            'descripcion.required'  => 'La descripcion es obligatoria',
            'descripcion.min'       => 'La descripcion debe tener al menos :min caracteres',
            'descripcion.max'       => 'La descripcion no debe superar los :max caracteres',
        ]);

        AuditType::create($validated);

        return redirect()
            ->route('audit-types.index')
            ->with('success', 'Tipo de auditoria "' . $validated['nombre_norma'] . '" creado con exito');
    }

    // muestra los detalles de un tipo
    public function show(AuditType $auditType)
    {
        return view('audit_types.show', compact('auditType'));
    }

    // formulario para editar
    public function edit(AuditType $auditType)
    {
        return view('audit_types.edit', compact('auditType'));
    }

    // actualiza los datos en la base de datos
    public function update(Request $request, AuditType $auditType)
    {
        $validated = $request->validate([
            'nombre_norma' => 'required|string|min:3|max:255',
            'descripcion'  => 'required|string|min:10|max:1000',
        ], [
            'nombre_norma.required' => 'El nombre de la norma es obligatorio',
            'nombre_norma.min'      => 'El nombre debe tener al menos :min caracteres',
            'nombre_norma.max'      => 'El nombre no debe superar los :max caracteres',
            'descripcion.required'  => 'La descripcion es obligatoria',
            'descripcion.min'       => 'La descripcion debe tener al menos :min caracteres',
            'descripcion.max'       => 'La descripcion no debe superar los :max caracteres',
        ]);

        $auditType->update($validated);

        return redirect()
            ->route('audit-types.index')
            ->with('success', 'Tipo de auditoria "' . $validated['nombre_norma'] . '" actualizado con exito');
    }

    // elimina el registro
    public function destroy(AuditType $auditType)
    {
        $name = $auditType->nombre_norma;
        $auditType->delete();

        return redirect()
            ->route('audit-types.index')
            ->with('warning', 'El tipo de auditoria "' . $name . '" fue eliminado');
    }
}
