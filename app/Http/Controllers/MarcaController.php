<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

/**
 * Controlador MarcaController
 * 
 * Maneja todas las operaciones CRUD para la entidad Marca.
 * Las marcas son los fabricantes de productos (Sherwin Williams, Comex, Berel, etc.)
 */
class MarcaController extends Controller
{
    /**
     * Muestra un listado de todas las marcas.
     * GET /marcas
     */
    public function index()
    {
        // Obtener todas las marcas con el conteo de productos
        $marcas = Marca::withCount('productos')
            ->orderBy('nombre', 'asc')
            ->paginate(10);
        
        return view('marcas.index', compact('marcas'));
    }

    /**
     * Muestra el formulario para crear una nueva marca.
     * GET /marcas/create
     */
    public function create()
    {
        return view('marcas.create');
    }

    /**
     * Guarda una nueva marca en la base de datos.
     * POST /marcas
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:80|unique:marcas,nombre',
            'activa' => 'boolean',
        ]);

        // Si no se envía 'activa', por defecto será true
        if (!isset($validated['activa'])) {
            $validated['activa'] = true;
        }

        // Crear la marca
        $marca = Marca::create($validated);

        return redirect()->route('marcas.index')
            ->with('success', 'Marca creada exitosamente.');
    }

    /**
     * Muestra los detalles de una marca específica.
     * GET /marcas/{id}
     */
    public function show(Marca $marca)
    {
        // Cargar los productos de esta marca
        $productos = $marca->productos()->paginate(10);
        
        return view('marcas.show', compact('marca', 'productos'));
    }

    /**
     * Muestra el formulario para editar una marca.
     * GET /marcas/{id}/edit
     */
    public function edit(Marca $marca)
    {
        return view('marcas.edit', compact('marca'));
    }

    /**
     * Actualiza una marca en la base de datos.
     * PUT/PATCH /marcas/{id}
     */
    public function update(Request $request, Marca $marca)
    {
        // Validar los datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:80|unique:marcas,nombre,' . $marca->id,
            'activa' => 'boolean',
        ]);

        // Actualizar la marca
        $marca->update($validated);

        return redirect()->route('marcas.index')
            ->with('success', 'Marca actualizada exitosamente.');
    }

    /**
     * Elimina una marca de la base de datos.
     * DELETE /marcas/{id}
     */
    public function destroy(Marca $marca)
    {
        // Verificar si tiene productos asociados
        if ($marca->productos()->count() > 0) {
            return redirect()->route('marcas.index')
                ->with('error', 'No se puede eliminar la marca porque tiene productos asociados.');
        }

        $marca->delete();

        return redirect()->route('marcas.index')
            ->with('success', 'Marca eliminada exitosamente.');
    }
}