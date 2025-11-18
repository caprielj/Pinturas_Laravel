<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Marca;
use Illuminate\Http\Request;

/**
 * Controlador HomeController
 *
 * Maneja la página pública de inicio donde los clientes
 * pueden ver el catálogo de productos sin necesidad de login
 */
class HomeController extends Controller
{
    /**
     * Muestra la página de inicio pública con catálogo de productos
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Query base: productos activos con sus relaciones
        $query = Producto::with(['categoria', 'marca'])
            ->where('activo', 1);

        // Filtro por categoría (si se selecciona)
        if ($request->filled('categoria')) {
            $query->where('categoria_id', $request->categoria);
        }

        // Filtro por marca (si se selecciona)
        if ($request->filled('marca')) {
            $query->where('marca_id', $request->marca);
        }

        // Búsqueda por texto (en descripción o código SKU)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('descripcion', 'LIKE', '%' . $search . '%')
                  ->orWhere('codigo_sku', 'LIKE', '%' . $search . '%');
            });
        }

        // Obtener productos paginados (12 por página)
        $productos = $query->orderBy('descripcion')->paginate(12);

        // Obtener todas las categorías y marcas para los filtros
        $categorias = Categoria::orderBy('nombre')->get();

        $marcas = Marca::where('activa', true)
            ->orderBy('nombre')
            ->get();

        return view('welcome', compact('productos', 'categorias', 'marcas'));
    }
}
