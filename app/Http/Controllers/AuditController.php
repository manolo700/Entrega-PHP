<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AuditController extends Controller
{
    /**
     * Muestra la lista paginada de auditorías.
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
     * Almacena una nueva auditoría en la base de datos con validación robusta.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'titulo'      => 'required|string|min:5|max:255',
                'descripcion' => 'nullable|string|min:10|max:2000',
                'estado'      => ['required', Rule::in(['pendiente', 'en_proceso', 'completado'])],
            ],
            [
                // Mensajes personalizados — campo "titulo"
                'titulo.required' => 'El título de la auditoría es obligatorio.',
                'titulo.min'      => 'El título debe tener al menos :min caracteres.',
                'titulo.max'      => 'El título no debe exceder los :max caracteres.',

                // Mensajes personalizados — campo "descripcion"
                'descripcion.min' => 'La descripción debe tener al menos :min caracteres si se proporciona.',
                'descripcion.max' => 'La descripción no debe exceder los :max caracteres.',

                // Mensajes personalizados — campo "estado"
                'estado.required' => 'Debe seleccionar un estado para la auditoría.',
                'estado.in'       => 'El estado seleccionado no es válido. Opciones: Pendiente, En Proceso, Completado.',
            ]
        );

        Audit::create($validated);

        return redirect()
            ->route('audits.index')
            ->with('success', '✅ Auditoría "' . $validated['titulo'] . '" registrada exitosamente.');
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
     * Actualiza una auditoría en la base de datos con validación robusta.
     */
    public function update(Request $request, Audit $audit)
    {
        $validated = $request->validate(
            [
                'titulo'      => 'required|string|min:5|max:255',
                'descripcion' => 'nullable|string|min:10|max:2000',
                'estado'      => ['required', Rule::in(['pendiente', 'en_proceso', 'completado'])],
            ],
            [
                // Mensajes personalizados — campo "titulo"
                'titulo.required' => 'El título de la auditoría es obligatorio.',
                'titulo.min'      => 'El título debe tener al menos :min caracteres.',
                'titulo.max'      => 'El título no debe exceder los :max caracteres.',

                // Mensajes personalizados — campo "descripcion"
                'descripcion.min' => 'La descripción debe tener al menos :min caracteres si se proporciona.',
                'descripcion.max' => 'La descripción no debe exceder los :max caracteres.',

                // Mensajes personalizados — campo "estado"
                'estado.required' => 'Debe seleccionar un estado para la auditoría.',
                'estado.in'       => 'El estado seleccionado no es válido. Opciones: Pendiente, En Proceso, Completado.',
            ]
        );

        $audit->update($validated);

        return redirect()
            ->route('audits.index')
            ->with('success', '✏️ Auditoría "' . $validated['titulo'] . '" actualizada exitosamente.');
    }

    /**
     * Elimina una auditoría de la base de datos.
     */
    public function destroy(Audit $audit)
    {
        $titulo = $audit->titulo;
        $audit->delete();

        return redirect()
            ->route('audits.index')
            ->with('warning', '🗑️ La auditoría "' . $titulo . '" fue eliminada permanentemente.');
    }
}
