{{-- @extends: Hereda toda la estructura del layout 'layouts.app' --}}
@extends('layouts.app')

{{-- @section inline: Define el título de la página en una sola línea --}}
@section('title', 'Nueva Sucursal - Paints')

{{-- @section: Inicia la sección 'content' que contiene todo el contenido principal de la página --}}
@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            {{-- {{ route() }}: Helper que genera la URL para la ruta 'dashboard' --}}
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            {{-- {{ route() }}: Genera la URL para el listado de sucursales --}}
            <li class="breadcrumb-item"><a href="{{ route('sucursales.index') }}">Sucursales</a></li>
            <li class="breadcrumb-item active">Nueva</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-shop-window me-2"></i>
            Nueva Sucursal
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
                    {{-- {{ route() }}: Genera la URL para almacenar la nueva sucursal (método POST) --}}
                    <form action="{{ route('sucursales.store') }}" method="POST">
                        {{-- @csrf: Token de seguridad contra ataques CSRF (Cross-Site Request Forgery) --}}
                        @csrf

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                            {{-- @error: Agrega clase 'is-invalid' si hay un error de validación en 'nombre' --}}
                            <input type="text" 
                                   class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" 
                                   name="nombre" 
                                   {{-- old(): Mantiene el valor anterior si el formulario falla la validación --}}
                                   value="{{ old('nombre') }}" 
                                   required
                                   placeholder="Ej: Pradera Xela">
                            {{-- @error: Si hay error en 'nombre', muestra este bloque con el mensaje --}}
                            @error('nombre')
                                {{-- $message: Variable automática con el mensaje de error de validación --}}
                                <div class="invalid-feedback">{{ $message }}</div>
                            {{-- @enderror: Cierra el bloque de error --}}
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            {{-- @error: Verifica si hay error en el campo 'direccion' --}}
                            <textarea class="form-control @error('direccion') is-invalid @enderror" 
                                      id="direccion" 
                                      name="direccion" 
                                      rows="2"
                                      {{-- {{ old() }}: Recupera el valor anterior dentro del textarea --}}
                                      placeholder="Ingresa la dirección física">{{ old('direccion') }}</textarea>
                            {{-- @error: Muestra el mensaje de error para 'direccion' --}}
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
                                   value="{{ old('telefono') }}"
                                   placeholder="Ej: 7765-4321">
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
                                       value="{{ old('gps_lat') }}"
                                       placeholder="Ej: 14.634915">
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
                                       value="{{ old('gps_lng') }}"
                                       placeholder="Ej: -90.506882">
                                @error('gps_lng')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="activa" 
                                       name="activa"
                                       checked>
                                <label class="form-check-label" for="activa">
                                    Sucursal Activa
                                </label>
                            </div>
                        </div>

                        <hr class="my-4">
                        
                        <div class="d-flex justify-content-between">
                            {{-- {{ route() }}: Genera la URL para cancelar y volver al listado --}}
                            <a href="{{ route('sucursales.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>
                                Guardar
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
                    <p class="small mb-2"><strong>Campo obligatorio:</strong></p>
                    <ul class="small mb-3">
                        <li>Nombre de la sucursal (debe ser único)</li>
                    </ul>
                    
                    <p class="small mb-2"><strong>Coordenadas GPS:</strong></p>
                    <p class="small mb-0">
                        Para obtener las coordenadas GPS de Google Maps:
                        Haz clic derecho en el mapa → Copiar coordenadas
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- @endsection: Cierra la sección 'content' abierta al inicio del archivo --}}
@endsection