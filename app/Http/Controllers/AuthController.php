<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

/**
 * Controlador AuthController
 *
 * Maneja la autenticación de usuarios (login/logout) del sistema.
 * Permite que los administradores accedan a las vistas de gestión.
 */
class AuthController extends Controller
{
    /**
     * Muestra el formulario de login
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        // Si ya está autenticado, redirigir al dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Procesa el intento de login
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validar los datos del formulario
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingrese un correo electrónico válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        // Buscar el usuario por email
        $usuario = Usuario::where('email', $credentials['email'])->first();

        // Verificar si el usuario existe, está activo y la contraseña es correcta
        if ($usuario &&
            $usuario->activo &&
            Hash::check($credentials['password'], $usuario->password_hash)) {

            // Autenticar al usuario
            Auth::login($usuario, $request->boolean('remember'));

            // Regenerar la sesión para prevenir ataques de fijación de sesión
            $request->session()->regenerate();

            // Redirigir al dashboard con mensaje de éxito
            return redirect()->intended(route('dashboard'))
                ->with('success', '¡Bienvenido ' . $usuario->nombre . '!');
        }

        // Si falla la autenticación, regresar con error
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros o el usuario está inactivo.',
        ])->onlyInput('email');
    }

    /**
     * Cierra la sesión del usuario
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Cerrar sesión
        Auth::logout();

        // Invalidar la sesión
        $request->session()->invalidate();

        // Regenerar el token CSRF
        $request->session()->regenerateToken();

        // Redirigir a la página de inicio
        return redirect()->route('home')
            ->with('success', 'Sesión cerrada exitosamente.');
    }
}
