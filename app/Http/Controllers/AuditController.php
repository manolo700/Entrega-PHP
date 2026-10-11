<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    /**
     * Muestra la lista de auditorías.
     */
    public function index()
    {
        $audits = Audit::latest()->paginate(10);
        return view('audits.index', compact('audits'));
    }

    /**
     * Muestra el formulario para crear una nueva auditoría.
     */
    public function create()
    {
        return view('audits.create');
    }

    /**
     * Almacena una nueva auditoría en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:pendiente,en_proceso,completado',
        ], [
            'titulo.required' => 'El título de la auditoría es obligatorio.',
            'titulo.max' => 'El título no debe exceder los 255 caracteres.',
            'estado.required' => 'El estado de la auditoría es obligatorio.',
            'estado.in' => 'El estado seleccionado no es válido.',
        ]);

        Audit::create($validated);

        return redirect()->route('audits.index')
            ->with('success', 'Auditoría registrada exitosamente.');
    }

    /**
     * Muestra los detalles de una auditoría específica.
     */
    public function show(Audit $audit)
    {
        return view('audits.show', compact('audit'));
    }

    /**
     * Muestra el formulario para editar una auditoría existente.
     */
    public function edit(Audit $audit)
    {
        return view('audits.edit', compact('audit'));
    }

    /**
     * Actualiza una auditoría en la base de datos.
     */
    public function update(Request $request, Audit $audit)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:pendiente,en_proceso,completado',
        ], [
            'titulo.required' => 'El título de la auditoría es obligatorio.',
            'titulo.max' => 'El título no debe exceder los 255 caracteres.',
            'estado.required' => 'El estado de la auditoría es obligatorio.',
            'estado.in' => 'El estado seleccionado no es válido.',
        ]);

        $audit->update($validated);

        return redirect()->route('audits.index')
            ->with('success', 'Auditoría actualizada exitosamente.');
    }

    /**
     * Elimina una auditoría de la base de datos.
     */
    public function destroy(Audit $audit)
    {
        $audit->delete();

        return redirect()->route('audits.index')
            ->with('success', 'Auditoría eliminada exitosamente.');
    }
}
