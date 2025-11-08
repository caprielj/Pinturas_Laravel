@extends('layouts.app')

@section('title', 'Nueva Sucursal - Paints')

@section('content')
<div class="container-fluid">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('sucursales.index') }}">Sucursales</a></li>
            <li class="breadcrumb-item active">Nueva Sucursal</li>
        </ol>
    </nav>

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-shop-window me-2"></i>
            Nueva Sucursal
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
                    <form action="{{ route('sucursales.store') }}" method="POST">
                        @csrf

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
                                   value="{{ old('nombre') }}" 
                                   required
                                   placeholder="Ej: Pradera Xela">
                            <small class="text-muted">El nombre debe ser único en el sistema</small>
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
                                   value="{{ old('telefono') }}"
                                   placeholder="Ej: 7765-4321">
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
                                      rows="2"
                                      placeholder="Ingresa la dirección física de la sucursal">{{ old('direccion') }}</textarea>
                            @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Coordenadas GPS --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="gps_lat" class="form-label">
                                    Latitud GPS
                                    <i class="bi bi-info-circle text-muted" 
                                       title="Coordenada de latitud para ubicación en mapa"
                                       data-bs-toggle="tooltip"></i>
                                </label>
                                <input type="number" 
                                       step="0.000001" 
                                       class="form-control @error('gps_lat') is-invalid @enderror" 
                                       id="gps_lat" 
                                       name="gps_lat" 
                                       value="{{ old('gps_lat') }}"
                                       placeholder="Ej: 14.634915">
                                <small class="text-muted">Rango: -90 a 90</small>
                                @error('gps_lat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="gps_lng" class="form-label">
                                    Longitud GPS
                                    <i class="bi bi-info-circle text-muted" 
                                       title="Coordenada de longitud para ubicación en mapa"
                                       data-bs-toggle="tooltip"></i>
                                </label>
                                <input type="number" 
                                       step="0.000001" 
                                       class="form-control @error('gps_lng') is-invalid @enderror" 
                                       id="gps_lng" 
                                       name="gps_lng" 
                                       value="{{ old('gps_lng') }}"
                                       placeholder="Ej: -90.506882">
                                <small class="text-muted">Rango: -180 a 180</small>
                                @error('gps_lng')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Ayuda para coordenadas GPS --}}
                        <div class="alert alert-info mb-3">
                            <i class="bi bi-lightbulb me-2"></i>
                            <strong>¿Cómo obtener las coordenadas GPS?</strong>
                            <ol class="mb-0 mt-2 small">
                                <li>Abre Google Maps</li>
                                <li>Busca la dirección de la sucursal</li>
                                <li>Haz clic derecho en el marcador</li>
                                <li>Selecciona las coordenadas que aparecen arriba</li>
                                <li>Copia y pega aquí (primero latitud, luego longitud)</li>
                            </ol>
                        </div>

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
                                       {{ old('activa', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="activa">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Sucursal Activa
                                </label>
                                <small class="text-muted d-block">
                                    Solo las sucursales activas pueden realizar ventas y gestionar inventario
                                </small>
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
                                Guardar Sucursal
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
                    Información
                </div>
                <div class="card-body">
                    <h6 class="card-title">Campos obligatorios</h6>
                    <ul class="small mb-3">
                        <li>Nombre de la sucursal (debe ser único)</li>
                    </ul>

                    <h6 class="card-title">¿Para qué sirven las coordenadas GPS?</h6>
                    <p class="small mb-3">
                        Las coordenadas GPS permiten:
                    </p>
                    <ul class="small mb-0">
                        <li>Mostrar la ubicación en mapas</li>
                        <li>Calcular distancias</li>
                        <li>Mostrar al cliente la sucursal más cercana</li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-shop me-2"></i>
                    Sucursales Actuales
                </div>
                <div class="card-body">
                    <p class="small mb-2">
                        <strong>Sucursales existentes:</strong>
                    </p>
                    <ul class="small mb-0">
                        <li>Pradera Chimaltenango</li>
                        <li>Pradera Escuintla</li>
                        <li>Las Américas - Mazatenango</li>
                        <li>La Trinidad - Coatepeque</li>
                        <li>Pradera Xela - Quetzaltenango</li>
                        <li>Miraflores - Ciudad de Guatemala</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    /**
     * Inicializar tooltips de Bootstrap
     * 
     * Los tooltips son las pequeñas ventanas de ayuda que aparecen
     * al pasar el mouse sobre los iconos de información.
     */
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush