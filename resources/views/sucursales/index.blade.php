@extends('layouts.app')

@section('title', 'Sucursales - Paints')

@section('content')
<div class="container-fluid">
    {{-- Encabezado de la página --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-shop me-2"></i>
            Gestión de Sucursales
        </h2>
        {{-- Botón para crear nueva sucursal --}}
        <a href="{{ route('sucursales.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>
            Nueva Sucursal
        </a>
    </div>

    {{-- Card con la tabla --}}
    <div class="card">
        <div class="card-header">
            <i class="bi bi-table me-2"></i>
            Listado de Sucursales
        </div>
        <div class="card-body">
            {{-- Tabla responsive --}}
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Coordenadas GPS</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sucursales as $sucursal)
                            <tr>
                                <td>{{ $sucursal->id }}</td>
                                <td>
                                    <strong>{{ $sucursal->nombre }}</strong>
                                </td>
                                <td>
                                    @if($sucursal->direccion)
                                        <i class="bi bi-geo-alt me-1"></i>
                                        {{ Str::limit($sucursal->direccion, 40) }}
                                    @else
                                        <span class="text-muted">No registrada</span>
                                    @endif
                                </td>
                                <td>
                                    @if($sucursal->telefono)
                                        <i class="bi bi-telephone me-1"></i>
                                        {{ $sucursal->telefono }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($sucursal->gps_lat && $sucursal->gps_lng)
                                        <a href="https://www.google.com/maps?q={{ $sucursal->gps_lat }},{{ $sucursal->gps_lng }}" 
                                           target="_blank" 
                                           class="btn btn-sm btn-outline-primary"
                                           title="Ver en mapa">
                                            <i class="bi bi-map"></i>
                                            Ver mapa
                                        </a>
                                    @else
                                        <span class="text-muted">Sin GPS</span>
                                    @endif
                                </td>
                                <td>
                                    @if($sucursal->activa)
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
                                <td class="text-center">
                                    {{-- Botones de acción --}}
                                    <div class="btn-group" role="group">
                                        {{-- Ver detalles --}}
                                        <a href="{{ route('sucursales.show', $sucursal) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        
                                        {{-- Editar --}}
                                        <a href="{{ route('sucursales.edit', $sucursal) }}" 
                                           class="btn btn-sm btn-warning" 
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        
                                        {{-- Eliminar --}}
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="confirmarEliminacion({{ $sucursal->id }})"
                                                title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    {{-- Formulario oculto para eliminar --}}
                                    <form id="form-eliminar-{{ $sucursal->id }}" 
                                          action="{{ route('sucursales.destroy', $sucursal) }}" 
                                          method="POST" 
                                          class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            {{-- Mensaje cuando no hay sucursales --}}
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                    <p class="text-muted mb-0">No hay sucursales registradas</p>
                                    <a href="{{ route('sucursales.create') }}" class="btn btn-primary btn-sm mt-2">
                                        <i class="bi bi-plus-circle me-1"></i>
                                        Crear primera sucursal
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            @if($sucursales->hasPages())
                <div class="mt-3">
                    {{ $sucursales->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Información adicional --}}
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Información:</strong> Las sucursales son las diferentes tiendas de la cadena "Paints". 
                Cada sucursal tiene su propio inventario y puede realizar ventas independientes.
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    /**
     * Confirmar eliminación de sucursal
     * 
     * Muestra un cuadro de confirmación antes de eliminar una sucursal.
     * Verifica que no tenga usuarios, inventarios o facturas asociadas.
     * 
     * @param {number} id - ID de la sucursal a eliminar
     */
    function confirmarEliminacion(id) {
        if (confirm('¿Estás seguro de eliminar esta sucursal?\n\nSe verificará que no tenga:\n- Usuarios asignados\n- Inventarios\n- Facturas\n\nEsta acción no se puede deshacer.')) {
            document.getElementById('form-eliminar-' + id).submit();
        }
    }
</script>
@endpush