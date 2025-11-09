@extends('layouts.app')

@section('title', 'Marcas - Paints')

@section('content')
<div class="container-fluid">
    {{-- Encabezado de la página --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-award me-2"></i>
            Gestión de Marcas
        </h2>
        {{-- Botón para crear nueva marca --}}
        <a href="{{ route('marcas.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>
            Nueva Marca
        </a>
    </div>

    {{-- Card con la tabla --}}
    <div class="card">
        <div class="card-header">
            <i class="bi bi-table me-2"></i>
            Listado de Marcas
        </div>
        <div class="card-body">
            {{-- Tabla responsive --}}
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th>Cantidad de Productos</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($marcas as $marca)
                            <tr>
                                <td>{{ $marca->id }}</td>
                                <td>
                                    <strong>{{ $marca->nombre }}</strong>
                                </td>
                                <td>
                                    @if($marca->activa)
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>
                                            Activa
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="bi bi-x-circle me-1"></i>
                                            Inactiva
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-primary">
                                        <i class="bi bi-box-seam me-1"></i>
                                        {{ $marca->productos_count ?? 0 }} productos
                                    </span>
                                </td>
                                <td class="text-center">
                                    {{-- Botones de acción --}}
                                    <div class="btn-group" role="group">
                                        {{-- Ver detalles --}}
                                        <a href="{{ route('marcas.show', $marca) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        
                                        {{-- Editar --}}
                                        <a href="{{ route('marcas.edit', $marca) }}" 
                                           class="btn btn-sm btn-warning" 
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        
                                        {{-- Eliminar --}}
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="confirmarEliminacion({{ $marca->id }})"
                                                title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    {{-- Formulario oculto para eliminar --}}
                                    <form id="form-eliminar-{{ $marca->id }}" 
                                          action="{{ route('marcas.destroy', $marca) }}" 
                                          method="POST" 
                                          class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            {{-- Mensaje cuando no hay marcas --}}
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                    <p class="text-muted mb-0">No hay marcas registradas</p>
                                    <a href="{{ route('marcas.create') }}" class="btn btn-primary btn-sm mt-2">
                                        <i class="bi bi-plus-circle me-1"></i>
                                        Crear primera marca
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            @if($marcas->hasPages())
                <div class="mt-3">
                    {{ $marcas->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Información adicional --}}
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Marcas de productos:</strong> Las marcas representan a los fabricantes de los productos. 
                Solo las marcas activas aparecerán disponibles al crear nuevos productos. 
                Ejemplos: Sherwin Williams, Comex, Berel, Pintuco.
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    /**
     * Confirmar eliminación de marca
     * 
     * Muestra un cuadro de confirmación antes de eliminar una marca.
     * Verifica que no tenga productos asociados.
     * 
     * @param {number} id - ID de la marca a eliminar
     */
    function confirmarEliminacion(id) {
        if (confirm('¿Estás seguro de eliminar esta marca?\n\nSe verificará que no tenga productos asociados.\n\nEsta acción no se puede deshacer.')) {
            document.getElementById('form-eliminar-' + id).submit();
        }
    }
</script>
@endpush