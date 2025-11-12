{{-- 
    VISTA INDEX - LISTADO DE CATEGORÍAS
    Muestra todas las categorías en una tabla con opciones CRUD
--}}

{{-- @extends: Hereda la estructura del layout principal --}}
@extends('layouts.app')

{{-- @section: Define el bloque de contenido principal --}}
@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Categorías</h2>
        {{-- {{ route() }}: Genera URL para crear nueva categoría --}}
        <a href="{{ route('categorias.create') }}" class="btn btn-primary">Nueva Categoría</a>
    </div>

    {{-- @if: Condicional - Muestra alerta si existe mensaje de éxito en sesión --}}
    {{-- session('success'): Obtiene mensaje flash de la sesión --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- @if: Muestra alerta de error si existe --}}
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Productos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @forelse: Bucle foreach con caso vacío integrado --}}
                    {{-- $categorias: Variable pasada desde el controlador --}}
                    @forelse($categorias as $categoria)
                        <tr>
                            {{-- {{ }}: Muestra variable escapada (seguro contra XSS) --}}
                            <td>{{ $categoria->id }}</td>
                            <td>{{ $categoria->nombre }}</td>
                            <td>{{ $categoria->descripcion }}</td>
                            <td>
                                {{-- $categoria->productos_count: Contador de relación (withCount) --}}
                                <span class="badge bg-primary">{{ $categoria->productos_count }}</span>
                            </td>
                            <td>
                                {{-- route() con parámetro: Genera /categorias/{id} --}}
                                <a href="{{ route('categorias.show', $categoria) }}" class="btn btn-sm btn-info">Ver</a>
                                <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-sm btn-warning">Editar</a>
                                
                                {{-- Formulario de eliminación con método DELETE --}}
                                <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" class="d-inline">
                                    {{-- @csrf: Token de seguridad --}}
                                    @csrf
                                    {{-- @method('DELETE'): Simula método HTTP DELETE --}}
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('¿Eliminar categoría?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    {{-- @empty: Se ejecuta si $categorias está vacío --}}
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No hay categorías registradas</td>
                        </tr>
                    {{-- @endforelse: Cierra el bloque @forelse --}}
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- @endsection: Cierra el bloque de contenido --}}
@endsection