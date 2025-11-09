@extends('layouts.app')

@section('title', 'Detalles del Producto - Paints')

@section('content')
<div class="container-fluid">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('productos.index') }}">Productos</a></li>
            <li class="breadcrumb-item active">{{ $producto->descripcion }}</li>
        </ol>
    </nav>

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-box-seam me-2"></i>
            Detalles del Producto
        </h2>
        <div>
            <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning">
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
        {{-- Información Principal --}}
        <div class="col-lg-8">
            {{-- Información Básica --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-info-circle me-2"></i>
                    Información Básica
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Código SKU</label>
                            <p class="mb-0">
                                <code class="fs-5">{{ $producto->codigo_sku }}</code>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Estado</label>
                            <p class="mb-0">
                                @if($producto->activo)
                                    <span class="badge bg-success fs-6">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Activo
                                    </span>
                                @else
                                    <span class="badge bg-danger fs-6">
                                        <i class="bi bi-x-circle me-1"></i>
                                        Inactivo
                                    </span>
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

            {{-- Clasificación --}}
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
                                    <span class="badge bg-info fs-6">
                                        {{ $producto->categoria->nombre }}
                                    </span>
                                @else
                                    <span class="text-muted">Sin categoría</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Marca</label>
                            <p class="mb-0">
                                @if($producto->marca)
                                    <span class="badge bg-secondary fs-6">
                                        {{ $producto->marca->nombre }}
                                    </span>
                                @else
                                    <span class="text-muted">Sin marca</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Características Especiales --}}
            @if($producto->color || $producto->duracion_anios || $producto->extension_m2)
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="bi bi-palette me-2"></i>
                        Características Especiales
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if($producto->color)
                                <div class="col-md-12 mb-3">
                                    <label class="text-muted small">Color</label>
                                    <p class="mb-0">
                                        <span class="badge" style="background-color: {{ $producto->color }}; color: #fff; font-size: 1rem; padding: 8px 12px;">
                                            {{ $producto->color }}
                                        </span>
                                    </p>
                                </div>
                            @endif

                            @if($producto->duracion_anios)
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Duración</label>
                                    <p class="mb-0">
                                        <i class="bi bi-clock me-1"></i>
                                        <strong>{{ $producto->duracion_anios }}</strong> años
                                    </p>
                                </div>
                            @endif

                            @if($producto->extension_m2)
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Extensión</label>
                                    <p class="mb-0">
                                        <i class="bi bi-rulers me-1"></i>
                                        <strong>{{ $producto->extension_m2 }}</strong> m²
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            {{-- Presentaciones (placeholder) --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-bag me-2"></i>
                    Presentaciones Disponibles
                </div>
                <div class="card-body">
                    @if($producto->presentaciones && $producto->presentaciones->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Presentación</th>
                                        <th>Unidad Base</th>
                                        <th>Factor Galón</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($producto->presentaciones as $presentacion)
                                        <tr>
                                            <td>{{ $presentacion->nombre }}</td>
                                            <td>{{ $presentacion->unidad_base }}</td>
                                            <td>{{ $presentacion->factor_galon }}</td>
                                            <td>
                                                @if($presentacion->pivot->activo)
                                                    <span class="badge bg-success">Activa</span>
                                                @else
                                                    <span class="badge bg-danger">Inactiva</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-bag-x fs-1 d-block mb-2"></i>
                            <p class="mb-0">No hay presentaciones configuradas</p>
                            <small>Las presentaciones de venta aparecerán aquí</small>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Inventario por Sucursal (placeholder) --}}
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-box me-2"></i>
                    Inventario por Sucursal
                </div>
                <div class="card-body">
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-box fs-1 d-block mb-2"></i>
                        <p class="mb-0">No hay inventario registrado</p>
                        <small>El inventario de este producto en cada sucursal aparecerá aquí</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            {{-- Información del Registro --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-info-circle me-2"></i>
                    Información del Registro
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">ID del Producto</label>
                        <p class="mb-0">
                            <code>#{{ $producto->id }}</code>
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Fecha de Registro</label>
                        <p class="mb-0">
                            <i class="bi bi-calendar me-1"></i>
                            {{ $producto->created_at->format('d/m/Y') }}
                        </p>
                        <small class="text-muted">{{ $producto->created_at->format('H:i') }}</small>
                    </div>

                    <div>
                        <label class="text-muted small">Última Actualización</label>
                        <p class="mb-0">
                            <i class="bi bi-clock me-1"></i>
                            {{ $producto->updated_at->format('d/m/Y') }}
                        </p>
                        <small class="text-muted">{{ $producto->updated_at->format('H:i') }}</small>
                    </div>
                </div>
            </div>

            {{-- Estadísticas --}}
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-graph-up me-2"></i>
                    Estadísticas
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Presentaciones</span>
                        <strong>{{ $producto->presentaciones ? $producto->presentaciones->count() : 0 }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">En Inventario</span>
                        <strong>0</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Ventas Totales</span>
                        <strong>0</strong>
                    </div>
                    <hr class="my-2">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Estadísticas del producto
                    </small>
                </div>
            </div>

            {{-- Tipo de Producto --}}
            <div class="card mb-3">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-tag me-2"></i>
                    Tipo de Producto
                </div>
                <div class="card-body">
                    @if($producto->tieneDuracionYExtension())
                        <div class="alert alert-success mb-0">
                            <i class="bi bi-paint-bucket me-2"></i>
                            <strong>Pintura o Barniz</strong><br>
                            <small>Este producto tiene información de duración y cobertura</small>
                        </div>
                    @else
                        <p class="mb-0">
                            <i class="bi bi-box me-2"></i>
                            Producto General
                        </p>
                    @endif
                </div>
            </div>

            {{-- Acciones --}}
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-gear me-2"></i>
                    Acciones
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil me-2"></i>
                            Editar Producto
                        </a>
                        
                        <button type="button" 
                                class="btn btn-danger btn-sm" 
                                onclick="confirmarEliminacion()">
                            <i class="bi bi-trash me-2"></i>
                            Eliminar Producto
                        </button>

                        <hr class="my-2">

                        <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left me-2"></i>
                            Volver al Listado
                        </a>
                    </div>

                    {{-- Formulario oculto para eliminar --}}
                    <form id="form-eliminar" 
                          action="{{ route('productos.destroy', $producto) }}" 
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
    /**
     * Confirmar eliminación del producto
     */
    function confirmarEliminacion() {
        if (confirm('¿Estás seguro de eliminar este producto?\n\nSe verificará que no tenga:\n- Presentaciones asociadas\n- Inventario en sucursales\n- Ventas registradas\n\nEsta acción no se puede deshacer.')) {
            document.getElementById('form-eliminar').submit();
        }
    }
</script>
@endpush