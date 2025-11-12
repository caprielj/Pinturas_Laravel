{{-- 
    VISTA INDEX - LISTADO DE MARCAS
    Muestra todas las marcas en tabla con estado (activa/inactiva) y opciones CRUD
--}}

{{-- @extends: Hereda la estructura del layout principal --}}
@extends('layouts.app')

{{-- @section: Define el bloque de contenido principal --}}
@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><i class="bi bi-award me-2"></i>Marcas</h2>
        {{-- {{ route() }}: Genera URL para crear nueva marca --}}
        <a href="{{ route('marcas.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Nueva Marca
        </a>
    </div>

    {{-- @if: Muestra alerta si existe mensaje de éxito en sesión --}}
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
                        <th>Estado</th>
                        <th>Productos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @forelse: Bucle foreach con caso vacío integrado --}}
                    {{-- $marcas: Variable pasada desde el controlador --}}
                    @forelse($marcas as $marca)
                        <tr>
                            {{-- {{ }}: Muestra variable escapada (seguro contra XSS) --}}
                            <td>{{ $marca->id }}</td>
                            <td>{{ $marca->nombre }}</td>
                            <td>
                                {{-- @if: Muestra badge según estado activo/inactivo --}}
                                @if($marca->activa)
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>Activa
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="bi bi-x-circle me-1"></i>Inactiva
                                    </span>
                                @endif
                            </td>
                            <td>
                                {{-- $marca->productos_count: Contador de relación (withCount) --}}
                                <span class="badge bg-primary">{{ $marca->productos_count }}</span>
                            </td>
                            <td>
                                {{-- route() con parámetro: Genera /marcas/{id} --}}
                                <a href="{{ route('marcas.show', $marca) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('marcas.edit', $marca) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                {{-- Formulario de eliminación con método DELETE --}}
                                <form action="{{ route('marcas.destroy', $marca) }}" method="POST" class="d-inline">
                                    {{-- @csrf: Token de seguridad --}}
                                    @csrf
                                    {{-- @method('DELETE'): Simula método HTTP DELETE --}}
                                    @method('DELETE')
                                    {{-- onclick: Confirmación JavaScript antes de eliminar --}}
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('¿Eliminar marca?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    {{-- @empty: Se ejecuta si $marcas está vacío --}}
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No hay marcas registradas</td>
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