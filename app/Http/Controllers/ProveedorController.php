<?php

// Declaración del namespace donde se ubica este controlador
// Todos los controladores de Laravel están en App\Http\Controllers
namespace App\Http\Controllers;

// Importación del modelo Proveedor que representa la tabla 'proveedores' en la base de datos
// Este modelo gestiona la información de los proveedores que surten productos
use App\Models\Proveedor;

// Importación de la clase Request de Laravel para manejar peticiones HTTP
// Permite acceder a datos de formularios, validar y gestionar la entrada del usuario
use Illuminate\Http\Request;

/**
 * Controlador ProveedorController
 * 
 * Implementa el patrón CRUD para gestionar los proveedores del sistema
 * Los proveedores son las empresas o personas que suministran productos
 */
class ProveedorController extends Controller
{
    /**
     * Método index()
     * 
     * Muestra el listado paginado de todos los proveedores
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // orderBy('nombre', 'asc') - Ordena alfabéticamente por nombre
        // paginate(10) - Divide los resultados en páginas de 10 registros
        // Genera automáticamente los links de navegación entre páginas
        $proveedores = Proveedor::orderBy('nombre', 'asc')->paginate(10);
        
        // Retorna la vista resources/views/proveedores/index.blade.php
        // compact('proveedores') pasa la variable a la vista
        return view('proveedores.index', compact('proveedores'));
    }

    /**
     * Método create()
     * 
     * Muestra el formulario para crear un nuevo proveedor
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Retorna la vista del formulario de creación
        return view('proveedores.create');
    }

    /**
     * Método store()
     * 
     * Recibe los datos del formulario, los valida y crea un nuevo proveedor
     * 
     * @param Request $request Datos del formulario
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // validate() - Valida los datos recibidos del formulario
        // Si falla, Laravel redirige automáticamente con los errores
        $request->validate([
            // nombre: obligatorio (required), texto (string), máximo 150 caracteres
            'nombre' => 'required|string|max:150',
            // razon_social: opcional (nullable), texto, máximo 200 caracteres
            'razon_social' => 'nullable|string|max:200',
            // nit: opcional, texto (puede tener guiones), máximo 20 caracteres
            'nit' => 'nullable|string|max:20',
            // telefono: opcional, texto (puede tener formato especial), máximo 20 caracteres
            'telefono' => 'nullable|string|max:20',
            // email: opcional, debe tener formato de email válido, máximo 100 caracteres
            'email' => 'nullable|email|max:100',
            // direccion: opcional, texto, máximo 255 caracteres
            'direccion' => 'nullable|string|max:255',
            // contacto_principal: opcional, texto, máximo 100 caracteres
            'contacto_principal' => 'nullable|string|max:100',
        ]);

        // create() - Inserta un nuevo registro en la tabla proveedores
        // Se pasan explícitamente todos los campos a insertar
        Proveedor::create([
            'nombre' => $request->nombre,
            'razon_social' => $request->razon_social,
            'nit' => $request->nit,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'direccion' => $request->direccion,
            'contacto_principal' => $request->contacto_principal,
            // has('activo') - Verifica si el checkbox fue marcado
            // Operador ternario: si está marcado = 1, si no = 0
            'activo' => $request->has('activo') ? 1 : 0,
        ]);

        // redirect()->route() - Redirige a la ruta nombrada 'proveedores.index'
        // with('success', '...') - Flash message que se muestra una sola vez
        // Patrón PRG (Post-Redirect-Get) para evitar reenvío al recargar
        return redirect()->route('proveedores.index')->with('success', 'Proveedor creado exitosamente.');
    }

    /**
     * Método show()
     * 
     * Muestra los detalles de un proveedor específico
     * 
     * @param int $id ID del proveedor
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // findOrFail($id) - Busca el proveedor por ID
        // Si no existe, lanza error 404 automáticamente
        $proveedor = Proveedor::findOrFail($id);
        
        // Retorna la vista de detalle con los datos del proveedor
        return view('proveedores.show', compact('proveedor'));
    }

    /**
     * Método edit()
     * 
     * Muestra el formulario de edición pre-llenado con los datos actuales
     * 
     * @param int $id ID del proveedor
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Busca el proveedor a editar
        $proveedor = Proveedor::findOrFail($id);
        
        // Retorna la vista del formulario de edición
        // Los campos se pre-llenan con los datos actuales
        return view('proveedores.edit', compact('proveedor'));
    }

    /**
     * Método update()
     * 
     * Recibe los datos modificados, los valida y actualiza el proveedor
     * 
     * @param Request $request Datos del formulario
     * @param int $id ID del proveedor
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validación con las mismas reglas que en store()
        $request->validate([
            'nombre' => 'required|string|max:150',
            'razon_social' => 'nullable|string|max:200',
            'nit' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'direccion' => 'nullable|string|max:255',
            'contacto_principal' => 'nullable|string|max:100',
        ]);

        // Busca el proveedor a actualizar
        $proveedor = Proveedor::findOrFail($id);
        
        // update() - Actualiza el registro en la base de datos
        // Laravel solo actualiza los campos que cambiaron (dirty checking)
        $proveedor->update([
            'nombre' => $request->nombre,
            'razon_social' => $request->razon_social,
            'nit' => $request->nit,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'direccion' => $request->direccion,
            'contacto_principal' => $request->contacto_principal,
            // Manejo del checkbox (mismo que en store)
            'activo' => $request->has('activo') ? 1 : 0,
        ]);

        // Redirige al listado con mensaje de éxito
        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado exitosamente.');
    }

    /**
     * Método destroy()
     * 
     * Elimina un proveedor de la base de datos
     * 
     * NOTA: No tiene validación de integridad referencial
     * En producción debería validar si tiene órdenes de compra asociadas
     * 
     * @param int $id ID del proveedor
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Busca el proveedor a eliminar
        $proveedor = Proveedor::findOrFail($id);
        
        // delete() - Elimina el registro de la base de datos
        // Ejecuta: DELETE FROM proveedores WHERE id = ?
        $proveedor->delete();

        // Redirige al listado con mensaje de confirmación
        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado exitosamente.');
    }
}