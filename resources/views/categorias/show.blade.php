{{-- 
    VISTA SHOW - DETALLE DE UNA CATEGORÍA
    Muestra información de la categoría y sus productos relacionados
--}}

{{-- @extends: Hereda la estructura del layout principal --}}
@extends('layouts.app')

{{-- @section: Define el bloque de contenido --}}
@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        {{-- {{ }}: Muestra el nombre de la categoría --}}
        <h2>{{ $categoria->nombre }}</h2>
        <div>
            {{-- route() con parámetro: Genera URL con ID de la categoría --}}
            <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-warning">Editar</a>
            <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            {{-- ?? : Operador null coalescing - Si es null muestra 'Sin descripción' --}}
            <p><strong>Descripción:</strong> {{ $categoria->descripcion ?? 'Sin descripción' }}</p>
            {{-- ->count(): Cuenta elementos de la colección --}}
            <p><strong>Total de productos:</strong> {{ $productos->count() }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Productos</h5>
        </div>
        <div class="card-body">
            {{-- @if: Verifica si hay productos en la colección --}}
            @if($productos->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Descripción</th>
                            <th>Marca</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach: Itera sobre cada producto --}}
                        {{-- $productos: Colección pasada desde el controlador --}}
                        @foreach($productos as $producto)
                            <tr>
                                {{-- $producto->propiedad: Accede a atributos del modelo --}}
                                <td>{{ $producto->codigo_sku }}</td>
                                <td>{{ $producto->descripcion }}</td>
                                {{-- $producto->marca: Relación belongsTo cargada con Eager Loading --}}
                                <td>{{ $producto->marca->nombre ?? 'Sin marca' }}</td>
                                <td>
                                    {{-- Operador ternario: condición ? si_true : si_false --}}
                                    {{-- $producto->activo: booleano (true/false) --}}
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
                <p class="text-center text-muted">No hay productos en esta categoría</p>
            {{-- @endif: Cierra el condicional --}}
            @endif
        </div>
    </div>
</div>
{{-- @endsection: Cierra el bloque de contenido --}}
@endsection