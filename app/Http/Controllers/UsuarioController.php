<?php

// Declaración del namespace donde se ubica este controlador
// Todos los controladores de Laravel están en App\Http\Controllers
namespace App\Http\Controllers;

// Importación del modelo Usuario que representa la tabla 'usuarios' en la base de datos
// Este modelo gestiona la información de los usuarios del sistema
use App\Models\Usuario;

// Importación del modelo Rol para gestionar los roles de usuario
// Ejemplo: Administrador, Vendedor, Bodeguero, etc.
use App\Models\Rol;

// Importación del modelo Sucursal para asignar usuarios a sucursales específicas
use App\Models\Sucursal;

// Importación de la clase Request de Laravel para manejar peticiones HTTP
use Illuminate\Http\Request;

// Importación de la clase Hash (Facade) para encriptar contraseñas
// Utiliza bcrypt por defecto, un algoritmo seguro de hashing
use Illuminate\Support\Facades\Hash;

/**
 * Controlador UsuarioController
 * 
 * Implementa el patrón CRUD para gestionar los usuarios del sistema
 * Incluye funcionalidades de:
 * - Encriptación de contraseñas con Hash/bcrypt
 * - Relaciones con Roles y Sucursales
 * - Validación de datos únicos (DPI, email)
 * - Manejo seguro de contraseñas (no se almacenan en texto plano)
 */
