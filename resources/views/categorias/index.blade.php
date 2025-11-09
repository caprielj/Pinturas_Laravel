@extends('layouts.app')

@section('title', 'Categorías - Paints')

@section('content')
<div class="container-fluid">
    {{-- Encabezado de la página --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-tags me-2"></i>
            Gestión de Categorías
        </h2>
        {{-- Botón para crear nueva categoría --}}
        <a href="{{ route('categorias.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>
            Nueva Categoría
        </a>
    </div>

    {{-- Card con la tabla --}}
    <div class="card">
        <div class="card-header">
            <i class="bi bi-table me-2"></i>
            Listado de Categorías
        </div>
        <div class="card-body">
            {{-- Tabla responsive --}}
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Cantidad de Productos</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categorias as $categoria)
                            <tr>
                                <td>{{ $categoria->id }}</td>
                                <td>
                                    <strong>{{ $categoria->nombre }}</strong>
                                </td>
                                <td>{{ $categoria->descripcion ?? 'Sin descripción' }}</td>
                                <td>
                                    <span class="badge bg-primary">
                                        <i class="bi bi-box-seam me-1"></i>
                                        {{ $categoria->productos_count ?? 0 }} productos
                                    </span>
                                </td>
                                <td class="text-center">
                                    {{-- Botones de acción --}}
                                    <div class="btn-group" role="group">
                                        {{-- Ver detalles --}}
                                        <a href="{{ route('categorias.show', $categoria) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        
                                        {{-- Editar --}}
                                        <a href="{{ route('categorias.edit', $categoria) }}" 
                                           class="btn btn-sm btn-warning" 
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        
                                        {{-- Eliminar --}}
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="confirmarEliminacion({{ $categoria->id }})"
                                                title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    {{-- Formulario oculto para eliminar --}}
                                    <form id="form-eliminar-{{ $categoria->id }}" 
                                          action="{{ route('categorias.destroy', $categoria) }}" 
                                          method="POST" 
                                          class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            {{-- Mensaje cuando no hay categorías --}}
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                    <p class="text-muted mb-0">No hay categorías registradas</p>
                                    <a href="{{ route('categorias.create') }}" class="btn btn-primary btn-sm mt-2">
                                        <i class="bi bi-plus-circle me-1"></i>
                                        Crear primera categoría
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            @if($categorias->hasPages())
                <div class="mt-3">
                    {{ $categorias->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Información adicional --}}
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Categorías de productos:</strong> Las categorías permiten clasificar los productos 
                para facilitar su búsqueda y organización. Ejemplos: Pinturas de Interior, Pinturas de Exterior, 
                Esmaltes, Impermeabilizantes, Accesorios, Solventes, Barnices.
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    /**
     * Confirmar eliminación de categoría
     * 
     * Muestra un cuadro de confirmación antes de eliminar una categoría.
     * Verifica que no tenga productos asociados.
     * 
     * @param {number} id - ID de la categoría a eliminar
     */
    function confirmarEliminacion(id) {
        if (confirm('¿Estás seguro de eliminar esta categoría?\n\nSe verificará que no tenga productos asociados.\n\nEsta acción no se puede deshacer.')) {
            document.getElementById('form-eliminar-' + id).submit();
        }
    }
</script>
@endpush