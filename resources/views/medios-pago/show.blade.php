@extends('layouts.app')

@section('title', 'Detalles del Medio de Pago - Paints')

@section('content')
<div class="container-fluid">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('medios-pago.index') }}">Medios de Pago</a></li>
            <li class="breadcrumb-item active">{{ $medioPago->nombre }}</li>
        </ol>
    </nav>

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-credit-card me-2"></i>
            Detalles del Medio de Pago
        </h2>
        <div>
            <a href="{{ route('medios-pago.edit', $medioPago) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-2"></i>
                Editar
            </a>
            <a href="{{ route('medios-pago.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Volver
            </a>
        </div>
    </div>

    <div class="row">
        {{-- Información Principal --}}
        <div class="col-lg-8">
            {{-- Información del Medio de Pago --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-info-circle me-2"></i>
                    Información del Medio de Pago
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Nombre</label>
                            <p class="mb-0 fw-bold fs-4">
                                <i class="bi bi-{{ 
                                    $medioPago->nombre == 'Efectivo' ? 'cash-stack' : 
                                    ($medioPago->nombre == 'Cheque' ? 'receipt' : 
                                    ($medioPago->nombre == 'Transferencia Bancaria' ? 'bank' : 'credit-card'))
                                }} me-2"></i>
                                {{ $medioPago->nombre }}
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Estado</label>
                            <p class="mb-0">
                                @if($medioPago->activo)
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

            {{-- Historial de Transacciones (placeholder) --}}
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-clock-history me-2"></i>
                    Historial de Transacciones
                </div>
                <div class="card-body">
                    @if($medioPago->pagos && $medioPago->pagos->count() > 0)
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle me-2"></i>
                            Este medio de pago tiene <strong>{{ $medioPago->pagos->count() }}</strong> transacciones registradas.
                        </div>
                        {{-- Aquí podrías mostrar una tabla con las últimas transacciones --}}
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-receipt fs-1 d-block mb-2"></i>
                            <p class="mb-0">No hay transacciones registradas</p>
                            <small>Las transacciones realizadas con este medio de pago aparecerán aquí</small>
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
                        <label class="text-muted small">ID del Medio de Pago</label>
                        <p class="mb-0">
                            <code>#{{ $medioPago->id }}</code>
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
                        <span class="text-muted">Total Transacciones</span>
                        <strong>{{ $medioPago->pagos ? $medioPago->pagos->count() : 0 }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Monto Total</span>
                        <strong>Q. 0.00</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Estado</span>
                        <strong>{{ $medioPago->activo ? 'Activo' : 'Inactivo' }}</strong>
                    </div>
                    <hr class="my-2">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Estadísticas del medio de pago
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
                        <a href="{{ route('medios-pago.edit', $medioPago) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil me-2"></i>
                            Editar Medio de Pago
                        </a>
                        
                        <button type="button" 
                                class="btn btn-danger btn-sm" 
                                onclick="confirmarEliminacion()">
                            <i class="bi bi-trash me-2"></i>
                            Eliminar Medio de Pago
                        </button>

                        <hr class="my-2">

                        <a href="{{ route('medios-pago.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left me-2"></i>
                            Volver al Listado
                        </a>
                    </div>

                    {{-- Formulario oculto para eliminar --}}
                    <form id="form-eliminar" 
                          action="{{ route('medios-pago.destroy', $medioPago) }}" 
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
     * Confirmar eliminación del medio de pago
     */
    function confirmarEliminacion() {
        if (confirm('¿Estás seguro de eliminar este medio de pago?\n\nSe verificará que no tenga transacciones asociadas.\n\nEsta acción no se puede deshacer.')) {
            document.getElementById('form-eliminar').submit();
        }
    }
</script>
@endpush