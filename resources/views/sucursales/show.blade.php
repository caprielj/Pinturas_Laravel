@extends('layouts.app')

@section('title', 'Detalles Sucursal - Paints')

@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('sucursales.index') }}">Sucursales</a></li>
            <li class="breadcrumb-item active">{{ $sucursal->nombre }}</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-shop me-2"></i>
            Detalles de la Sucursal
        </h2>
        <div>
            <a href="{{ route('sucursales.edit', $sucursal->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-2"></i>
                Editar
            </a>
            <a href="{{ route('sucursales.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Volver
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-building me-2"></i>
                    Información de la Sucursal
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Nombre</label>
                            <p class="mb-0 fw-bold fs-5">{{ $sucursal->nombre }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Estado</label>
                            <p class="mb-0">
                                @if($sucursal->activa)
                                    <span class="badge bg-success">Activa</span>
                                @else
                                    <span class="badge bg-danger">Inactiva</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Teléfono</label>
                            <p class="mb-0">{{ $sucursal->telefono ?? 'No registrado' }}</p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="text-muted small">Dirección</label>
                            <p class="mb-0">{{ $sucursal->direccion ?? 'No registrada' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <i class="bi bi-geo-alt me-2"></i>
                    Ubicación GPS
                </div>
                <div class="card-body">
                    @if($sucursal->gps_lat && $sucursal->gps_lng)
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="text-muted small">Latitud</label>
                                <p class="mb-0"><code>{{ $sucursal->gps_lat }}</code></p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small">Longitud</label>
                                <p class="mb-0"><code>{{ $sucursal->gps_lng }}</code></p>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <a href="https://www.google.com/maps?q={{ $sucursal->gps_lat }},{{ $sucursal->gps_lng }}" 
                               target="_blank" 
                               class="btn btn-outline-primary">
                                <i class="bi bi-map me-2"></i>
                                Ver en Google Maps
                            </a>
                        </div>

                        <div class="mt-3">
                            <div class="ratio ratio-16x9">
                                <iframe 
                                    src="https://maps.google.com/maps?q={{ $sucursal->gps_lat }},{{ $sucursal->gps_lng }}&t=&z=15&ie=UTF8&iwloc=&output=embed"
                                    frameborder="0" 
                                    style="border-radius: 8px;">
                                </iframe>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            No hay coordenadas GPS registradas.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-info-circle me-2"></i>
                    Información del Registro
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <label class="text-muted small">ID</label>
                        <p class="mb-0"><code>#{{ $sucursal->id }}</code></p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <i class="bi bi-gear me-2"></i>
                    Acciones
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('sucursales.edit', $sucursal->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil me-2"></i>
                            Editar
                        </a>
                        
                        @if($sucursal->gps_lat && $sucursal->gps_lng)
                            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $sucursal->gps_lat }},{{ $sucursal->gps_lng }}" 
                               target="_blank"
                               class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-compass me-2"></i>
                                Obtener Direcciones
                            </a>
                        @endif
                        
                        <button type="button" 
                                class="btn btn-danger btn-sm" 
                                onclick="eliminar()">
                            <i class="bi bi-trash me-2"></i>
                            Eliminar
                        </button>

                        <hr class="my-2">

                        <a href="{{ route('sucursales.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left me-2"></i>
                            Volver al Listado
                        </a>
                    </div>

                    <form id="delete-form" 
                          action="{{ route('sucursales.destroy', $sucursal->id) }}" 
                          method="POST" 
                          class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function eliminar() {
        if (confirm('¿Estás seguro de eliminar esta sucursal?')) {
            document.getElementById('delete-form').submit();
        }
    }
</script>
@endpush