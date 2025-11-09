@extends('layouts.app')

@section('title', 'Nueva Marca - Paints')

@section('content')
<div class="container-fluid">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('marcas.index') }}">Marcas</a></li>
            <li class="breadcrumb-item active">Nueva Marca</li>
        </ol>
    </nav>

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-award-fill me-2"></i>
            Nueva Marca
        </h2>
        <a href="{{ route('marcas.index') }}" class="btn btn-outline-secondary">
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
                    Información de la Marca
                </div>
                <div class="card-body">
                    <form action="{{ route('marcas.store') }}" method="POST">
                        @csrf

                        {{-- Nombre --}}
                        <div class="mb-3">
                            <label for="nombre" class="form-label">
                                Nombre de la Marca <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" 
                                   name="nombre" 
                                   value="{{ old('nombre') }}" 
                                   required
                                   placeholder="Ej: Sherwin Williams">
                            <small class="text-muted">El nombre debe ser único en el sistema</small>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Estado --}}
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
                                    Marca Activa
                                </label>
                                <small class="text-muted d-block">
                                    Solo las marcas activas aparecerán al crear productos
                                </small>
                            </div>
                        </div>

                        {{-- Botones --}}
                        <hr class="my-4">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('marcas.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>
                                Guardar Marca
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Sidebar con ayuda --}}
        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-info-circle me-2"></i>
                    Información
                </div>
                <div class="card-body">
                    <h6 class="card-title">Campos obligatorios</h6>
                    <ul class="small mb-3">
                        <li>Nombre de la marca (debe ser único)</li>
                    </ul>

                    <h6 class="card-title">¿Para qué sirve?</h6>
                    <p class="small mb-0">
                        Las marcas identifican al fabricante del producto. 
                        Ayudan a los clientes a reconocer la calidad y características 
                        de los productos.
                    </p>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-lightbulb me-2"></i>
                    Ejemplos de Marcas
                </div>
                <div class="card-body">
                    <ul class="small mb-0">
                        <li>Sherwin Williams</li>
                        <li>Comex</li>
                        <li>Berel</li>
                        <li>Pintuco</li>
                        <li>Behr</li>
                        <li>Glidden</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection