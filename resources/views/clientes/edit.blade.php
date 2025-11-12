{{-- 
    VISTA EDIT - FORMULARIO EDITAR CLIENTE
    Usa @method('PUT') para actualizar, carga valores existentes de BD
--}}

{{-- @extends: Hereda estructura del layout --}}
@extends('layouts.app')

{{-- @section: Bloque de contenido principal --}}
@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-pencil-square me-2"></i>Editar Cliente</h2>

    <div class="card mt-3">
        <div class="card-body">
            {{-- route() con parámetro: Genera /clientes/{id} --}}
            {{-- @method('PUT'): Simula método HTTP PUT para actualizar --}}
            <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
                @csrf
                @method('PUT')

                <h5 class="mb-3"><i class="bi bi-person me-2"></i>Información Personal</h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre Completo *</label>
                        {{-- old('campo', $default): Prioriza valor anterior, si no usa valor de BD --}}
                        <input type="text" name="nombre" id="nombre" 
                               class="form-control @error('nombre') is-invalid @enderror" 
                               value="{{ old('nombre', $cliente->nombre) }}" required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="nit" class="form-label">NIT</label>
                        <input type="text" name="nit" id="nit" 
                               class="form-control @error('nit') is-invalid @enderror" 
                               value="{{ old('nit', $cliente->nit) }}">
                        @error('nit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <h5 class="mb-3 mt-4"><i class="bi bi-envelope me-2"></i>Información de Contacto</h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" name="email" id="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', $cliente->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" 
                               class="form-control @error('telefono') is-invalid @enderror" 
                               value="{{ old('telefono', $cliente->telefono) }}">
                        @error('telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Alerta informativa sobre cambio de contraseña --}}
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Deja este campo en blanco si no deseas cambiar la contraseña
                </div>

                {{-- Campo contraseña (opcional en edición) --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="password" class="form-label">Nueva Contraseña</label>
                        <input type="password" name="password" id="password" 
                               class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <h5 class="mb-3 mt-4"><i class="bi bi-geo-alt me-2"></i>Dirección</h5>

                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección Completa</label>
                    <textarea name="direccion" id="direccion" rows="2"
                              class="form-control @error('direccion') is-invalid @enderror">{{ old('direccion', $cliente->direccion) }}</textarea>
                    @error('direccion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="gps_lat" class="form-label">Latitud GPS</label>
                        <input type="number" step="0.000001" name="gps_lat" id="gps_lat" 
                               class="form-control @error('gps_lat') is-invalid @enderror" 
                               value="{{ old('gps_lat', $cliente->gps_lat) }}">
                        @error('gps_lat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="gps_lng" class="form-label">Longitud GPS</label>
                        <input type="number" step="0.000001" name="gps_lng" id="gps_lng" 
                               class="form-control @error('gps_lng') is-invalid @enderror" 
                               value="{{ old('gps_lng', $cliente->gps_lng) }}">
                        @error('gps_lng')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <h5 class="mb-3 mt-4"><i class="bi bi-sliders me-2"></i>Preferencias</h5>

                <div class="mb-3">
                    {{-- Checkbox con valor existente: Si es true/1 agrega 'checked' --}}
                    {{-- Operador ternario: condición ? 'checked' : '' --}}
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="opt_in_promos" 
                               name="opt_in_promos" value="1" 
                               {{ old('opt_in_promos', $cliente->opt_in_promos) ? 'checked' : '' }}>
                        <label class="form-check-label" for="opt_in_promos">
                            <i class="bi bi-bell me-1"></i>Acepta recibir promociones
                        </label>
                    </div>

                    {{-- Checkbox: Cliente Verificado --}}
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="verificado" 
                               name="verificado" value="1" 
                               {{ old('verificado', $cliente->verificado) ? 'checked' : '' }}>
                        <label class="form-check-label" for="verificado">
                            <i class="bi bi-check-circle me-1"></i>Cliente verificado
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>Actualizar
                </button>
                <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
{{-- @endsection: Cierra el bloque de contenido --}}
@endsection