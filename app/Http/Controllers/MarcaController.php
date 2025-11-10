<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    public function index()
    {
        $marcas = Marca::withCount('productos')->orderBy('nombre')->get();
        return view('marcas.index', compact('marcas'));
    }

    public function create()
    {
        return view('marcas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:80|unique:marcas,nombre',
            'activa' => 'boolean',
        ]);

        $data = $request->all();
        if (!isset($data['activa'])) {
            $data['activa'] = true;
        }

        Marca::create($data);

        return redirect()->route('marcas.index')
            ->with('success', 'Marca creada exitosamente');
    }

    public function show(Marca $marca)
    {
        $productos = $marca->productos;
        return view('marcas.show', compact('marca', 'productos'));
    }

    public function edit(Marca $marca)
    {
        return view('marcas.edit', compact('marca'));
    }

    public function update(Request $request, Marca $marca)
    {
        $request->validate([
            'nombre' => 'required|string|max:80|unique:marcas,nombre,' . $marca->id,
            'activa' => 'boolean',
        ]);

        $marca->update($request->all());

        return redirect()->route('marcas.index')
            ->with('success', 'Marca actualizada exitosamente');
    }

    public function destroy(Marca $marca)
    {
        if ($marca->productos()->count() > 0) {
            return redirect()->route('marcas.index')
                ->with('error', 'No se puede eliminar. Tiene productos asociados');
        }

        $marca->delete();

        return redirect()->route('marcas.index')
            ->with('success', 'Marca eliminada exitosamente');
    }
}