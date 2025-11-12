{{-- 
    VISTA CREATE - FORMULARIO NUEVA MARCA
    Campos: nombre* (requerido), activa (checkbox con valor por defecto true)
--}}

{{-- @extends: Hereda estructura del layout --}}
@extends('layouts.app')

{{-- @section: Bloque de contenido principal --}}
@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-award-fill me-2"></i>Nueva Marca</h2>

    <div class="card mt-3">
        <div class="card-body">
            {{-- route(): Genera URL de destino del formulario --}}
            {{-- @csrf: Token de seguridad anti-CSRF --}}
            <form action="{{ route('marcas.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre *</label>
                    {{-- @error: Agrega clase 'is-invalid' si hay error de validación --}}
                    {{-- old(): Recupera valor anterior si hay error --}}
                    <input type="text" name="nombre" id="nombre" 
                           class="form-control @error('nombre') is-invalid @enderror" 
                           value="{{ old('nombre') }}" required>
                    {{-- @error: Muestra mensaje de error si existe --}}
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    {{-- form-check-input type="checkbox": Casilla de verificación estilo switch --}}
                    {{-- old('activa', true): Por defecto true (marcado) si es nueva marca --}}
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="activa" 
                               name="activa" value="1" {{ old('activa', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="activa">
                            <i class="bi bi-check-circle me-1"></i>Marca Activa
                        </label>
                    </div>
                    <small class="text-muted">Solo las marcas activas aparecerán al crear productos</small>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>Guardar
                </button>
                {{-- route(): Genera URL para volver al listado --}}
                <a href="{{ route('marcas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
{{-- @endsection: Cierra el bloque de contenido --}}
@endsection