<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

/**
 * Controlador ProveedorController
 * 
 * Maneja todas las operaciones CRUD para la entidad Proveedor.
 * Los proveedores son las empresas que suministran productos.
 */
class ProveedorController extends Controller
{
    /**
     * Muestra un listado de todos los proveedores.
     * GET /proveedores
     */
    public function index()
    {
        // Obtener todos los proveedores ordenados por nombre
        $proveedores = Proveedor::orderBy('nombre', 'asc')->paginate(10);
        
        return view('proveedores.index', compact('proveedores'));
    }

    /**
     * Muestra el formulario para crear un nuevo proveedor.
     * GET /proveedores/create
     */
    public function create()
    {
        return view('proveedores.create');
    }

    /**
     * Guarda un nuevo proveedor en la base de datos.
     * POST /proveedores
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'razon_social' => 'nullable|string|max:200',
            'nit' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'direccion' => 'nullable|string|max:255',
            'contacto_principal' => 'nullable|string|max:100',
            'activo' => 'boolean',
        ]);

        // Crear el proveedor
        $proveedor = Proveedor::create($validated);

        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor creado exitosamente.');
    }

    /**
     * Muestra los detalles de un proveedor específico.
     * GET /proveedores/{id}
     */
    public function show(Proveedor $proveedor)
    {
        // Cargar las órdenes de compra del proveedor (relación)
        $proveedor->load('ordenesCompra');
        
        return view('proveedores.show', compact('proveedor'));
    }

    /**
     * Muestra el formulario para editar un proveedor.
     * GET /proveedores/{id}/edit
     */
    public function edit(Proveedor $proveedor)
    {
        return view('proveedores.edit', compact('proveedor'));
    }

    /**
     * Actualiza un proveedor en la base de datos.
     * PUT/PATCH /proveedores/{id}
     */
    public function update(Request $request, Proveedor $proveedor)
    {
        // Validar los datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'razon_social' => 'nullable|string|max:200',
            'nit' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'direccion' => 'nullable|string|max:255',
            'contacto_principal' => 'nullable|string|max:100',
            'activo' => 'boolean',
        ]);

        // Actualizar el proveedor
        $proveedor->update($validated);

        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor actualizado exitosamente.');
    }

    /**
     * Elimina un proveedor de la base de datos.
     * DELETE /proveedores/{id}
     */
    public function destroy(Proveedor $proveedor)
    {
        // Verificar si tiene órdenes de compra asociadas
        if ($proveedor->ordenesCompra()->count() > 0) {
            return redirect()->route('proveedores.index')
                ->with('error', 'No se puede eliminar el proveedor porque tiene órdenes de compra asociadas.');
        }

        $proveedor->delete();

        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor eliminado exitosamente.');
    }
}