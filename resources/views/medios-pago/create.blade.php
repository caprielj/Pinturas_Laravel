@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-credit-card-fill me-2"></i>Nuevo Medio de Pago</h2>

    <div class="card mt-3">
        <div class="card-body">
            <form action="{{ route('medios-pago.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre *</label>
                    <input type="text" name="nombre" id="nombre" 
                           class="form-control @error('nombre') is-invalid @enderror" 
                           value="{{ old('nombre') }}" required
                           placeholder="Ej: Tarjeta de Crédito">
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="activo" 
                               name="activo" value="1" checked>
                        <label class="form-check-label" for="activo">
                            <i class="bi bi-check-circle me-1"></i>Medio de Pago Activo
                        </label>
                    </div>
                    <small class="text-muted">Solo los medios de pago activos estarán disponibles al facturar</small>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>Guardar
                </button>
                <a href="{{ route('medios-pago.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection