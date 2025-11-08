<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Controlador UsuarioController
 * 
 * Maneja todas las operaciones CRUD para la entidad Usuario.
 * Los usuarios son los empleados del sistema con diferentes roles.
 * 
 * Roles disponibles:
 * - Digitador: Alimenta el sistema con datos
 * - Cajero: Solo puede cobrar (autorizar ventas)
 * - Gerente: Puede observar reportes
 */
class UsuarioController extends Controller
{
    /**
     * Muestra un listado de todos los usuarios.
     * GET /usuarios
     */
    public function index()
    {
        // Obtener todos los usuarios con sus relaciones (rol y sucursal)
        $usuarios = Usuario::with(['rol', 'sucursal'])
            ->orderBy('nombre', 'asc')
            ->paginate(10);
        
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     * GET /usuarios/create
     */
    public function create()
    {
        // Obtener roles y sucursales para los select del formulario
        $roles = Rol::orderBy('nombre', 'asc')->get();
        $sucursales = Sucursal::activas()->orderBy('nombre', 'asc')->get();
        
        return view('usuarios.create', compact('roles', 'sucursales'));
    }

    /**
     * Guarda un nuevo usuario en la base de datos.
     * POST /usuarios
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:120',
            'dpi' => 'required|string|max:20|unique:usuarios,dpi',
            'email' => 'required|email|max:150|unique:usuarios,email',
            'password' => 'required|string|min:6|confirmed', // confirmed verifica password_confirmation
            'rol_id' => 'required|exists:roles,id',
            'sucursal_id' => 'nullable|exists:sucursales,id',
            'activo' => 'boolean',
        ]);

        // Encriptar la contraseña
        $validated['password_hash'] = Hash::make($validated['password']);
        
        // Remover el campo password del array
        unset($validated['password']);

        // Si no se envía 'activo', por defecto será true
        if (!isset($validated['activo'])) {
            $validated['activo'] = true;
        }

        // Crear el usuario
        $usuario = Usuario::create($validated);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Muestra los detalles de un usuario específico.
     * GET /usuarios/{id}
     */
    public function show(Usuario $usuario)
    {
        // Cargar las relaciones
        $usuario->load(['rol', 'sucursal', 'facturas', 'cotizaciones']);
        
        return view('usuarios.show', compact('usuario'));
    }

    /**
     * Muestra el formulario para editar un usuario.
     * GET /usuarios/{id}/edit
     */
    public function edit(Usuario $usuario)
    {
        // Obtener roles y sucursales para los select
        $roles = Rol::orderBy('nombre', 'asc')->get();
        $sucursales = Sucursal::activas()->orderBy('nombre', 'asc')->get();
        
        return view('usuarios.edit', compact('usuario', 'roles', 'sucursales'));
    }

    /**
     * Actualiza un usuario en la base de datos.
     * PUT/PATCH /usuarios/{id}
     */
    public function update(Request $request, Usuario $usuario)
    {
        // Validar los datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:120',
            'dpi' => 'required|string|max:20|unique:usuarios,dpi,' . $usuario->id,
            'email' => 'required|email|max:150|unique:usuarios,email,' . $usuario->id,
            'password' => 'nullable|string|min:6|confirmed', // nullable porque es opcional al editar
            'rol_id' => 'required|exists:roles,id',
            'sucursal_id' => 'nullable|exists:sucursales,id',
            'activo' => 'boolean',
        ]);

        // Si se proporcionó una nueva contraseña, encriptarla
        if ($request->filled('password')) {
            $validated['password_hash'] = Hash::make($validated['password']);
        }
        
        // Remover el campo password del array
        unset($validated['password']);

        // Actualizar el usuario
        $usuario->update($validated);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Elimina un usuario de la base de datos.
     * DELETE /usuarios/{id}
     */
    public function destroy(Usuario $usuario)
    {
        // Verificar si tiene facturas, cotizaciones u órdenes asociadas
        if ($usuario->facturas()->count() > 0 || 
            $usuario->cotizaciones()->count() > 0 || 
            $usuario->ordenesCompra()->count() > 0) {
            return redirect()->route('usuarios.index')
                ->with('error', 'No se puede eliminar el usuario porque tiene transacciones asociadas.');
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }
}