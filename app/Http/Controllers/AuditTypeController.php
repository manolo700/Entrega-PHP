<?php

namespace App\Http\Controllers;

use App\Models\AuditType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AuditTypeController extends Controller
{
    /**
     * Muestra la lista de tipos de auditoría.
     */
    public function index()
    {
        Gate::authorize('audit_types.view');

        $auditTypes = AuditType::paginate(10);
        return view('audit_types.index', compact('auditTypes'));
    }

    /**
     * Muestra el formulario para crear un nuevo tipo.
     */
    public function create()
    {
        Gate::authorize('audit_types.create');

        return view('audit_types.create');
    }

    /**
     * Guarda el nuevo tipo en la base de datos con validaciones completas.
     */
    public function store(Request $request)
    {
        Gate::authorize('audit_types.create');

        $validated = $request->validate([
            'nombre_norma' => 'required|string|min:3|max:255',
            'descripcion'  => 'required|string|min:10|max:1000',
        ], [
            'nombre_norma.required' => 'El nombre de la norma es obligatorio',
            'nombre_norma.min'      => 'El nombre debe tener al menos :min caracteres',
            'nombre_norma.max'      => 'El nombre no debe superar los :max caracteres',
            'descripcion.required'  => 'La descripción es obligatoria',
            'descripcion.min'       => 'La descripción debe tener al menos :min caracteres',
            'descripcion.max'       => 'La descripción no debe superar los :max caracteres',
        ]);

        AuditType::create($validated);

        return redirect()
            ->route('audit-types.index')
            ->with('success', 'Tipo de auditoría "' . $validated['nombre_norma'] . '" creado con éxito');
    }

    /**
     * Muestra los detalles de un tipo específico.
     */
    public function show(AuditType $auditType)
    {
        Gate::authorize('audit_types.view');

        return view('audit_types.show', compact('auditType'));
    }

    /**
     * Muestra el formulario para editar.
     */
    public function edit(AuditType $auditType)
    {
        Gate::authorize('audit_types.edit');

        return view('audit_types.edit', compact('auditType'));
    }

    /**
     * Actualiza los datos en la base de datos.
     */
    public function update(Request $request, AuditType $auditType)
    {
        Gate::authorize('audit_types.edit');

        $validated = $request->validate([
            'nombre_norma' => 'required|string|min:3|max:255',
            'descripcion'  => 'required|string|min:10|max:1000',
        ], [
            'nombre_norma.required' => 'El nombre de la norma es obligatorio',
            'nombre_norma.min'      => 'El nombre debe tener al menos :min caracteres',
            'nombre_norma.max'      => 'El nombre no debe superar los :max caracteres',
            'descripcion.required'  => 'La descripción es obligatoria',
            'descripcion.min'       => 'La descripción debe tener al menos :min caracteres',
            'descripcion.max'       => 'La descripción no debe superar los :max caracteres',
        ]);

        $auditType->update($validated);

        return redirect()
            ->route('audit-types.index')
            ->with('success', 'Tipo de auditoría "' . $validated['nombre_norma'] . '" actualizado con éxito');
    }

    /**
     * Elimina el registro.
     */
    public function destroy(AuditType $auditType)
    {
        Gate::authorize('audit_types.delete');

        $name = $auditType->nombre_norma;
        $auditType->delete();

        return redirect()
            ->route('audit-types.index')
            ->with('warning', 'El tipo de auditoría "' . $name . '" fue eliminado');
    }
}
