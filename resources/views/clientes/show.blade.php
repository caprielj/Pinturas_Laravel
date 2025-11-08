@extends('layouts.app')

@section('title', 'Detalles del Cliente - Paints')

@section('content')
<div class="container-fluid">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Clientes</a></li>
            <li class="breadcrumb-item active">{{ $cliente->nombre }}</li>
        </ol>
    </nav>

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-person-circle me-2"></i>
            Detalles del Cliente
        </h2>
        <div>
            <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-2"></i>
                Editar
            </a>
            <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">
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
                            <p class="mb-0 fw-bold">{{ $cliente->nombre }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">NIT</label>
                            <p class="mb-0">{{ $cliente->nit ?? 'No registrado' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Email</label>
                            <p class="mb-0">
                                <i class="bi bi-envelope me-1"></i>
                                {{ $cliente->email }}
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Teléfono</label>
                            <p class="mb-0">
                                <i class="bi bi-telephone me-1"></i>
                                {{ $cliente->telefono ?? 'No registrado' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Dirección --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-geo-alt me-2"></i>
                    Dirección
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Dirección Completa</label>
                        <p class="mb-0">{{ $cliente->direccion ?? 'No registrada' }}</p>
                    </div>
                    
                    @if($cliente->gps_lat && $cliente->gps_lng)
                        <div class="row">
                            <div class="col-md-6">
                                <label class="text-muted small">Latitud GPS</label>
                                <p class="mb-0">{{ $cliente->gps_lat }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small">Longitud GPS</label>
                                <p class="mb-0">{{ $cliente->gps_lng }}</p>
                            </div>
                        </div>
                        
                        {{-- Mapa (opcional, simple link a Google Maps) --}}
                        <div class="mt-3">
                            <a href="https://www.google.com/maps?q={{ $cliente->gps_lat }},{{ $cliente->gps_lng }}" 
                               target="_blank" 
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-map me-1"></i>
                                Ver en Google Maps
                            </a>
                        </div>
                    @else
                        <p class="text-muted mb-0">
                            <i class="bi bi-info-circle me-1"></i>
                            No hay coordenadas GPS registradas
                        </p>
                    @endif
                </div>
            </div>

            {{-- Historial de Compras (placeholder para futuro) --}}
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-clock-history me-2"></i>
                    Historial de Compras
                </div>
                <div class="card-body">
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-cart-x fs-1 d-block mb-2"></i>
                        <p class="mb-0">No hay compras registradas</p>
                        <small>Esta sección mostrará el historial de facturas del cliente</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            {{-- Estado y Estadísticas --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-info-circle me-2"></i>
                    Estado del Cliente
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Verificación</label>
                        <p class="mb-0">
                            @if($cliente->verificado)
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Verificado
                                </span>
                            @else
                                <span class="badge bg-warning">
                                    <i class="bi bi-clock me-1"></i>
                                    Pendiente de verificación
                                </span>
                            @endif
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Promociones</label>
                        <p class="mb-0">
                            @if($cliente->opt_in_promos)
                                <span class="badge bg-info">
                                    <i class="bi bi-bell me-1"></i>
                                    Acepta promociones
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="bi bi-bell-slash me-1"></i>
                                    No acepta promociones
                                </span>
                            @endif
                        </p>
                    </div>

                    <hr>

                    <div class="mb-2">
                        <label class="text-muted small">Fecha de Registro</label>
                        <p class="mb-0">
                            <i class="bi bi-calendar me-1"></i>
                            {{ $cliente->creado_en ? $cliente->creado_en->format('d/m/Y') : 'N/A' }}
                        </p>
                    </div>

                    <div>
                        <label class="text-muted small">ID del Cliente</label>
                        <p class="mb-0">
                            <code>#{{ $cliente->id }}</code>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Estadísticas (placeholder) --}}
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-graph-up me-2"></i>
                    Estadísticas
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Total Compras</span>
                        <strong>0</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Total Gastado</span>
                        <strong>Q. 0.00</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Última Compra</span>
                        <strong>N/A</strong>
                    </div>
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
                        <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil me-2"></i>
                            Editar Cliente
                        </a>
                        
                        <button type="button" 
                                class="btn btn-danger btn-sm" 
                                onclick="confirmarEliminacion()">
                            <i class="bi bi-trash me-2"></i>
                            Eliminar Cliente
                        </button>

                        <hr class="my-2">

                        <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left me-2"></i>
                            Volver al Listado
                        </a>
                    </div>

                    {{-- Formulario oculto para eliminar --}}
                    <form id="form-eliminar" 
                          action="{{ route('clientes.destroy', $cliente) }}" 
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
     * Confirmar eliminación del cliente
     */
    function confirmarEliminacion() {
        if (confirm('¿Estás seguro de eliminar este cliente?\n\nSe eliminarán también:\n- Su historial de compras\n- Sus cotizaciones\n- Sus carritos de compra\n\nEsta acción no se puede deshacer.')) {
            document.getElementById('form-eliminar').submit();
        }
    }
</script>
@endpush