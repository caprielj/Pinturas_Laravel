<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Controlador ClienteController
 * 
 * Maneja todas las operaciones CRUD para la entidad Cliente.
 * Los clientes son las personas que compran en la tienda.
 */
class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * Muestra un listado de todos los clientes.
     * GET /clientes
     */
    public function index()
    {
        // Obtener todos los clientes ordenados por nombre
        // paginate(10) divide los resultados en páginas de 10 registros
        $clientes = Cliente::orderBy('nombre', 'asc')->paginate(10);
        
        // Retornar la vista con los datos
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     * 
     * Muestra el formulario para crear un nuevo cliente.
     * GET /clientes/create
     */
    public function create()
    {
        // Retornar la vista con el formulario de creación
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     * 
     * Guarda un nuevo cliente en la base de datos.
     * POST /clientes
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'nit' => 'nullable|string|max:25|unique:clientes,nit',
            'email' => 'required|email|max:150|unique:clientes,email',
            'password' => 'nullable|string|min:6',
            'telefono' => 'nullable|string|max:30',
            'direccion' => 'nullable|string|max:255',
            'gps_lat' => 'nullable|numeric|between:-90,90',
            'gps_lng' => 'nullable|numeric|between:-180,180',
            'opt_in_promos' => 'boolean',
        ]);

        // Si se proporcionó una contraseña, encriptarla
        if ($request->filled('password')) {
            $validated['password_hash'] = Hash::make($request->password);
        }
        
        // Remover el campo password del array (ya usamos password_hash)
        unset($validated['password']);

        // Crear el nuevo cliente en la base de datos
        $cliente = Cliente::create($validated);

        // Redireccionar al listado con un mensaje de éxito
        return redirect()->route('clientes.index')
            ->with('success', 'Cliente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     * 
     * Muestra los detalles de un cliente específico.
     * GET /clientes/{id}
     */
    public function show(Cliente $cliente)
    {
        // Laravel automáticamente busca el cliente por ID (Route Model Binding)
        // Retornar la vista con los datos del cliente
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * Muestra el formulario para editar un cliente existente.
     * GET /clientes/{id}/edit
     */
    public function edit(Cliente $cliente)
    {
        // Retornar la vista con el formulario de edición
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     * 
     * Actualiza los datos de un cliente en la base de datos.
     * PUT/PATCH /clientes/{id}
     */
    public function update(Request $request, Cliente $cliente)
    {
        // Validar los datos del formulario
        // unique:clientes,email,'.$cliente->id verifica que el email sea único excepto para este cliente
        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'nit' => 'nullable|string|max:25|unique:clientes,nit,' . $cliente->id,
            'email' => 'required|email|max:150|unique:clientes,email,' . $cliente->id,
            'password' => 'nullable|string|min:6',
            'telefono' => 'nullable|string|max:30',
            'direccion' => 'nullable|string|max:255',
            'gps_lat' => 'nullable|numeric|between:-90,90',
            'gps_lng' => 'nullable|numeric|between:-180,180',
            'opt_in_promos' => 'boolean',
            'verificado' => 'boolean',
        ]);

        // Si se proporcionó una nueva contraseña, encriptarla
        if ($request->filled('password')) {
            $validated['password_hash'] = Hash::make($request->password);
        }
        
        // Remover el campo password del array
        unset($validated['password']);

        // Actualizar el cliente en la base de datos
        $cliente->update($validated);

        // Redireccionar al listado con un mensaje de éxito
        return redirect()->route('clientes.index')
            ->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     * 
     * Elimina un cliente de la base de datos.
     * DELETE /clientes/{id}
     */
    public function destroy(Cliente $cliente)
    {
        // Eliminar el cliente
        $cliente->delete();

        // Redireccionar al listado con un mensaje de éxito
        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado exitosamente.');
    }
}