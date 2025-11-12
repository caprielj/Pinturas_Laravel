{{-- 
    VISTA SHOW - DETALLE DE UNA MARCA
    Muestra información de la marca y sus productos relacionados
--}}

{{-- @extends: Hereda la estructura del layout principal --}}
@extends('layouts.app')

{{-- @section: Define el bloque de contenido --}}
@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        {{-- {{ }}: Muestra el nombre de la marca --}}
        <h2><i class="bi bi-award me-2"></i>{{ $marca->nombre }}</h2>
        <div>
            {{-- route() con parámetro: Genera URL con ID de la marca --}}
            <a href="{{ route('marcas.edit', $marca) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-2"></i>Editar
            </a>
            <a href="{{ route('marcas.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Estado:</strong> 
                {{-- @if: Muestra badge según estado activa/inactiva --}}
                @if($marca->activa)
                    <span class="badge bg-success">
                        <i class="bi bi-check-circle me-1"></i>Activa
                    </span>
                @else
                    <span class="badge bg-danger">
                        <i class="bi bi-x-circle me-1"></i>Inactiva
                    </span>
                @endif
            </p>
            {{-- ->count(): Cuenta elementos de la colección --}}
            <p><strong>Total de productos:</strong> {{ $productos->count() }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5><i class="bi bi-box-seam me-2"></i>Productos</h5>
        </div>
        <div class="card-body">
            {{-- @if: Verifica si hay productos en la colección --}}
            @if($productos->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Descripción</th>
                            <th>Categoría</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach: Itera sobre cada producto --}}
                        @foreach($productos as $producto)
                            <tr>
                                {{-- <code>: Muestra el SKU con estilo de código --}}
                                <td><code>{{ $producto->codigo_sku }}</code></td>
                                <td>{{ $producto->descripcion }}</td>
                                <td>
                                    {{-- @if: Verifica si tiene categoría asociada --}}
                                    @if($producto->categoria)
                                        {{-- $producto->categoria: Relación belongsTo cargada con Eager Loading --}}
                                        <span class="badge bg-info">{{ $producto->categoria->nombre }}</span>
                                    @else
                                        <span class="text-muted">Sin categoría</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- Operador ternario: condición ? si_true : si_false --}}
                                    <span class="badge {{ $producto->activo ? 'bg-success' : 'bg-danger' }}">
                                        {{ $producto->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                            </tr>
                        {{-- @endforeach: Cierra el bucle --}}
                        @endforeach
                    </tbody>
                </table>
            {{-- @else: Si no hay productos --}}
            @else
                <p class="text-center text-muted">No hay productos de esta marca</p>
            {{-- @endif: Cierra el condicional --}}
            @endif
        </div>
    </div>
</div>
{{-- @endsection: Cierra el bloque de contenido --}}
@endsection