<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Muestra la lista de usuarios del sistema con filtrado y paginación.
     */
    public function index(Request $request)
    {
        Gate::authorize('users.view');

        $query = User::with('role')->latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($roleId = $request->input('role_id')) {
            $query->where('role_id', $roleId);
        }

        $users = $query->paginate(10)->withQueryString();
        $roles = Role::all();

        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        Gate::authorize('users.create');

        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Almacena un nuevo usuario en la base de datos con validaciones estrictas.
     */
    public function store(Request $request)
    {
        Gate::authorize('users.create');

        $validated = $request->validate([
            'name'     => ['required', 'string', 'min:3', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role_id'  => ['required', 'exists:roles,id'],
            'active'   => ['nullable', 'boolean'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required'      => 'El nombre completo es obligatorio.',
            'name.min'           => 'El nombre debe tener al menos :min caracteres.',
            'email.required'     => 'El correo electrónico es obligatorio.',
            'email.email'        => 'Ingresa un correo electrónico válido.',
            'email.unique'       => 'Este correo electrónico ya se encuentra registrado en el sistema.',
            'role_id.required'   => 'Debes asignar un rol al usuario.',
            'role_id.exists'     => 'El rol seleccionado no es válido.',
            'password.required'  => 'La contraseña es obligatoria.',
            'password.min'       => 'La contraseña debe tener un mínimo de :min caracteres para garantizar seguridad.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'role_id'  => $validated['role_id'],
            'active'   => $request->boolean('active', true),
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', "✅ Usuario '{$user->name}' registrado con éxito.");
    }

    /**
     * Muestra la información detallada del usuario y el desglose de sus permisos.
     */
    public function show(User $user)
    {
        Gate::authorize('users.view');

        $user->load('role.permissions');
        return view('users.show', compact('user'));
    }

    /**
     * Muestra el formulario para editar un usuario existente.
     */
    public function edit(User $user)
    {
        Gate::authorize('users.edit');

        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Actualiza la información del usuario en la base de datos.
     */
    public function update(Request $request, User $user)
    {
        Gate::authorize('users.edit');

        $validated = $request->validate([
            'name'     => ['required', 'string', 'min:3', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role_id'  => ['required', 'exists:roles,id'],
            'active'   => ['nullable', 'boolean'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required'      => 'El nombre completo es obligatorio.',
            'name.min'           => 'El nombre debe tener al menos :min caracteres.',
            'email.required'     => 'El correo electrónico es obligatorio.',
            'email.email'        => 'Ingresa un correo electrónico válido.',
            'email.unique'       => 'Este correo electrónico ya está en uso por otro usuario.',
            'role_id.required'   => 'Debes asignar un rol al usuario.',
            'role_id.exists'     => 'El rol seleccionado no es válido.',
            'password.min'       => 'La nueva contraseña debe tener al menos :min caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
        ]);

        // Prevención de bloqueo propio para el administrador en sesión
        if (Auth::id() === $user->id) {
            $adminRole = Role::where('name', 'admin')->first();
            if ($adminRole && (int) $validated['role_id'] !== $adminRole->id) {
                return back()
                    ->withInput()
                    ->with('error', 'Por seguridad, no puedes removerte a ti mismo el rol de Administrador.');
            }

            if (!$request->boolean('active', true)) {
                return back()
                    ->withInput()
                    ->with('error', 'Por seguridad, no puedes desactivar tu propia cuenta en sesión.');
            }
        }

        $data = [
            'name'    => $validated['name'],
            'email'   => $validated['email'],
            'role_id' => $validated['role_id'],
            'active'  => $request->boolean('active', true),
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()
            ->route('users.index')
            ->with('success', "✅ Usuario '{$user->name}' actualizado correctamente.");
    }

    /**
     * Elimina el usuario del sistema con validación de seguridad.
     */
    public function destroy(User $user)
    {
        Gate::authorize('users.delete');

        // Impedir que el usuario elimine su propia cuenta
        if (Auth::id() === $user->id) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Operación denegada: No puedes eliminar tu propia cuenta mientras estás en sesión.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('warning', "El usuario '{$name}' ha sido eliminado del sistema.");
    }
}

