<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use Illuminate\Http\Request;

/**
 * Controlador SucursalController
 * 
 * Maneja todas las operaciones CRUD para la entidad Sucursal.
 * Las sucursales son las diferentes tiendas de la cadena "Paints".
 */
class SucursalController extends Controller
{
    /**
     * Muestra un listado de todas las sucursales.
     * GET /sucursales
     */
    public function index()
    {
        // Obtener todas las sucursales ordenadas por nombre
        $sucursales = Sucursal::orderBy('nombre', 'asc')->paginate(10);
        
        return view('sucursales.index', compact('sucursales'));
    }

    /**
     * Muestra el formulario para crear una nueva sucursal.
     * GET /sucursales/create
     */
    public function create()
    {
        return view('sucursales.create');
    }

    /**
     * Guarda una nueva sucursal en la base de datos.
     * POST /sucursales
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:120|unique:sucursales,nombre',
            'direccion' => 'nullable|string|max:255',
            'gps_lat' => 'nullable|numeric|between:-90,90',
            'gps_lng' => 'nullable|numeric|between:-180,180',
            'telefono' => 'nullable|string|max:30',
            'activa' => 'boolean',
        ]);

        // Crear la sucursal
        $sucursal = Sucursal::create($validated);

        return redirect()->route('sucursales.index')
            ->with('success', 'Sucursal creada exitosamente.');
    }

    /**
     * Muestra los detalles de una sucursal específica.
     * GET /sucursales/{id}
     */
    public function show(Sucursal $sucursal)
    {
        // Cargar las relaciones (usuarios, inventarios)
        $sucursal->load(['usuarios', 'inventarios']);
        
        return view('sucursales.show', compact('sucursal'));
    }

    /**
     * Muestra el formulario para editar una sucursal.
     * GET /sucursales/{id}/edit
     */
    public function edit(Sucursal $sucursal)
    {
        return view('sucursales.edit', compact('sucursal'));
    }

    /**
     * Actualiza una sucursal en la base de datos.
     * PUT/PATCH /sucursales/{id}
     */
    public function update(Request $request, Sucursal $sucursal)
    {
        // Validar los datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:120|unique:sucursales,nombre,' . $sucursal->id,
            'direccion' => 'nullable|string|max:255',
            'gps_lat' => 'nullable|numeric|between:-90,90',
            'gps_lng' => 'nullable|numeric|between:-180,180',
            'telefono' => 'nullable|string|max:30',
            'activa' => 'boolean',
        ]);

        // Actualizar la sucursal
        $sucursal->update($validated);

        return redirect()->route('sucursales.index')
            ->with('success', 'Sucursal actualizada exitosamente.');
    }

    /**
     * Elimina una sucursal de la base de datos.
     * DELETE /sucursales/{id}
     */
    public function destroy(Sucursal $sucursal)
    {
        // Verificar si tiene usuarios, inventarios o facturas asociadas
        if ($sucursal->usuarios()->count() > 0 || 
            $sucursal->inventarios()->count() > 0 || 
            $sucursal->facturas()->count() > 0) {
            return redirect()->route('sucursales.index')
                ->with('error', 'No se puede eliminar la sucursal porque tiene datos asociados.');
        }

        $sucursal->delete();

        return redirect()->route('sucursales.index')
            ->with('success', 'Sucursal eliminada exitosamente.');
    }
}