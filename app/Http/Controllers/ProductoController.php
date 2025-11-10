<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Marca;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with(['categoria', 'marca'])
            ->orderBy('descripcion', 'asc')
            ->paginate(10);
        
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('nombre', 'asc')->get();
        $marcas = Marca::where('activa', true)->orderBy('nombre', 'asc')->get();
        
        return view('productos.create', compact('categorias', 'marcas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'marca_id' => 'required|exists:marcas,id',
            'codigo_sku' => 'required|string|max:50|unique:productos,codigo_sku',
            'descripcion' => 'required|string|max:255',
            'tamano' => 'nullable|string|max:40',
            'duracion_anios' => 'nullable|integer|min:0',
            'extension_m2' => 'nullable|numeric|min:0',
            'color' => 'nullable|string|max:60',
        ]);

        Producto::create([
            'categoria_id' => $request->categoria_id,
            'marca_id' => $request->marca_id,
            'codigo_sku' => $request->codigo_sku,
            'descripcion' => $request->descripcion,
            'tamano' => $request->tamano,
            'duracion_anios' => $request->duracion_anios,
            'extension_m2' => $request->extension_m2,
            'color' => $request->color,
            'activo' => $request->has('activo') ? 1 : 0,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    public function show($id)
    {
        $producto = Producto::with(['categoria', 'marca'])->findOrFail($id);
        return view('productos.show', compact('producto'));
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::orderBy('nombre', 'asc')->get();
        $marcas = Marca::where('activa', true)->orderBy('nombre', 'asc')->get();
        
        return view('productos.edit', compact('producto', 'categorias', 'marcas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'marca_id' => 'required|exists:marcas,id',
            'codigo_sku' => 'required|string|max:50|unique:productos,codigo_sku,' . $id,
            'descripcion' => 'required|string|max:255',
            'tamano' => 'nullable|string|max:40',
            'duracion_anios' => 'nullable|integer|min:0',
            'extension_m2' => 'nullable|numeric|min:0',
            'color' => 'nullable|string|max:60',
        ]);

        $producto = Producto::findOrFail($id);
        
        $producto->update([
            'categoria_id' => $request->categoria_id,
            'marca_id' => $request->marca_id,
            'codigo_sku' => $request->codigo_sku,
            'descripcion' => $request->descripcion,
            'tamano' => $request->tamano,
            'duracion_anios' => $request->duracion_anios,
            'extension_m2' => $request->extension_m2,
            'color' => $request->color,
            'activo' => $request->has('activo') ? 1 : 0,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
}