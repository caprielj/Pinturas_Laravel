@extends('layouts.app')

@section('title', 'Clientes - Paints')

@section('content')
<div class="container-fluid">
    {{-- Encabezado de la página --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-people me-2"></i>
            Gestión de Clientes
        </h2>
        {{-- Botón para crear nuevo cliente --}}
        <a href="{{ route('clientes.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>
            Nuevo Cliente
        </a>
    </div>

    {{-- Card con la tabla --}}
    <div class="card">
        <div class="card-header">
            <i class="bi bi-table me-2"></i>
            Listado de Clientes
        </div>
        <div class="card-body">
            {{-- Tabla responsive --}}
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>NIT</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Verificado</th>
                            <th>Promociones</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clientes as $cliente)
                            <tr>
                                <td>{{ $cliente->id }}</td>
                                <td>
                                    <strong>{{ $cliente->nombre }}</strong>
                                </td>
                                <td>{{ $cliente->nit ?? 'N/A' }}</td>
                                <td>
                                    <i class="bi bi-envelope me-1"></i>
                                    {{ $cliente->email }}
                                </td>
                                <td>
                                    <i class="bi bi-telephone me-1"></i>
                                    {{ $cliente->telefono ?? 'N/A' }}
                                </td>
                                <td>
                                    @if($cliente->verificado)
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>
                                            Verificado
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            <i class="bi bi-clock me-1"></i>
                                            Pendiente
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($cliente->opt_in_promos)
                                        <span class="badge bg-info">
                                            <i class="bi bi-bell me-1"></i>
                                            Sí
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">No</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{-- Botones de acción --}}
                                    <div class="btn-group" role="group">
                                        {{-- Ver detalles --}}
                                        <a href="{{ route('clientes.show', $cliente) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        
                                        {{-- Editar --}}
                                        <a href="{{ route('clientes.edit', $cliente) }}" 
                                           class="btn btn-sm btn-warning" 
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        
                                        {{-- Eliminar --}}
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="confirmarEliminacion({{ $cliente->id }})"
                                                title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    {{-- Formulario oculto para eliminar --}}
                                    <form id="form-eliminar-{{ $cliente->id }}" 
                                          action="{{ route('clientes.destroy', $cliente) }}" 
                                          method="POST" 
                                          class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            {{-- Mensaje cuando no hay clientes --}}
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                    <p class="text-muted mb-0">No hay clientes registrados</p>
                                    <a href="{{ route('clientes.create') }}" class="btn btn-primary btn-sm mt-2">
                                        <i class="bi bi-plus-circle me-1"></i>
                                        Crear primer cliente
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            @if($clientes->hasPages())
                <div class="mt-3">
                    {{ $clientes->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    /**
     * Confirmar eliminación de cliente
     * 
     * Muestra un cuadro de confirmación antes de eliminar un cliente.
     * Si el usuario confirma, envía el formulario de eliminación.
     * 
     * @param {number} id - ID del cliente a eliminar
     */
    function confirmarEliminacion(id) {
        if (confirm('¿Estás seguro de eliminar este cliente?\n\nEsta acción no se puede deshacer.')) {
            document.getElementById('form-eliminar-' + id).submit();
        }
    }
</script>
@endpush