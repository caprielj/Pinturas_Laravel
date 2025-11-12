{{-- 
    VISTA CREATE - FORMULARIO NUEVO CLIENTE
    Campos: nombre*, email*, nit, telefono, direccion, gps, password, opt_in_promos
--}}

{{-- @extends: Hereda estructura del layout --}}
@extends('layouts.app')

{{-- @section: Bloque de contenido principal --}}
@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-person-plus me-2"></i>Nuevo Cliente</h2>

    <div class="card mt-3">
        <div class="card-body">
            {{-- route(): Genera URL de destino del formulario --}}
            {{-- @csrf: Token de seguridad anti-CSRF --}}
            <form action="{{ route('clientes.store') }}" method="POST">
                @csrf

                {{-- SECCIÓN: Información Personal --}}
                <h5 class="mb-3"><i class="bi bi-person me-2"></i>Información Personal</h5>

                <div class="row mb-3">
                    {{-- Campo Nombre (obligatorio) --}}
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre Completo *</label>
                        {{-- old(): Recupera valor anterior si hay error --}}
                        {{-- @error: Agrega clase 'is-invalid' si hay error de validación --}}
                        <input type="text" name="nombre" id="nombre" 
                               class="form-control @error('nombre') is-invalid @enderror" 
                               value="{{ old('nombre') }}" required>
                        {{-- @error: Muestra mensaje de error --}}
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Campo NIT (opcional) --}}
                    <div class="col-md-6">
                        <label for="nit" class="form-label">NIT</label>
                        <input type="text" name="nit" id="nit" 
                               class="form-control @error('nit') is-invalid @enderror" 
                               value="{{ old('nit') }}" placeholder="Ej: 1234567-8">
                        @error('nit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- SECCIÓN: Información de Contacto --}}
                <h5 class="mb-3 mt-4"><i class="bi bi-envelope me-2"></i>Información de Contacto</h5>

                <div class="row mb-3">
                    {{-- Campo Email (obligatorio, único) --}}
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" name="email" id="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Campo Teléfono (opcional) --}}
                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" 
                               class="form-control @error('telefono') is-invalid @enderror" 
                               value="{{ old('telefono') }}" placeholder="Ej: 1234-5678">
                        @error('telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Campo Contraseña (opcional) --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="password" class="form-label">Contraseña (Opcional)</label>
                        <input type="password" name="password" id="password" 
                               class="form-control @error('password') is-invalid @enderror">
                        <small class="text-muted">Solo si el cliente tendrá acceso al sistema</small>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- SECCIÓN: Dirección --}}
                <h5 class="mb-3 mt-4"><i class="bi bi-geo-alt me-2"></i>Dirección</h5>

                {{-- Campo Dirección (textarea - texto multilínea) --}}
                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección Completa</label>
                    <textarea name="direccion" id="direccion" rows="2"
                              class="form-control @error('direccion') is-invalid @enderror">{{ old('direccion') }}</textarea>
                    @error('direccion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Coordenadas GPS (opcionales) --}}
                <div class="row mb-3">
                    {{-- Campo Latitud GPS --}}
                    <div class="col-md-6">
                        <label for="gps_lat" class="form-label">Latitud GPS</label>
                        {{-- type="number" step="0.000001": Permite decimales precisos --}}
                        <input type="number" step="0.000001" name="gps_lat" id="gps_lat" 
                               class="form-control @error('gps_lat') is-invalid @enderror" 
                               value="{{ old('gps_lat') }}" placeholder="Ej: 14.634915">
                        @error('gps_lat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Campo Longitud GPS --}}
                    <div class="col-md-6">
                        <label for="gps_lng" class="form-label">Longitud GPS</label>
                        <input type="number" step="0.000001" name="gps_lng" id="gps_lng" 
                               class="form-control @error('gps_lng') is-invalid @enderror" 
                               value="{{ old('gps_lng') }}" placeholder="Ej: -90.506882">
                        @error('gps_lng')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- SECCIÓN: Preferencias --}}
                <h5 class="mb-3 mt-4"><i class="bi bi-sliders me-2"></i>Preferencias</h5>

                {{-- Checkbox: Acepta Promociones --}}
                <div class="mb-3">
                    <div class="form-check">
                        {{-- type="checkbox" value="1": Si está marcado envía 1, si no, nada --}}
                        <input class="form-check-input" type="checkbox" id="opt_in_promos" 
                               name="opt_in_promos" value="1">
                        <label class="form-check-label" for="opt_in_promos">
                            <i class="bi bi-bell me-1"></i>
                            Acepta recibir promociones y ofertas por email
                        </label>
                    </div>
                </div>

                {{-- Botones de acción --}}
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>Guardar
                </button>
                <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
{{-- @endsection: Cierra el bloque de contenido --}}
@endsection