class UsuarioController extends Controller
{
    /**
     * Método index()
     * 
     * Muestra el listado de todos los usuarios con sus relaciones
     * Implementa EAGER LOADING para optimizar consultas
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // with(['rol', 'sucursal']) - EAGER LOADING de relaciones
        // Carga los usuarios junto con su rol y sucursal en una sola consulta optimizada
        // Evita el problema N+1 (múltiples consultas a la BD)
        // orderBy('nombre') - Ordena alfabéticamente por nombre
        // get() - Obtiene todos los registros
        $usuarios = Usuario::with(['rol', 'sucursal'])->orderBy('nombre')->get();
        
        // Retorna la vista resources/views/usuarios/index.blade.php
        // compact('usuarios') pasa la variable a la vista
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Método create()
     * 
     * Muestra el formulario para crear un nuevo usuario
     * Pre-carga los catálogos de roles y sucursales para los dropdowns
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Obtiene todos los roles ordenados alfabéticamente
        // Se usará para llenar el select/dropdown de roles
        $roles = Rol::orderBy('nombre')->get();
        
        // Obtiene solo las sucursales ACTIVAS ordenadas alfabéticamente
        // where('activa', true) - Filtra solo sucursales habilitadas
        // Solo se permite asignar usuarios a sucursales activas
        $sucursales = Sucursal::where('activa', true)->orderBy('nombre')->get();
        
        // Retorna la vista del formulario de creación pasando dos variables
        return view('usuarios.create', compact('roles', 'sucursales'));
    }

    /**
     * Método store()
     * 
     * Recibe los datos del formulario, los valida y crea un nuevo usuario
     * Encripta la contraseña antes de guardarla usando Hash/bcrypt
     * 
     * @param Request $request Datos del formulario
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // validate() - Valida los datos recibidos del formulario
        $request->validate([
            // nombre: obligatorio, texto, máximo 120 caracteres
            'nombre' => 'required|string|max:120',
            
            // dpi: Documento Personal de Identificación (Guatemala)
            // required - obligatorio
            // string - texto
            // max:20 - máximo 20 caracteres
            // unique:usuarios,dpi - No puede haber dos usuarios con el mismo DPI
            'dpi' => 'required|string|max:20|unique:usuarios,dpi',
            
            // email: obligatorio, formato email válido, máximo 150 caracteres
            // unique:usuarios,email - No puede haber dos usuarios con el mismo email
            'email' => 'required|email|max:150|unique:usuarios,email',
            
            // password: contraseña
            // required - obligatorio en creación
            // string - texto
            // min:6 - mínimo 6 caracteres por seguridad
            // confirmed - debe coincidir con password_confirmation del formulario
            'password' => 'required|string|min:6|confirmed',
            
            // rol_id: clave foránea
            // required - debe seleccionar un rol
            // exists:roles,id - Valida que el ID exista en la tabla roles
            'rol_id' => 'required|exists:roles,id',
            
            // sucursal_id: clave foránea
            // nullable - opcional, puede no asignarse a ninguna sucursal
            // exists:sucursales,id - Si se envía, debe existir en la tabla sucursales
            'sucursal_id' => 'nullable|exists:sucursales,id',
            
            // activo: campo booleano para activar/desactivar usuario
            'activo' => 'nullable|boolean',
        ]);

        // except(['password', 'password_confirmation'])
        // Obtiene todos los campos EXCEPTO password y password_confirmation
        // Esto evita guardar la contraseña en texto plano
        $data = $request->except(['password', 'password_confirmation']);
        
        // Hash::make() - Encripta la contraseña usando bcrypt
        // bcrypt es un algoritmo de hashing seguro que incluye salt automáticamente
        // La contraseña se guarda encriptada en el campo password_hash
        // NUNCA se guarda la contraseña en texto plano
        $data['password_hash'] = Hash::make($request->password);
        
        // Manejo del checkbox 'activo'
        // has('activo') - Verifica si el checkbox fue marcado
        // Operador ternario: marcado = 1, no marcado = 0
        $data['activo'] = $request->has('activo') ? 1 : 0;

        // create() - Inserta el nuevo usuario en la base de datos
        Usuario::create($data);

        // Redirige al listado con mensaje de éxito
        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado exitosamente');
    }

    /**
     * Método show()
     * 
     * Muestra los detalles de un usuario específico
     * Incluye EAGER LOADING de sus relaciones (rol y sucursal)
     * 
     * @param int $id ID del usuario
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // with(['rol', 'sucursal']) - EAGER LOADING de relaciones
        // Carga el usuario junto con su rol y sucursal en una consulta optimizada
        // findOrFail($id) - Busca por ID o lanza error 404 si no existe
        $usuario = Usuario::with(['rol', 'sucursal'])->findOrFail($id);
        
        // Retorna la vista de detalle con los datos del usuario
        // En la vista se puede acceder a: $usuario->rol->nombre, $usuario->sucursal->nombre
        return view('usuarios.show', compact('usuario'));
    }

    /**
     * Método edit()
     * 
     * Muestra el formulario de edición pre-llenado con los datos actuales
     * Pre-carga los catálogos de roles y sucursales
     * 
     * @param int $id ID del usuario
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Busca el usuario a editar
        $usuario = Usuario::findOrFail($id);
        
        // Carga los roles para el select (mismo que en create)
        $roles = Rol::orderBy('nombre')->get();
        
        // Carga las sucursales activas para el select
        $sucursales = Sucursal::where('activa', true)->orderBy('nombre')->get();
        
        // Retorna la vista del formulario de edición con tres variables
        return view('usuarios.edit', compact('usuario', 'roles', 'sucursales'));
    }

    /**
     * Método update()
     * 
     * Recibe los datos modificados, los valida y actualiza el usuario
     * Maneja la actualización opcional de la contraseña
     * 
     * @param Request $request Datos del formulario
     * @param int $id ID del usuario
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Busca el usuario a actualizar antes de validar
        $usuario = Usuario::findOrFail($id);
        
        // Validación con reglas similares a store()
        $request->validate([
            'nombre' => 'required|string|max:120',
            
            // unique:usuarios,dpi,' . $usuario->id
            // Concatenación: verifica que el DPI sea único EXCEPTO para este usuario
            // Permite mantener el mismo DPI al editar
            'dpi' => 'required|string|max:20|unique:usuarios,dpi,' . $usuario->id,
            
            // unique:usuarios,email,' . $usuario->id
            // Verifica que el email sea único EXCEPTO para este usuario
            'email' => 'required|email|max:150|unique:usuarios,email,' . $usuario->id,
            
            // password: nullable en edición
            // Solo es obligatorio si se quiere cambiar la contraseña
            // Si está vacío, se mantiene la contraseña actual
            'password' => 'nullable|string|min:6|confirmed',
            
            'rol_id' => 'required|exists:roles,id',
            'sucursal_id' => 'nullable|exists:sucursales,id',
            'activo' => 'nullable|boolean',
        ]);

        // Obtiene todos los campos excepto los relacionados con contraseña
        $data = $request->except(['password', 'password_confirmation']);
        
        // filled('password') - Verifica si el campo password tiene un valor (no está vacío)
        // Solo actualiza la contraseña si el usuario ingresó una nueva
        if ($request->filled('password')) {
            // Hash::make() - Encripta la nueva contraseña
            $data['password_hash'] = Hash::make($request->password);
        }
        // Si no se ingresó contraseña, se mantiene la actual (no se modifica)
        
        // Manejo del checkbox 'activo'
        $data['activo'] = $request->has('activo') ? 1 : 0;

        // update() - Actualiza el registro en la base de datos
        // Laravel solo actualiza los campos que cambiaron (dirty checking)
        $usuario->update($data);

        // Redirige al listado con mensaje de éxito
        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado exitosamente');
    }

    /**
     * Método destroy()
     * 
     * Elimina un usuario de la base de datos
     * 
     * NOTA: La validación de integridad está comentada (Fase 2)
     * En producción debería verificar si el usuario tiene:
     * - Facturas registradas
     * - Cotizaciones creadas
     * - Órdenes de compra
     * 
     * @param int $id ID del usuario
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Busca el usuario a eliminar
        $usuario = Usuario::findOrFail($id);
        
        // VALIDACIÓN DE INTEGRIDAD REFERENCIAL - COMENTADA (FASE 2)
        // Este código está comentado porque los modelos de transacciones aún no existen
        // En la Fase 2, cuando se implementen facturas, cotizaciones y órdenes de compra,
        // se activará esta validación para proteger datos relacionados
        //
        // Comentado temporalmente - se activará en Fase 2
        // Propósito: Prevenir la eliminación de usuarios que tienen transacciones
        // if ($usuario->facturas()->count() > 0 || 
        //     $usuario->cotizaciones()->count() > 0 || 
        //     $usuario->ordenesCompra()->count() > 0) {
        //     // Si tiene transacciones asociadas, NO se permite la eliminación
        //     return redirect()->route('usuarios.index')
        //         ->with('error', 'No se puede eliminar. Tiene transacciones asociadas');
        // }

        // delete() - Elimina el registro de la base de datos
        // Ejecuta: DELETE FROM usuarios WHERE id = ?
        $usuario->delete();

        // Redirige al listado con mensaje de confirmación
        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado exitosamente');
    }
}