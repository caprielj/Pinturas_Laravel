@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><i class="bi bi-award me-2"></i>{{ $marca->nombre }}</h2>
        <div>
            <a href="{{ route('marcas.edit', $marca) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-2"></i>Editar
            </a>
            <a href="{{ route('marcas.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Estado:</strong> 
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
            <p><strong>Total de productos:</strong> {{ $productos->count() }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5><i class="bi bi-box-seam me-2"></i>Productos</h5>
        </div>
        <div class="card-body">
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
                        @foreach($productos as $producto)
                            <tr>
                                <td><code>{{ $producto->codigo_sku }}</code></td>
                                <td>{{ $producto->descripcion }}</td>
                                <td>
                                    @if($producto->categoria)
                                        <span class="badge bg-info">{{ $producto->categoria->nombre }}</span>
                                    @else
                                        <span class="text-muted">Sin categoría</span>
                                    @endif
                                </td>
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
                <p class="text-center text-muted">No hay productos de esta marca</p>
            @endif
        </div>
    </div>
</div>
@endsection