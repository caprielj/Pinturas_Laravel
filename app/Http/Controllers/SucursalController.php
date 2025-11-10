<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    public function index()
    {
        $sucursales = Sucursal::orderBy('nombre', 'asc')->paginate(10);
        return view('sucursales.index', compact('sucursales'));
    }

    public function create()
    {
        return view('sucursales.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:120|unique:sucursales,nombre',
            'direccion' => 'nullable|string|max:255',
            'gps_lat' => 'nullable|numeric|between:-90,90',
            'gps_lng' => 'nullable|numeric|between:-180,180',
            'telefono' => 'nullable|string|max:30',
        ]);

        Sucursal::create([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'gps_lat' => $request->gps_lat,
            'gps_lng' => $request->gps_lng,
            'telefono' => $request->telefono,
            'activa' => $request->has('activa') ? 1 : 0,
        ]);

        return redirect()->route('sucursales.index')->with('success', 'Sucursal creada exitosamente.');
    }

    public function show($id)
    {
        $sucursal = Sucursal::findOrFail($id);
        return view('sucursales.show', compact('sucursal'));
    }

    public function edit($id)
    {
        $sucursal = Sucursal::findOrFail($id);
        return view('sucursales.edit', compact('sucursal'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:120|unique:sucursales,nombre,' . $id,
            'direccion' => 'nullable|string|max:255',
            'gps_lat' => 'nullable|numeric|between:-90,90',
            'gps_lng' => 'nullable|numeric|between:-180,180',
            'telefono' => 'nullable|string|max:30',
        ]);

        $sucursal = Sucursal::findOrFail($id);
        
        $sucursal->update([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'gps_lat' => $request->gps_lat,
            'gps_lng' => $request->gps_lng,
            'telefono' => $request->telefono,
            'activa' => $request->has('activa') ? 1 : 0,
        ]);

        return redirect()->route('sucursales.index')->with('success', 'Sucursal actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $sucursal = Sucursal::findOrFail($id);
        $sucursal->delete();

        return redirect()->route('sucursales.index')->with('success', 'Sucursal eliminada exitosamente.');
    }
}