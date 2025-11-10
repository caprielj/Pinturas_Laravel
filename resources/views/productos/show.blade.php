@extends('layouts.app')

@section('title', 'Detalles Producto - Paints')

@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('productos.index') }}">Productos</a></li>
            <li class="breadcrumb-item active">{{ $producto->descripcion }}</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-box-seam me-2"></i>
            Detalles del Producto
        </h2>
        <div>
            <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-2"></i>
                Editar
            </a>
            <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Volver
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-info-circle me-2"></i>
                    Información del Producto
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Código SKU</label>
                            <p class="mb-0"><code class="fs-5">{{ $producto->codigo_sku }}</code></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Estado</label>
                            <p class="mb-0">
                                @if($producto->activo)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-danger">Inactivo</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="text-muted small">Descripción</label>
                            <p class="mb-0 fw-bold">{{ $producto->descripcion }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Tamaño</label>
                            <p class="mb-0">{{ $producto->tamano ?? 'No especificado' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-tags me-2"></i>
                    Clasificación
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Categoría</label>
                            <p class="mb-0">
                                @if($producto->categoria)
                                    <span class="badge bg-info fs-6">{{ $producto->categoria->nombre }}</span>
                                @else
                                    Sin categoría
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Marca</label>
                            <p class="mb-0">
                                @if($producto->marca)
                                    <span class="badge bg-secondary fs-6">{{ $producto->marca->nombre }}</span>
                                @else
                                    Sin marca
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            @if($producto->color || $producto->duracion_anios || $producto->extension_m2)
                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-palette me-2"></i>
                        Características Especiales
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if($producto->color)
                                <div class="col-md-12 mb-3">
                                    <label class="text-muted small">Color</label>
                                    <p class="mb-0">{{ $producto->color }}</p>
                                </div>
                            @endif

                            @if($producto->duracion_anios)
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Duración</label>
                                    <p class="mb-0"><strong>{{ $producto->duracion_anios }}</strong> años</p>
                                </div>
                            @endif

                            @if($producto->extension_m2)
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Extensión</label>
                                    <p class="mb-0"><strong>{{ $producto->extension_m2 }}</strong> m²</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-info-circle me-2"></i>
                    Información del Registro
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">ID</label>
                        <p class="mb-0"><code>#{{ $producto->id }}</code></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Fecha de Registro</label>
                        <p class="mb-0">{{ $producto->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="text-muted small">Última Actualización</label>
                        <p class="mb-0">{{ $producto->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <i class="bi bi-gear me-2"></i>
                    Acciones
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil me-2"></i>
                            Editar
                        </a>
                        
                        <button type="button" 
                                class="btn btn-danger btn-sm" 
                                onclick="eliminar()">
                            <i class="bi bi-trash me-2"></i>
                            Eliminar
                        </button>

                        <hr class="my-2">

                        <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left me-2"></i>
                            Volver al Listado
                        </a>
                    </div>

                    <form id="delete-form" 
                          action="{{ route('productos.destroy', $producto->id) }}" 
                          method="POST" 
                          class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function eliminar() {
        if (confirm('¿Estás seguro de eliminar este producto?')) {
            document.getElementById('delete-form').submit();
        }
    }
</script>
@endpush