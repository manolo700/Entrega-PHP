<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Procesa la autenticación del usuario con control de intentos y regeneración de sesión.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required'    => 'El correo electrónico es obligatorio.',
            'email.email'       => 'Por favor ingresa un correo electrónico válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        $throttleKey = Str::transliterate(Str::lower($request->input('email')) . '|' . $request->ip());

        // Protección contra fuerza bruta (máximo 5 intentos por minuto)
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'email' => ["Demasiados intentos fallidos. Inténtalo de nuevo en {$seconds} segundos."],
            ]);
        }

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            // Verificar si el usuario se encuentra activo
            if (!Auth::user()->isActive()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()
                    ->withInput($request->only('email'))
                    ->with('error', 'Tu cuenta se encuentra inactiva. Contacta al administrador para habilitar tu acceso.');
            }

            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            return redirect()
                ->intended(route('dashboard'))
                ->with('success', '¡Bienvenido(a) ' . Auth::user()->name . '! Has iniciado sesión exitosamente.');
        }

        RateLimiter::hit($throttleKey, 60);

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
            ]);
    }

    /**
     * Cierra la sesión del usuario, invalida la sesión y regenera el token CSRF.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Has cerrado sesión exitosamente. Ya no es posible acceder a recursos protegidos sin autenticarte nuevamente.');
    }
}

