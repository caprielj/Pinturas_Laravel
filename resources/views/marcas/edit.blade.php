{{-- 
    VISTA EDIT - FORMULARIO EDITAR MARCA
    Usa @method('PUT') para actualizar, carga valores existentes de BD
--}}

{{-- @extends: Hereda estructura del layout --}}
@extends('layouts.app')

{{-- @section: Bloque de contenido principal --}}
@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-pencil-square me-2"></i>Editar Marca</h2>

    <div class="card mt-3">
        <div class="card-body">
            {{-- route() con parámetro: Genera /marcas/{id} usando Route Model Binding --}}
            {{-- @method('PUT'): Simula método HTTP PUT para actualizar --}}
            <form action="{{ route('marcas.update', $marca) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre *</label>
                    {{-- old('campo', $default): Prioriza valor anterior, si no usa valor de BD --}}
                    <input type="text" name="nombre" id="nombre" 
                           class="form-control @error('nombre') is-invalid @enderror" 
                           value="{{ old('nombre', $marca->nombre) }}" required>
                    {{-- @error: Muestra mensaje de error si existe --}}
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    {{-- form-check-switch: Estilo toggle para checkbox --}}
                    {{-- old('activa', $marca->activa): Carga estado actual del checkbox de BD --}}
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="activa" 
                               name="activa" value="1" {{ old('activa', $marca->activa) ? 'checked' : '' }}>
                        <label class="form-check-label" for="activa">
                            <i class="bi bi-check-circle me-1"></i>Marca Activa
                        </label>
                    </div>
                    <small class="text-muted">Si desactivas esta marca, no aparecerá al crear nuevos productos</small>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>Actualizar
                </button>
                {{-- route(): Genera URL para volver al listado --}}
                <a href="{{ route('marcas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
{{-- @endsection: Cierra el bloque de contenido --}}
@endsection