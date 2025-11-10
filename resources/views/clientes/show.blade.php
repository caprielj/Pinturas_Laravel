{{-- 
    Vista: clientes/show.blade.php
    
    Muestra los detalles completos de un cliente específico
    Variable recibida: $cliente (modelo Cliente con todos sus datos)
--}}

@extends('layouts.app')

@section('content')
<div class="container mt-4">
    {{-- Encabezado con nombre del cliente y botones --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><i class="bi bi-person-circle me-2"></i>{{ $cliente->nombre }}</h2>
        <div>
            <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-2"></i>Editar
            </a>
            <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    <div class="row">
        {{-- Columna Principal - Información del Cliente --}}
        <div class="col-md-8">
            {{-- Card: Información Personal --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-person me-2"></i>Información Personal
                </div>
                <div class="card-body">
                    <p><strong>NIT:</strong> {{ $cliente->nit ?? 'No registrado' }}</p>
                    <p><strong>Email:</strong> 
                        <i class="bi bi-envelope me-1"></i>{{ $cliente->email }}
                    </p>
                    <p><strong>Teléfono:</strong> 
                        <i class="bi bi-telephone me-1"></i>{{ $cliente->telefono ?? 'No registrado' }}
                    </p>
                </div>
            </div>

            {{-- Card: Dirección --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-geo-alt me-2"></i>Dirección
                </div>
                <div class="card-body">
                    <p><strong>Dirección:</strong> {{ $cliente->direccion ?? 'No registrada' }}</p>
                    
                    {{-- 
                        Coordenadas GPS (solo si existen)
                        && = operador AND
                        Si ambas coordenadas existen, muestra el bloque
                    --}}
                    @if($cliente->gps_lat && $cliente->gps_lng)
                        <p><strong>Coordenadas GPS:</strong></p>
                        <p>Lat: {{ $cliente->gps_lat }}, Lng: {{ $cliente->gps_lng }}</p>
                        
                        {{-- Link a Google Maps --}}
                        <a href="https://www.google.com/maps?q={{ $cliente->gps_lat }},{{ $cliente->gps_lng }}" 
                           target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-map me-1"></i>Ver en Google Maps
                        </a>
                    @else
                        <p class="text-muted">No hay coordenadas GPS registradas</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Columna Lateral - Estado y Preferencias --}}
        <div class="col-md-4">
            {{-- Card: Estado del Cliente --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-info-circle me-2"></i>Estado
                </div>
                <div class="card-body">
                    {{-- Estado de Verificación --}}
                    <p><strong>Verificación:</strong></p>
                    <p>
                        @if($cliente->verificado)
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle me-1"></i>Verificado
                            </span>
                        @else
                            <span class="badge bg-warning">
                                <i class="bi bi-clock me-1"></i>Pendiente
                            </span>
                        @endif
                    </p>

                    {{-- Preferencias de Promociones --}}
                    <p><strong>Promociones:</strong></p>
                    <p>
                        @if($cliente->opt_in_promos)
                            <span class="badge bg-info">
                                <i class="bi bi-bell me-1"></i>Acepta promociones
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                <i class="bi bi-bell-slash me-1"></i>No acepta
                            </span>
                        @endif
                    </p>

                    <hr>

                    {{-- 
                        Fecha de Registro
                        $cliente->creado_en->format('d/m/Y')
                        Carbon object con método format() para formatear fecha
                    --}}
                    <p><strong>Fecha de registro:</strong></p>
                    <p>
                        <i class="bi bi-calendar me-1"></i>
                        {{ $cliente->creado_en ? $cliente->creado_en->format('d/m/Y H:i') : 'N/A' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection