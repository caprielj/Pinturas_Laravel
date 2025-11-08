@extends('layouts.app')

@section('title', 'Editar Sucursal - Paints')

@section('content')
<div class="container-fluid">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('sucursales.index') }}">Sucursales</a></li>
            <li class="breadcrumb-item active">Editar Sucursal</li>
        </ol>
    </nav>

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-pencil-square me-2"></i>
            Editar Sucursal: {{ $sucursal->nombre }}
        </h2>
        <a href="{{ route('sucursales.index') }}" class="btn btn-outline-secondary">
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
                    Información de la Sucursal
                </div>
                <div class="card-body">
                    <form action="{{ route('sucursales.update', $sucursal) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Información Básica --}}
                        <h5 class="mb-3 text-muted">
                            <i class="bi bi-building me-2"></i>
                            Información Básica
                        </h5>

                        <div class="mb-3">
                            {{-- Nombre --}}
                            <label for="nombre" class="form-label">
                                Nombre de la Sucursal <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" 
                                   name="nombre" 
                                   value="{{ old('nombre', $sucursal->nombre) }}" 
                                   required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Información de Contacto --}}
                        <h5 class="mb-3 text-muted mt-4">
                            <i class="bi bi-telephone me-2"></i>
                            Información de Contacto
                        </h5>

                        <div class="mb-3">
                            {{-- Teléfono --}}
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

                        {{-- Dirección --}}
                        <h5 class="mb-3 text-muted mt-4">
                            <i class="bi bi-geo-alt me-2"></i>
                            Dirección y Ubicación
                        </h5>

                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección Completa</label>
                            <textarea class="form-control @error('direccion') is-invalid @enderror" 
                                      id="direccion" 
                                      name="direccion" 
                                      rows="2">{{ old('direccion', $sucursal->direccion) }}</textarea>
                            @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Coordenadas GPS --}}
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

                        {{-- Vista previa del mapa si hay coordenadas --}}
                        @if($sucursal->gps_lat && $sucursal->gps_lng)
                            <div class="mb-3">
                                <a href="https://www.google.com/maps?q={{ $sucursal->gps_lat }},{{ $sucursal->gps_lng }}" 
                                   target="_blank" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-map me-1"></i>
                                    Ver ubicación actual en Google Maps
                                </a>
                            </div>
                        @endif

                        {{-- Estado --}}
                        <h5 class="mb-3 text-muted mt-4">
                            <i class="bi bi-toggle-on me-2"></i>
                            Estado
                        </h5>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="activa" 
                                       name="activa"
                                       value="1"
                                       {{ old('activa', $sucursal->activa) ? 'checked' : '' }}>
                                <label class="form-check-label" for="activa">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Sucursal Activa
                                </label>
                            </div>
                        </div>

                        {{-- Botones --}}
                        <hr class="my-4">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('sucursales.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>
                                Actualizar Sucursal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Sidebar con información --}}
        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-info-circle me-2"></i>
                    Información del Registro
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <strong>ID:</strong> {{ $sucursal->id }}
                    </p>
                    <p class="mb-2">
                        <strong>Estado:</strong>
                        @if($sucursal->activa)
                            <span class="badge bg-success">Activa</span>
                        @else
                            <span class="badge bg-danger">Inactiva</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Advertencia
                </div>
                <div class="card-body">
                    <p class="small mb-0">
                        Si desactivas esta sucursal, los usuarios asignados a ella no podrán 
                        realizar ventas, pero los datos históricos se mantendrán.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection