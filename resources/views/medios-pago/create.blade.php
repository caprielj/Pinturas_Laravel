@extends('layouts.app')

@section('title', 'Nuevo Medio de Pago - Paints')

@section('content')
<div class="container-fluid">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('medios-pago.index') }}">Medios de Pago</a></li>
            <li class="breadcrumb-item active">Nuevo Medio de Pago</li>
        </ol>
    </nav>

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-credit-card-fill me-2"></i>
            Nuevo Medio de Pago
        </h2>
        <a href="{{ route('medios-pago.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>
            Volver al listado
        </a>
    </div>

    {{-- Formulario --}}
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-file-earmark-text me-2"></i>
                    Información del Medio de Pago
                </div>
                <div class="card-body">
                    <form action="{{ route('medios-pago.store') }}" method="POST">
                        @csrf

                        {{-- Nombre --}}
                        <div class="mb-3">
                            <label for="nombre" class="form-label">
                                Nombre del Medio de Pago <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" 
                                   name="nombre" 
                                   value="{{ old('nombre') }}" 
                                   required
                                   placeholder="Ej: Tarjeta de Crédito">
                            <small class="text-muted">El nombre debe ser único en el sistema</small>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Estado --}}
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="activo" 
                                       name="activo"
                                       value="1"
                                       {{ old('activo', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="activo">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Medio de Pago Activo
                                </label>
                                <small class="text-muted d-block">
                                    Solo los medios de pago activos estarán disponibles al facturar
                                </small>
                            </div>
                        </div>

                        {{-- Botones --}}
                        <hr class="my-4">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('medios-pago.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>
                                Guardar Medio de Pago
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Sidebar con ayuda --}}
        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-info-circle me-2"></i>
                    Información
                </div>
                <div class="card-body">
                    <h6 class="card-title">Campos obligatorios</h6>
                    <ul class="small mb-3">
                        <li>Nombre del medio de pago (debe ser único)</li>
                    </ul>

                    <h6 class="card-title">¿Para qué sirve?</h6>
                    <p class="small mb-0">
                        Los medios de pago permiten registrar las diferentes formas 
                        en que los clientes pueden realizar sus pagos. Una factura 
                        puede ser pagada usando uno o varios medios de pago.
                    </p>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-lightbulb me-2"></i>
                    Ejemplos de Medios de Pago
                </div>
                <div class="card-body">
                    <ul class="small mb-0">
                        <li><i class="bi bi-cash-stack me-1"></i> Efectivo</li>
                        <li><i class="bi bi-credit-card me-1"></i> Tarjeta de Crédito</li>
                        <li><i class="bi bi-credit-card me-1"></i> Tarjeta de Débito</li>
                        <li><i class="bi bi-bank me-1"></i> Transferencia Bancaria</li>
                        <li><i class="bi bi-receipt me-1"></i> Cheque</li>
                        <li><i class="bi bi-wallet2 me-1"></i> Billetera Digital</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection