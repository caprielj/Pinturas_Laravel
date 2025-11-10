@extends('layouts.app')

@section('title', 'Productos - Paints')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-box-seam me-2"></i>
            Productos
        </h2>
        <a href="{{ route('productos.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>
            Nuevo Producto
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <i class="bi bi-table me-2"></i>
            Listado de Productos
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>SKU</th>
                            <th>Descripción</th>
                            <th>Categoría</th>
                            <th>Marca</th>
                            <th>Color</th>
                            <th>Tamaño</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productos as $producto)
                            <tr>
                                <td>{{ $producto->id }}</td>
                                <td><code>{{ $producto->codigo_sku }}</code></td>
                                <td>
                                    <strong>{{ $producto->descripcion }}</strong>
                                    @if($producto->duracion_anios || $producto->extension_m2)
                                        <br>
                                        <small class="text-muted">
                                            @if($producto->duracion_anios)
                                                {{ $producto->duracion_anios }} años
                                            @endif
                                            @if($producto->extension_m2)
                                                / {{ $producto->extension_m2 }} m²
                                            @endif
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    @if($producto->categoria)
                                        <span class="badge bg-info">{{ $producto->categoria->nombre }}</span>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if($producto->marca)
                                        <span class="badge bg-secondary">{{ $producto->marca->nombre }}</span>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $producto->color ?? 'N/A' }}</td>
                                <td>{{ $producto->tamano ?? 'N/A' }}</td>
                                <td>
                                    @if($producto->activo)
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('productos.show', $producto->id) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="Ver">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('productos.edit', $producto->id) }}" 
                                           class="btn btn-sm btn-warning" 
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="eliminar({{ $producto->id }})"
                                                title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <form id="delete-form-{{ $producto->id }}" 
                                          action="{{ route('productos.destroy', $producto->id) }}" 
                                          method="POST" 
                                          class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                    <p class="text-muted mb-0">No hay productos registrados</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($productos->hasPages())
                <div class="mt-3">
                    {{ $productos->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function eliminar(id) {
        if (confirm('¿Estás seguro de eliminar este producto?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endpush