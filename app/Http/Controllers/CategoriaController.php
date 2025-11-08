<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

/**
 * Controlador CategoriaController
 * 
 * Maneja todas las operaciones CRUD para la entidad Categoria.
 * Las categorías clasifican los productos (Pinturas Interior, Exterior, Solventes, etc.)
 */
class CategoriaController extends Controller
{
    /**
     * Muestra un listado de todas las categorías.
     * GET /categorias
     */
    public function index()
    {
        // Obtener todas las categorías ordenadas alfabéticamente
        // withCount('productos') cuenta cuántos productos tiene cada categoría
        $categorias = Categoria::withCount('productos')
            ->orderBy('nombre', 'asc')
            ->paginate(10);
        
        return view('categorias.index', compact('categorias'));
    }

    /**
     * Muestra el formulario para crear una nueva categoría.
     * GET /categorias/create
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Guarda una nueva categoría en la base de datos.
     * POST /categorias
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:60|unique:categorias,nombre',
            'descripcion' => 'nullable|string|max:255',
        ]);

        // Crear la categoría
        $categoria = Categoria::create($validated);

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría creada exitosamente.');
    }

    /**
     * Muestra los detalles de una categoría específica.
     * GET /categorias/{id}
     */
    public function show(Categoria $categoria)
    {
        // Cargar los productos de esta categoría con paginación
        $productos = $categoria->productos()->paginate(10);
        
        return view('categorias.show', compact('categoria', 'productos'));
    }

    /**
     * Muestra el formulario para editar una categoría.
     * GET /categorias/{id}/edit
     */
    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Actualiza una categoría en la base de datos.
     * PUT/PATCH /categorias/{id}
     */
    public function update(Request $request, Categoria $categoria)
    {
        // Validar los datos
        // La validación unique excluye el ID actual para permitir mantener el mismo nombre
        $validated = $request->validate([
            'nombre' => 'required|string|max:60|unique:categorias,nombre,' . $categoria->id,
            'descripcion' => 'nullable|string|max:255',
        ]);

        // Actualizar la categoría
        $categoria->update($validated);

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría actualizada exitosamente.');
    }

    /**
     * Elimina una categoría de la base de datos.
     * DELETE /categorias/{id}
     */
    public function destroy(Categoria $categoria)
    {
        // Verificar si tiene productos asociados
        // No se puede eliminar una categoría si tiene productos
        if ($categoria->productos()->count() > 0) {
            return redirect()->route('categorias.index')
                ->with('error', 'No se puede eliminar la categoría porque tiene productos asociados.');
        }

        $categoria->delete();

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría eliminada exitosamente.');
    }
}