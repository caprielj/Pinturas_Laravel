@extends('layouts.app')

@section('title', 'Detalles de la Marca - Paints')

@section('content')
<div class="container-fluid">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('marcas.index') }}">Marcas</a></li>
            <li class="breadcrumb-item active">{{ $marca->nombre }}</li>
        </ol>
    </nav>

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-award me-2"></i>
            Detalles de la Marca
        </h2>
        <div>
            <a href="{{ route('marcas.edit', $marca) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-2"></i>
                Editar
            </a>
            <a href="{{ route('marcas.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Volver
            </a>
        </div>
    </div>

    <div class="row">
        {{-- Información Principal --}}
        <div class="col-lg-8">
            {{-- Información de la Marca --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-info-circle me-2"></i>
                    Información de la Marca
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Nombre</label>
                            <p class="mb-0 fw-bold fs-4">{{ $marca->nombre }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Estado</label>
                            <p class="mb-0">
                                @if($marca->activa)
                                    <span class="badge bg-success fs-6">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Activa
                                    </span>
                                @else
                                    <span class="badge bg-danger fs-6">
                                        <i class="bi bi-x-circle me-1"></i>
                                        Inactiva
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Productos de esta Marca --}}
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-box-seam me-2"></i>
                    Productos de esta Marca
                </div>
                <div class="card-body">
                    @if($productos && $productos->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>SKU</th>
                                        <th>Descripción</th>
                                        <th>Categoría</th>
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
                                                @if($producto->categoria)
                                                    <span class="badge bg-info">{{ $producto->categoria->nombre }}</span>
                                                @else
                                                    <span class="text-muted">Sin categoría</span>
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
                            <p class="mb-0">No hay productos de esta marca</p>
                            <small>Los productos de esta marca aparecerán aquí</small>
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
                        <label class="text-muted small">ID de la Marca</label>
                        <p class="mb-0">
                            <code>#{{ $marca->id }}</code>
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
                        <strong>{{ $marca->cantidadProductos() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Estado</span>
                        <strong>{{ $marca->activa ? 'Activa' : 'Inactiva' }}</strong>
                    </div>
                    <hr class="my-2">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Estadísticas de la marca
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
                        <a href="{{ route('marcas.edit', $marca) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil me-2"></i>
                            Editar Marca
                        </a>
                        
                        <button type="button" 
                                class="btn btn-danger btn-sm" 
                                onclick="confirmarEliminacion()">
                            <i class="bi bi-trash me-2"></i>
                            Eliminar Marca
                        </button>

                        <hr class="my-2">

                        <a href="{{ route('marcas.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left me-2"></i>
                            Volver al Listado
                        </a>
                    </div>

                    {{-- Formulario oculto para eliminar --}}
                    <form id="form-eliminar" 
                          action="{{ route('marcas.destroy', $marca) }}" 
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
     * Confirmar eliminación de la marca
     */
    function confirmarEliminacion() {
        if (confirm('¿Estás seguro de eliminar esta marca?\n\nSe verificará que no tenga productos asociados.\n\nEsta acción no se puede deshacer.')) {
            document.getElementById('form-eliminar').submit();
        }
    }
</script>
@endpush