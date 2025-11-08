@extends('layouts.app')

@section('title', 'Proveedores - Paints')

@section('content')
<div class="container-fluid">
    {{-- Encabezado de la página --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-truck me-2"></i>
            Gestión de Proveedores
        </h2>
        {{-- Botón para crear nuevo proveedor --}}
        <a href="{{ route('proveedores.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>
            Nuevo Proveedor
        </a>
    </div>

    {{-- Card con la tabla --}}
    <div class="card">
        <div class="card-header">
            <i class="bi bi-table me-2"></i>
            Listado de Proveedores
        </div>
        <div class="card-body">
            {{-- Tabla responsive --}}
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Razón Social</th>
                            <th>NIT</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Contacto</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($proveedores as $proveedor)
                            <tr>
                                <td>{{ $proveedor->id }}</td>
                                <td>
                                    <strong>{{ $proveedor->nombre }}</strong>
                                </td>
                                <td>{{ $proveedor->razon_social ?? 'N/A' }}</td>
                                <td>{{ $proveedor->nit ?? 'N/A' }}</td>
                                <td>
                                    <i class="bi bi-telephone me-1"></i>
                                    {{ $proveedor->telefono ?? 'N/A' }}
                                </td>
                                <td>
                                    @if($proveedor->email)
                                        <i class="bi bi-envelope me-1"></i>
                                        {{ $proveedor->email }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $proveedor->contacto_principal ?? 'N/A' }}</td>
                                <td>
                                    @if($proveedor->activo)
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>
                                            Activo
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="bi bi-x-circle me-1"></i>
                                            Inactivo
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{-- Botones de acción --}}
                                    <div class="btn-group" role="group">
                                        {{-- Ver detalles --}}
                                        <a href="{{ route('proveedores.show', $proveedor) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        
                                        {{-- Editar --}}
                                        <a href="{{ route('proveedores.edit', $proveedor) }}" 
                                           class="btn btn-sm btn-warning" 
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        
                                        {{-- Eliminar --}}
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="confirmarEliminacion({{ $proveedor->id }})"
                                                title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    {{-- Formulario oculto para eliminar --}}
                                    <form id="form-eliminar-{{ $proveedor->id }}" 
                                          action="{{ route('proveedores.destroy', $proveedor) }}" 
                                          method="POST" 
                                          class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            {{-- Mensaje cuando no hay proveedores --}}
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                    <p class="text-muted mb-0">No hay proveedores registrados</p>
                                    <a href="{{ route('proveedores.create') }}" class="btn btn-primary btn-sm mt-2">
                                        <i class="bi bi-plus-circle me-1"></i>
                                        Crear primer proveedor
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            @if($proveedores->hasPages())
                <div class="mt-3">
                    {{ $proveedores->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    /**
     * Confirmar eliminación de proveedor
     * 
     * Muestra un cuadro de confirmación antes de eliminar un proveedor.
     * 
     * @param {number} id - ID del proveedor a eliminar
     */
    function confirmarEliminacion(id) {
        if (confirm('¿Estás seguro de eliminar este proveedor?\n\nSe verificará que no tenga órdenes de compra asociadas.\n\nEsta acción no se puede deshacer.')) {
            document.getElementById('form-eliminar-' + id).submit();
        }
    }
</script>
@endpush