@extends('layouts.app')

@section('title', 'Editar Marca - Paints')

@section('content')
<div class="container-fluid">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('marcas.index') }}">Marcas</a></li>
            <li class="breadcrumb-item active">Editar Marca</li>
        </ol>
    </nav>

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-pencil-square me-2"></i>
            Editar Marca: {{ $marca->nombre }}
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
                    <form action="{{ route('marcas.update', $marca) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Nombre --}}
                        <div class="mb-3">
                            <label for="nombre" class="form-label">
                                Nombre de la Marca <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" 
                                   name="nombre" 
                                   value="{{ old('nombre', $marca->nombre) }}" 
                                   required>
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
                                       {{ old('activa', $marca->activa) ? 'checked' : '' }}>
                                <label class="form-check-label" for="activa">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Marca Activa
                                </label>
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
                                Actualizar Marca
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
                        <strong>ID:</strong> {{ $marca->id }}
                    </p>
                    <p class="mb-2">
                        <strong>Estado:</strong><br>
                        @if($marca->activa)
                            <span class="badge bg-success">Activa</span>
                        @else
                            <span class="badge bg-danger">Inactiva</span>
                        @endif
                    </p>
                    <p class="mb-0">
                        <strong>Productos Asociados:</strong><br>
                        <span class="badge bg-primary">{{ $marca->cantidadProductos() }} productos</span>
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
                        Si desactivas esta marca, no aparecerá en el listado de marcas 
                        al crear nuevos productos, pero los productos existentes con esta 
                        marca no se verán afectados.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection