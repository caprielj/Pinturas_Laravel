{{-- @extends: Hereda toda la estructura del layout 'layouts.app' --}}
@extends('layouts.app')

{{-- @section inline: Define el título de la página en una sola línea --}}
@section('title', 'Editar Sucursal - Paints')

{{-- @section: Inicia la sección 'content' que contiene todo el contenido de la página --}}
@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            {{-- {{ route() }}: Genera la URL para el dashboard --}}
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            {{-- {{ route() }}: Genera la URL para el listado de sucursales --}}
            <li class="breadcrumb-item"><a href="{{ route('sucursales.index') }}">Sucursales</a></li>
            <li class="breadcrumb-item active">Editar</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-pencil-square me-2"></i>
            Editar Sucursal
        </h2>
        {{-- {{ route() }}: Genera la URL para volver al listado --}}
        <a href="{{ route('sucursales.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>
            Volver
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    {{-- {{ route() }}: Genera la URL de actualización con el ID de la sucursal --}}
                    <form action="{{ route('sucursales.update', $sucursal->id) }}" method="POST">
                        {{-- @csrf: Token de seguridad contra ataques CSRF (Cross-Site Request Forgery) --}}
                        @csrf
                        {{-- @method: Simula el método HTTP PUT (los formularios HTML solo soportan GET/POST) --}}
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                            {{-- @error: Verifica si hay un error de validación para el campo 'nombre' --}}
                            <input type="text" 
                                   class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" 
                                   name="nombre" 
                                   {{-- old(): Mantiene el valor anterior, si no existe muestra el valor actual de BD --}}
                                   value="{{ old('nombre', $sucursal->nombre) }}" 
                                   required>
                            {{-- @error: Si hay error, muestra este bloque con el mensaje --}}
                            @error('nombre')
                                {{-- $message: Variable que contiene el mensaje de error de validación --}}
                                <div class="invalid-feedback">{{ $message }}</div>
                            {{-- @enderror: Cierra el bloque de error --}}
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            {{-- @error: Agrega clase 'is-invalid' si hay error en 'direccion' --}}
                            <textarea class="form-control @error('direccion') is-invalid @enderror" 
                                      id="direccion" 
                                      name="direccion" 
                                      rows="2">{{ old('direccion', $sucursal->direccion) }}</textarea>
                            {{-- @error: Muestra el error de validación para 'direccion' --}}
                            @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" 
                                   class="form-control @error('telefono') is-invalid @enderror" 
                                   id="telefono" 
                                   name="telefono" 
                                   value="{{ old('telefono', $sucursal->telefono) }}">
                            @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="gps_lat" class="form-label">Latitud GPS</label>
                                <input type="number" 
                                       step="0.000001" 
                                       class="form-control @error('gps_lat') is-invalid @enderror" 
                                       id="gps_lat" 
                                       name="gps_lat" 
                                       value="{{ old('gps_lat', $sucursal->gps_lat) }}">
                                @error('gps_lat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="gps_lng" class="form-label">Longitud GPS</label>
                                <input type="number" 
                                       step="0.000001" 
                                       class="form-control @error('gps_lng') is-invalid @enderror" 
                                       id="gps_lng" 
                                       name="gps_lng" 
                                       value="{{ old('gps_lng', $sucursal->gps_lng) }}">
                                @error('gps_lng')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- @if: Verifica si existen las coordenadas GPS para mostrar el enlace a Google Maps --}}
                        @if($sucursal->gps_lat && $sucursal->gps_lng)
                            <div class="mb-3">
                                {{-- {{ }}: Interpola las coordenadas en la URL de Google Maps --}}
                                <a href="https://www.google.com/maps?q={{ $sucursal->gps_lat }},{{ $sucursal->gps_lng }}" 
                                   target="_blank" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-map me-1"></i>
                                    Ver ubicación actual en Google Maps
                                </a>
                            </div>
                        {{-- @endif: Cierra el condicional del GPS --}}
                        @endif

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="activa" 
                                       name="activa"
                                       {{-- {{ }}: Usa operador ternario para marcar el checkbox si está activa --}}
                                       {{ old('activa', $sucursal->activa) ? 'checked' : '' }}>
                                <label class="form-check-label" for="activa">
                                    Sucursal Activa
                                </label>
                            </div>
                        </div>

                        <hr class="my-4">
                        
                        <div class="d-flex justify-content-between">
                            {{-- {{ route() }}: Genera URL para cancelar y volver al listado --}}
                            <a href="{{ route('sucursales.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>
                                Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-info-circle me-2"></i>
                    Información
                </div>
                <div class="card-body">
                    {{-- {{ }}: Imprime el ID de la sucursal --}}
                    <p class="mb-2"><strong>ID:</strong> {{ $sucursal->id }}</p>
                    <p class="mb-0">
                        <strong>Estado:</strong>
                        {{-- @if: Verifica si la sucursal está activa para mostrar el badge correspondiente --}}
                        @if($sucursal->activa)
                            <span class="badge bg-success">Activa</span>
                        {{-- @else: Se ejecuta si la sucursal NO está activa --}}
                        @else
                            <span class="badge bg-danger">Inactiva</span>
                        {{-- @endif: Cierra el condicional del estado --}}
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- @endsection: Cierra la sección 'content' abierta al inicio del archivo --}}
@endsection