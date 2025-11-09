@extends('layouts.app')

@section('title', 'Detalles del Usuario - Paints')

@section('content')
<div class="container-fluid">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('usuarios.index') }}">Usuarios</a></li>
            <li class="breadcrumb-item active">{{ $usuario->nombre }}</li>
        </ol>
    </nav>

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-person-circle me-2"></i>
            Detalles del Usuario
        </h2>
        <div>
            <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-2"></i>
                Editar
            </a>
            <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Volver
            </a>
        </div>
    </div>

    <div class="row">
        {{-- Información Principal --}}
        <div class="col-lg-8">
            {{-- Información Personal --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-person me-2"></i>
                    Información Personal
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Nombre Completo</label>
                            <p class="mb-0 fw-bold fs-5">{{ $usuario->nombre }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">DPI</label>
                            <p class="mb-0">{{ $usuario->dpi }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Email</label>
                            <p class="mb-0">
                                <i class="bi bi-envelope me-1"></i>
                                {{ $usuario->email }}
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Estado</label>
                            <p class="mb-0">
                                @if($usuario->activo)
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
                    </div>
                </div>
            </div>

            {{-- Asignación --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-briefcase me-2"></i>
                    Asignación de Rol y Sucursal
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Rol</label>
                            <p class="mb-0">
                                @if($usuario->rol)
                                    @php
                                        $badgeClass = match($usuario->rol->nombre) {
                                            'Gerente' => 'bg-danger',
                                            'Cajero' => 'bg-warning text-dark',
                                            'Digitador' => 'bg-info',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }} fs-6">
                                        {{ $usuario->rol->nombre }}
                                    </span>
                                    <br>
                                    <small class="text-muted">
                                        @if($usuario->esGerente())
                                            Acceso a reportes y estadísticas
                                        @elseif($usuario->esCajero())
                                            Solo puede realizar ventas
                                        @elseif($usuario->esDigitador())
                                            Puede alimentar el sistema con datos
                                        @endif
                                    </small>
                                @else
                                    <span class="text-muted">Sin rol asignado</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Sucursal Asignada</label>
                            <p class="mb-0">
                                @if($usuario->sucursal)
                                    <span class="badge bg-secondary fs-6">
                                        <i class="bi bi-shop me-1"></i>
                                        {{ $usuario->sucursal->nombre }}
                                    </span>
                                    <br>
                                    <small class="text-muted">
                                        {{ $usuario->sucursal->direccion ?? 'Sin dirección' }}
                                    </small>
                                @else
                                    <span class="text-muted">Sin sucursal asignada</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Actividad del Usuario (placeholder) --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-clock-history me-2"></i>
                    Actividad Reciente
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">Facturas Emitidas</label>
                            <p class="mb-0 fs-4">
                                <strong>{{ $usuario->facturas ? $usuario->facturas->count() : 0 }}</strong>
                            </p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">Cotizaciones</label>
                            <p class="mb-0 fs-4">
                                <strong>{{ $usuario->cotizaciones ? $usuario->cotizaciones->count() : 0 }}</strong>
                            </p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">Órdenes de Compra</label>
                            <p class="mb-0 fs-4">
                                <strong>{{ $usuario->ordenesCompra ? $usuario->ordenesCompra->count() : 0 }}</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Últimas Transacciones (placeholder) --}}
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-receipt me-2"></i>
                    Últimas Transacciones
                </div>
                <div class="card-body">
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-receipt fs-1 d-block mb-2"></i>
                        <p class="mb-0">No hay transacciones registradas</p>
                        <small>Las transacciones realizadas por este usuario aparecerán aquí</small>
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
                        <label class="text-muted small">ID del Usuario</label>
                        <p class="mb-0">
                            <code>#{{ $usuario->id }}</code>
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Fecha de Registro</label>
                        <p class="mb-0">
                            <i class="bi bi-calendar me-1"></i>
                            {{ $usuario->creado_en ? $usuario->creado_en->format('d/m/Y') : 'N/A' }}
                        </p>
                        <small class="text-muted">
                            {{ $usuario->creado_en ? $usuario->creado_en->format('H:i') : '' }}
                        </small>
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
                        <span class="text-muted">Total Facturas</span>
                        <strong>{{ $usuario->facturas ? $usuario->facturas->count() : 0 }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Total Cotizaciones</span>
                        <strong>{{ $usuario->cotizaciones ? $usuario->cotizaciones->count() : 0 }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Órdenes de Compra</span>
                        <strong>{{ $usuario->ordenesCompra ? $usuario->ordenesCompra->count() : 0 }}</strong>
                    </div>
                    <hr class="my-2">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Estadísticas del usuario
                    </small>
                </div>
            </div>

            {{-- Estado de Acceso --}}
            <div class="card mb-3">
                <div class="card-header {{ $usuario->activo ? 'bg-success' : 'bg-danger' }} text-white">
                    <i class="bi bi-{{ $usuario->activo ? 'check-circle' : 'x-circle' }} me-2"></i>
                    Estado de Acceso
                </div>
                <div class="card-body">
                    @if($usuario->activo)
                        <p class="mb-0">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Este usuario está <strong>activo</strong> y puede acceder al sistema.
                        </p>
                    @else
                        <div class="alert alert-danger mb-0">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Este usuario está <strong>inactivo</strong>. 
                            No puede acceder al sistema.
                        </div>
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
                        <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil me-2"></i>
                            Editar Usuario
                        </a>
                        
                        <button type="button" 
                                class="btn btn-danger btn-sm" 
                                onclick="confirmarEliminacion()">
                            <i class="bi bi-trash me-2"></i>
                            Eliminar Usuario
                        </button>

                        <hr class="my-2">

                        <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left me-2"></i>
                            Volver al Listado
                        </a>
                    </div>

                    {{-- Formulario oculto para eliminar --}}
                    <form id="form-eliminar" 
                          action="{{ route('usuarios.destroy', $usuario) }}" 
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
     * Confirmar eliminación del usuario
     */
    function confirmarEliminacion() {
        if (confirm('¿Estás seguro de eliminar este usuario?\n\nSe verificará que no tenga:\n- Facturas emitidas\n- Cotizaciones\n- Órdenes de compra\n\nEsta acción no se puede deshacer.')) {
            document.getElementById('form-eliminar').submit();
        }
    }
</script>
@endpush