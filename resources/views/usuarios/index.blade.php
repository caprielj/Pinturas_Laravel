@extends('layouts.app')

@section('title', 'Usuarios - Paints')

@section('content')
<div class="container-fluid">
    {{-- Encabezado de la página --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-person-badge me-2"></i>
            Gestión de Usuarios
        </h2>
        {{-- Botón para crear nuevo usuario --}}
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>
            Nuevo Usuario
        </a>
    </div>

    {{-- Card con la tabla --}}
    <div class="card">
        <div class="card-header">
            <i class="bi bi-table me-2"></i>
            Listado de Usuarios
        </div>
        <div class="card-body">
            {{-- Tabla responsive --}}
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>DPI</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Sucursal</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $usuario)
                            <tr>
                                <td>{{ $usuario->id }}</td>
                                <td>
                                    <strong>{{ $usuario->nombre }}</strong>
                                </td>
                                <td>{{ $usuario->dpi }}</td>
                                <td>
                                    <i class="bi bi-envelope me-1"></i>
                                    {{ $usuario->email }}
                                </td>
                                <td>
                                    @if($usuario->rol)
                                        @php
                                            $badgeClass = match($usuario->rol->nombre) {
                                                'Gerente' => 'bg-danger',
                                                'Cajero' => 'bg-warning text-dark',
                                                'Digitador' => 'bg-info',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">
                                            {{ $usuario->rol->nombre }}
                                        </span>
                                    @else
                                        <span class="text-muted">Sin rol</span>
                                    @endif
                                </td>
                                <td>
                                    @if($usuario->sucursal)
                                        <span class="badge bg-secondary">
                                            {{ $usuario->sucursal->nombre }}
                                        </span>
                                    @else
                                        <span class="text-muted">Sin asignar</span>
                                    @endif
                                </td>
                                <td>
                                    @if($usuario->activo)
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
                                        <a href="{{ route('usuarios.show', $usuario) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        
                                        {{-- Editar --}}
                                        <a href="{{ route('usuarios.edit', $usuario) }}" 
                                           class="btn btn-sm btn-warning" 
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        
                                        {{-- Eliminar --}}
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="confirmarEliminacion({{ $usuario->id }})"
                                                title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    {{-- Formulario oculto para eliminar --}}
                                    <form id="form-eliminar-{{ $usuario->id }}" 
                                          action="{{ route('usuarios.destroy', $usuario) }}" 
                                          method="POST" 
                                          class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            {{-- Mensaje cuando no hay usuarios --}}
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                    <p class="text-muted mb-0">No hay usuarios registrados</p>
                                    <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-sm mt-2">
                                        <i class="bi bi-plus-circle me-1"></i>
                                        Crear primer usuario
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            @if($usuarios->hasPages())
                <div class="mt-3">
                    {{ $usuarios->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Información adicional --}}
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Roles de usuario:</strong>
                <ul class="mb-0 mt-2">
                    <li><strong>Digitador:</strong> Puede alimentar el sistema con datos (crear productos, clientes, etc.)</li>
                    <li><strong>Cajero:</strong> Solo puede realizar ventas y autorizar facturas</li>
                    <li><strong>Gerente:</strong> Tiene acceso a reportes y estadísticas del sistema</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    /**
     * Confirmar eliminación de usuario
     * 
     * Muestra un cuadro de confirmación antes de eliminar un usuario.
     * Verifica que no tenga transacciones asociadas.
     * 
     * @param {number} id - ID del usuario a eliminar
     */
    function confirmarEliminacion(id) {
        if (confirm('¿Estás seguro de eliminar este usuario?\n\nSe verificará que no tenga facturas, cotizaciones u órdenes asociadas.\n\nEsta acción no se puede deshacer.')) {
            document.getElementById('form-eliminar-' + id).submit();
        }
    }
</script>
@endpush