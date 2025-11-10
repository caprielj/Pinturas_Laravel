@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>{{ $categoria->nombre }}</h2>
        <div>
            <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-warning">Editar</a>
            <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Descripción:</strong> {{ $categoria->descripcion ?? 'Sin descripción' }}</p>
            <p><strong>Total de productos:</strong> {{ $productos->count() }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Productos</h5>
        </div>
        <div class="card-body">
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
                        @foreach($productos as $producto)
                            <tr>
                                <td>{{ $producto->codigo_sku }}</td>
                                <td>{{ $producto->descripcion }}</td>
                                <td>{{ $producto->marca->nombre ?? 'Sin marca' }}</td>
                                <td>
                                    <span class="badge {{ $producto->activo ? 'bg-success' : 'bg-danger' }}">
                                        {{ $producto->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center text-muted">No hay productos en esta categoría</p>
            @endif
        </div>
    </div>
</div>
@endsection