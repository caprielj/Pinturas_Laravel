@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-pencil-square me-2"></i>Editar Medio de Pago</h2>

    <div class="card mt-3">
        <div class="card-body">
            <form action="{{ route('medios-pago.update', $medioPago->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre *</label>
                    <input type="text" name="nombre" id="nombre" 
                           class="form-control @error('nombre') is-invalid @enderror" 
                           value="{{ old('nombre', $medioPago->nombre) }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="activo" 
                               name="activo" value="1" {{ old('activo', $medioPago->activo) ? 'checked' : '' }}>
                        <label class="form-check-label" for="activo">
                            <i class="bi bi-check-circle me-1"></i>Medio de Pago Activo
                        </label>
                    </div>
                    <small class="text-muted">Si desactivas este medio, no aparecerá al crear facturas</small>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>Actualizar
                </button>
                <a href="{{ route('medios-pago.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection