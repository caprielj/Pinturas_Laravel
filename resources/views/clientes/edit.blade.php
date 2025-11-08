@extends('layouts.app')

@section('title', 'Editar Cliente - Paints')

@section('content')
<div class="container-fluid">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Clientes</a></li>
            <li class="breadcrumb-item active">Editar Cliente</li>
        </ol>
    </nav>

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-pencil-square me-2"></i>
            Editar Cliente: {{ $cliente->nombre }}
        </h2>
        <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">
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
                    Información del Cliente
                </div>
                <div class="card-body">
                    <form action="{{ route('clientes.update', $cliente) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Información Personal --}}
                        <h5 class="mb-3 text-muted">
                            <i class="bi bi-person me-2"></i>
                            Información Personal
                        </h5>

                        <div class="row mb-3">
                            {{-- Nombre --}}
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">
                                    Nombre Completo <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('nombre') is-invalid @enderror" 
                                       id="nombre" 
                                       name="nombre" 
                                       value="{{ old('nombre', $cliente->nombre) }}" 
                                       required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- NIT --}}
                            <div class="col-md-6">
                                <label for="nit" class="form-label">NIT</label>
                                <input type="text" 
                                       class="form-control @error('nit') is-invalid @enderror" 
                                       id="nit" 
                                       name="nit" 
                                       value="{{ old('nit', $cliente->nit) }}">
                                @error('nit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Información de Contacto --}}
                        <h5 class="mb-3 text-muted mt-4">
                            <i class="bi bi-envelope me-2"></i>
                            Información de Contacto
                        </h5>

                        <div class="row mb-3">
                            {{-- Email --}}
                            <div class="col-md-6">
                                <label for="email" class="form-label">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $cliente->email) }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Teléfono --}}
                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" 
                                       class="form-control @error('telefono') is-invalid @enderror" 
                                       id="telefono" 
                                       name="telefono" 
                                       value="{{ old('telefono', $cliente->telefono) }}">
                                @error('telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Contraseña --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label">Nueva Contraseña (Opcional)</label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password"
                                       placeholder="Dejar en blanco para mantener la actual">
                                <small class="text-muted">Solo completar si deseas cambiar la contraseña</small>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Dirección --}}
                        <h5 class="mb-3 text-muted mt-4">
                            <i class="bi bi-geo-alt me-2"></i>
                            Dirección
                        </h5>

                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección Completa</label>
                            <textarea class="form-control @error('direccion') is-invalid @enderror" 
                                      id="direccion" 
                                      name="direccion" 
                                      rows="2">{{ old('direccion', $cliente->direccion) }}</textarea>
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
                                       value="{{ old('gps_lat', $cliente->gps_lat) }}">
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
                                       value="{{ old('gps_lng', $cliente->gps_lng) }}">
                                @error('gps_lng')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Preferencias y Estado --}}
                        <h5 class="mb-3 text-muted mt-4">
                            <i class="bi bi-sliders me-2"></i>
                            Preferencias y Estado
                        </h5>

                        <div class="mb-3">
                            <div class="form-check mb-2">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="opt_in_promos" 
                                       name="opt_in_promos"
                                       value="1"
                                       {{ old('opt_in_promos', $cliente->opt_in_promos) ? 'checked' : '' }}>
                                <label class="form-check-label" for="opt_in_promos">
                                    <i class="bi bi-bell me-1"></i>
                                    Acepta recibir promociones
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="verificado" 
                                       name="verificado"
                                       value="1"
                                       {{ old('verificado', $cliente->verificado) ? 'checked' : '' }}>
                                <label class="form-check-label" for="verificado">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Cliente verificado
                                </label>
                            </div>
                        </div>

                        {{-- Botones --}}
                        <hr class="my-4">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>
                                Actualizar Cliente
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Sidebar con información adicional --}}
        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-info-circle me-2"></i>
                    Información del Registro
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <strong>ID:</strong> {{ $cliente->id }}
                    </p>
                    <p class="mb-2">
                        <strong>Fecha de Registro:</strong><br>
                        {{ $cliente->creado_en ? $cliente->creado_en->format('d/m/Y H:i') : 'N/A' }}
                    </p>
                    <p class="mb-0">
                        <strong>Estado:</strong><br>
                        @if($cliente->verificado)
                            <span class="badge bg-success">Verificado</span>
                        @else
                            <span class="badge bg-warning">Pendiente</span>
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
                        Al cambiar el email, el cliente deberá verificar su nueva dirección.
                        Si cambias la contraseña, notifica al cliente sobre el cambio.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection