@extends('layouts.app')

@section('title', 'Detalles de la Categoría - Paints')

@section('content')
<div class="container-fluid">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categorias.index') }}">Categorías</a></li>
            <li class="breadcrumb-item active">{{ $categoria->nombre }}</li>
        </ol>
    </nav>

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-tag me-2"></i>
            Detalles de la Categoría
        </h2>
        <div>
            <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-2"></i>
                Editar
            </a>
            <a href="{{ route('categorias.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Volver
            </a>
        </div>
    </div>

    <div class="row">
        {{-- Información Principal --}}
        <div class="col-lg-8">
            {{-- Información de la Categoría --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-info-circle me-2"></i>
                    Información de la Categoría
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="text-muted small">Nombre</label>
                            <p class="mb-0 fw-bold fs-4">{{ $categoria->nombre }}</p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="text-muted small">Descripción</label>
                            <p class="mb-0">{{ $categoria->descripcion ?? 'Sin descripción' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Productos de esta Categoría --}}
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-box-seam me-2"></i>
                    Productos de esta Categoría
                </div>
                <div class="card-body">
                    @if($productos && $productos->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>SKU</th>
                                        <th>Descripción</th>
                                        <th>Marca</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productos as $producto)
                                        <tr>
                                            <td><code>{{ $producto->codigo_sku }}</code></td>
                                            <td>{{ $producto->descripcion }}</td>
                                            <td>
                                                @if($producto->marca)
                                                    <span class="badge bg-secondary">{{ $producto->marca->nombre }}</span>
                                                @else
                                                    <span class="text-muted">Sin marca</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($producto->activo)
                                                    <span class="badge bg-success">Activo</span>
                                                @else
                                                    <span class="badge bg-danger">Inactivo</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('productos.show', $producto) }}" 
                                                   class="btn btn-sm btn-info"
                                                   title="Ver producto">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Paginación --}}
                        @if($productos->hasPages())
                            <div class="mt-3">
                                {{ $productos->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-box-seam fs-1 d-block mb-2"></i>
                            <p class="mb-0">No hay productos en esta categoría</p>
                            <small>Los productos clasificados en esta categoría aparecerán aquí</small>
                        </div>
                    @endif
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
                        <label class="text-muted small">ID de la Categoría</label>
                        <p class="mb-0">
                            <code>#{{ $categoria->id }}</code>
                        </p>
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
                        <span class="text-muted">Total de Productos</span>
                        <strong>{{ $categoria->cantidadProductos() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Productos Activos</span>
                        <strong>{{ $categoria->productosActivos()->count() }}</strong>
                    </div>
                    <hr class="my-2">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Estadísticas de la categoría
                    </small>
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
                        <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil me-2"></i>
                            Editar Categoría
                        </a>
                        
                        <button type="button" 
                                class="btn btn-danger btn-sm" 
                                onclick="confirmarEliminacion()">
                            <i class="bi bi-trash me-2"></i>
                            Eliminar Categoría
                        </button>

                        <hr class="my-2">

                        <a href="{{ route('categorias.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left me-2"></i>
                            Volver al Listado
                        </a>
                    </div>

                    {{-- Formulario oculto para eliminar --}}
                    <form id="form-eliminar" 
                          action="{{ route('categorias.destroy', $categoria) }}" 
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
     * Confirmar eliminación de la categoría
     */
    function confirmarEliminacion() {
        if (confirm('¿Estás seguro de eliminar esta categoría?\n\nSe verificará que no tenga productos asociados.\n\nEsta acción no se puede deshacer.')) {
            document.getElementById('form-eliminar').submit();
        }
    }
</script>
@endpush