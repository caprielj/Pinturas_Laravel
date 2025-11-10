<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with(['rol', 'sucursal'])->orderBy('nombre')->get();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = Rol::orderBy('nombre')->get();
        $sucursales = Sucursal::where('activa', true)->orderBy('nombre')->get();
        return view('usuarios.create', compact('roles', 'sucursales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:120',
            'dpi' => 'required|string|max:20|unique:usuarios,dpi',
            'email' => 'required|email|max:150|unique:usuarios,email',
            'password' => 'required|string|min:6|confirmed',
            'rol_id' => 'required|exists:roles,id',
            'sucursal_id' => 'nullable|exists:sucursales,id',
            'activo' => 'nullable|boolean',
        ]);

        $data = $request->except(['password', 'password_confirmation']);
        $data['password_hash'] = Hash::make($request->password);
        $data['activo'] = $request->has('activo') ? 1 : 0;

        Usuario::create($data);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado exitosamente');
    }

    public function show($id)
    {
        $usuario = Usuario::with(['rol', 'sucursal'])->findOrFail($id);
        return view('usuarios.show', compact('usuario'));
    }

    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        $roles = Rol::orderBy('nombre')->get();
        $sucursales = Sucursal::where('activa', true)->orderBy('nombre')->get();
        return view('usuarios.edit', compact('usuario', 'roles', 'sucursales'));
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        
        $request->validate([
            'nombre' => 'required|string|max:120',
            'dpi' => 'required|string|max:20|unique:usuarios,dpi,' . $usuario->id,
            'email' => 'required|email|max:150|unique:usuarios,email,' . $usuario->id,
            'password' => 'nullable|string|min:6|confirmed',
            'rol_id' => 'required|exists:roles,id',
            'sucursal_id' => 'nullable|exists:sucursales,id',
            'activo' => 'nullable|boolean',
        ]);

        $data = $request->except(['password', 'password_confirmation']);
        
        if ($request->filled('password')) {
            $data['password_hash'] = Hash::make($request->password);
        }
        
        $data['activo'] = $request->has('activo') ? 1 : 0;

        $usuario->update($data);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado exitosamente');
    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        
        // Comentado temporalmente - se activará en Fase 2
        // if ($usuario->facturas()->count() > 0 || 
        //     $usuario->cotizaciones()->count() > 0 || 
        //     $usuario->ordenesCompra()->count() > 0) {
        //     return redirect()->route('usuarios.index')
        //         ->with('error', 'No se puede eliminar. Tiene transacciones asociadas');
        // }

        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado exitosamente');
    }
}