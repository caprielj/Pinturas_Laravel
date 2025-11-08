<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Marca;
use Illuminate\Http\Request;

/**
 * Controlador ProductoController
 * 
 * Maneja todas las operaciones CRUD para la entidad Producto.
 * Los productos incluyen: pinturas, solventes, accesorios y barnices.
 */
class ProductoController extends Controller
{
    /**
     * Muestra un listado de todos los productos.
     * GET /productos
     */
    public function index()
    {
        // Obtener todos los productos con sus relaciones (categoría y marca)
        // eager loading con 'with' mejora el rendimiento
        $productos = Producto::with(['categoria', 'marca'])
            ->orderBy('descripcion', 'asc')
            ->paginate(10);
        
        return view('productos.index', compact('productos'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     * GET /productos/create
     */
    public function create()
    {
        // Obtener categorías y marcas activas para los select del formulario
        $categorias = Categoria::orderBy('nombre', 'asc')->get();
        $marcas = Marca::activas()->orderBy('nombre', 'asc')->get();
        
        return view('productos.create', compact('categorias', 'marcas'));
    }

    /**
     * Guarda un nuevo producto en la base de datos.
     * POST /productos
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'marca_id' => 'required|exists:marcas,id',
            'codigo_sku' => 'required|string|max:50|unique:productos,codigo_sku',
            'descripcion' => 'required|string|max:255',
            'tamano' => 'nullable|string|max:40',
            'duracion_anios' => 'nullable|integer|min:0',
            'extension_m2' => 'nullable|numeric|min:0',
            'color' => 'nullable|string|max:60',
            'activo' => 'boolean',
        ]);

        // Crear el producto
        $producto = Producto::create($validated);

        return redirect()->route('productos.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Muestra los detalles de un producto específico.
     * GET /productos/{id}
     */
    public function show(Producto $producto)
    {
        // Cargar las relaciones
        $producto->load(['categoria', 'marca', 'presentaciones']);
        
        return view('productos.show', compact('producto'));
    }

    /**
     * Muestra el formulario para editar un producto.
     * GET /productos/{id}/edit
     */
    public function edit(Producto $producto)
    {
        // Obtener categorías y marcas para los select
        $categorias = Categoria::orderBy('nombre', 'asc')->get();
        $marcas = Marca::activas()->orderBy('nombre', 'asc')->get();
        
        return view('productos.edit', compact('producto', 'categorias', 'marcas'));
    }

    /**
     * Actualiza un producto en la base de datos.
     * PUT/PATCH /productos/{id}
     */
    public function update(Request $request, Producto $producto)
    {
        // Validar los datos
        $validated = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'marca_id' => 'required|exists:marcas,id',
            'codigo_sku' => 'required|string|max:50|unique:productos,codigo_sku,' . $producto->id,
            'descripcion' => 'required|string|max:255',
            'tamano' => 'nullable|string|max:40',
            'duracion_anios' => 'nullable|integer|min:0',
            'extension_m2' => 'nullable|numeric|min:0',
            'color' => 'nullable|string|max:60',
            'activo' => 'boolean',
        ]);

        // Actualizar el producto
        $producto->update($validated);

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Elimina un producto de la base de datos.
     * DELETE /productos/{id}
     */
    public function destroy(Producto $producto)
    {
        // Verificar si tiene presentaciones o inventarios asociados
        if ($producto->presentaciones()->count() > 0 || 
            $producto->inventarios()->count() > 0) {
            return redirect()->route('productos.index')
                ->with('error', 'No se puede eliminar el producto porque tiene datos asociados.');
        }

        $producto->delete();

        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }
}