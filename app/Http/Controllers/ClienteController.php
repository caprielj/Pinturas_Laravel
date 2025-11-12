<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Librería para encriptar contraseñas

/**
 * ClienteController
 * 
 * Controlador para gestionar CRUD de clientes en Fase 1
 * Los clientes son las personas que compran en la tienda
 */
class ClienteController extends Controller
{
    /**
     * index()
     * 
     * Muestra el listado de todos los clientes
     * Variables: $clientes (Collection de modelos Cliente)
     * 
     * @return View vista clientes.index
     */
    public function index()
    {
        // Obtener todos los clientes ordenados alfabéticamente por nombre
        // orderBy('nombre') = ordena de A-Z
        // get() = ejecuta la consulta y devuelve una colección
        $clientes = Cliente::orderBy('nombre')->get();
        
        // compact('clientes') = pasa la variable $clientes a la vista
        return view('clientes.index', compact('clientes'));
    }

    /**
     * create()
     * 
     * Muestra el formulario para crear un nuevo cliente
     * 
     * @return View vista clientes.create
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * store()
     * 
     * Guarda un nuevo cliente en la base de datos
     * Variables:
     * - $request: Objeto Request con los datos del formulario
     * - $data: Array con datos validados para crear el cliente
     * 
     * Librerías usadas:
     * - Hash::make(): Encripta la contraseña usando bcrypt
     * 
     * @param Request $request Datos del formulario
     * @return RedirectResponse Redirección al listado
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        // required = obligatorio
        // string = debe ser texto
        // max:150 = máximo 150 caracteres
        // unique:clientes,email = el email debe ser único en la tabla clientes
        // nullable = campo opcional
        // email = debe ser formato email válido
        // numeric = debe ser número
        // between:-90,90 = valor entre -90 y 90 (para latitud)
        $request->validate([
            'nombre' => 'required|string|max:150',
            'nit' => 'nullable|string|max:25|unique:clientes,nit',
            'email' => 'required|email|max:150|unique:clientes,email',
            'password' => 'nullable|string|min:6',
            'telefono' => 'nullable|string|max:30',
            'direccion' => 'nullable|string|max:255',
            'gps_lat' => 'nullable|numeric|between:-90,90',
            'gps_lng' => 'nullable|numeric|between:-180,180',
            'opt_in_promos' => 'nullable|boolean',
        ]);

        // Preparar datos para insertar
        // except() = obtiene todos los datos EXCEPTO el password
        $data = $request->except(['password']);
        
        // Si el usuario proporcionó una contraseña, encriptarla
        // filled('password') = verifica si el campo password tiene algún valor
        // Hash::make() = encripta la contraseña usando bcrypt (algoritmo seguro)
        if ($request->filled('password')) {
            $data['password_hash'] = Hash::make($request->password);
        }
        
        // Manejar el checkbox opt_in_promos
        // has('opt_in_promos') = verifica si el checkbox fue marcado
        // Si está marcado = 1 (true), si no = 0 (false)
        $data['opt_in_promos'] = $request->has('opt_in_promos') ? 1 : 0;

        // Crear el cliente en la base de datos
        // create() = INSERT INTO clientes (nombre, email, ...) VALUES (...)
        Cliente::create($data);

        // Redireccionar al listado con mensaje de éxito
        // route('clientes.index') = genera la URL /clientes
        // with('success', '...') = crea una variable de sesión flash
        return redirect()->route('clientes.index')
            ->with('success', 'Cliente creado exitosamente');
    }

    /**
     * show()
     * 
     * Muestra los detalles de un cliente específico
     * Variables:
     * - $id: ID del cliente a mostrar
     * - $cliente: Modelo Cliente encontrado
     * 
     * @param int $id ID del cliente
     * @return View vista clientes.show
     */
    public function show($id)
    {
        // Buscar el cliente por ID
        // findOrFail($id) = SELECT * FROM clientes WHERE id = $id
        // Si no encuentra el cliente, lanza error 404
        $cliente = Cliente::findOrFail($id);

        // ¿Para qué sirve compact() en PHP?
        // compact() es una función de PHP que crea un array asociativo a partir de
        // nombres de variables. Es muy útil cuando necesitas pasar múltiples variables a una vista.

        return view('clientes.show', compact('cliente'));
    }

    /**
     * edit()
     * 
     * Muestra el formulario para editar un cliente existente
     * Variables:
     * - $id: ID del cliente a editar
     * - $cliente: Modelo Cliente con los datos actuales
     * 
     * @param int $id ID del cliente
     * @return View vista clientes.edit
     */
    public function edit($id)
    {
        // Buscar el cliente por ID
        $cliente = Cliente::findOrFail($id);
        
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * update()
     * 
     * Actualiza los datos de un cliente en la base de datos
     * Variables:
     * - $request: Objeto Request con los datos del formulario
     * - $id: ID del cliente a actualizar
     * - $cliente: Modelo Cliente a actualizar
     * - $data: Array con datos validados
     * 
     * Funciones:
     * - unique:clientes,email,' . $id = valida que el email sea único EXCEPTO para este cliente
     * 
     * @param Request $request Datos del formulario
     * @param int $id ID del cliente
     * @return RedirectResponse Redirección al listado
     */
    public function update(Request $request, $id)
    {
        // Buscar el cliente a actualizar
        $cliente = Cliente::findOrFail($id);
        
        // Validar los datos
        // unique:clientes,nit,' . $id = permite mantener el mismo NIT
        // unique:clientes,email,' . $id = permite mantener el mismo email
        $request->validate([
            'nombre' => 'required|string|max:150',
            'nit' => 'nullable|string|max:25|unique:clientes,nit,' . $id,
            'email' => 'required|email|max:150|unique:clientes,email,' . $id,
            'password' => 'nullable|string|min:6',
            'telefono' => 'nullable|string|max:30',
            'direccion' => 'nullable|string|max:255',
            'gps_lat' => 'nullable|numeric|between:-90,90',
            'gps_lng' => 'nullable|numeric|between:-180,180',
            'opt_in_promos' => 'nullable|boolean',
            'verificado' => 'nullable|boolean',
        ]);

        // Preparar datos para actualizar
        $data = $request->except(['password']);
        
        // Si se proporcionó una nueva contraseña, encriptarla
        // Solo se actualiza si el usuario ingresó una nueva contraseña
        if ($request->filled('password')) {
            $data['password_hash'] = Hash::make($request->password);
        }
        
        // Manejar los checkboxes (opt_in_promos y verificado)
        $data['opt_in_promos'] = $request->has('opt_in_promos') ? 1 : 0;
        $data['verificado'] = $request->has('verificado') ? 1 : 0;

        // Actualizar el cliente en la base de datos
        // update($data) = UPDATE clientes SET nombre = ?, email = ? WHERE id = ?
        $cliente->update($data);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente actualizado exitosamente');
    }

    /**
     * destroy()
     * 
     * Elimina un cliente de la base de datos
     * Variables:
     * - $id: ID del cliente a eliminar
     * - $cliente: Modelo Cliente a eliminar
     * 
     * Nota: En Fase 1 no verificamos si tiene facturas asociadas
     *       Esa verificación se agregará en Fase 2
     * 
     * @param int $id ID del cliente
     * @return RedirectResponse Redirección al listado
     */
    public function destroy($id)
    {
        // Buscar el cliente a eliminar
        $cliente = Cliente::findOrFail($id);

        // Eliminar el cliente
        $cliente->delete();

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado exitosamente');
    }
}