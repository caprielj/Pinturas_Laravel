@extends('layouts.app')

@section('title', 'Nueva Categoría - Paints')

@section('content')
<div class="container-fluid">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categorias.index') }}">Categorías</a></li>
            <li class="breadcrumb-item active">Nueva Categoría</li>
        </ol>
    </nav>

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-tag me-2"></i>
            Nueva Categoría
        </h2>
        <a href="{{ route('categorias.index') }}" class="btn btn-outline-secondary">
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
                    Información de la Categoría
                </div>
                <div class="card-body">
                    <form action="{{ route('categorias.store') }}" method="POST">
                        @csrf

                        {{-- Nombre --}}
                        <div class="mb-3">
                            <label for="nombre" class="form-label">
                                Nombre de la Categoría <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" 
                                   name="nombre" 
                                   value="{{ old('nombre') }}" 
                                   required
                                   placeholder="Ej: Pinturas de Interior">
                            <small class="text-muted">El nombre debe ser único en el sistema</small>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Descripción --}}
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                      id="descripcion" 
                                      name="descripcion" 
                                      rows="3"
                                      placeholder="Descripción breve de la categoría (opcional)">{{ old('descripcion') }}</textarea>
                            <small class="text-muted">Máximo 255 caracteres</small>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Botones --}}
                        <hr class="my-4">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('categorias.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>
                                Guardar Categoría
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
                        <li>Nombre de la categoría (debe ser único)</li>
                    </ul>

                    <h6 class="card-title">¿Para qué sirve?</h6>
                    <p class="small mb-0">
                        Las categorías permiten organizar los productos de manera lógica, 
                        facilitando su búsqueda y gestión en el sistema.
                    </p>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-lightbulb me-2"></i>
                    Ejemplos de Categorías
                </div>
                <div class="card-body">
                    <ul class="small mb-0">
                        <li>Pinturas de Interior</li>
                        <li>Pinturas de Exterior</li>
                        <li>Esmaltes</li>
                        <li>Impermeabilizantes</li>
                        <li>Accesorios</li>
                        <li>Solventes</li>
                        <li>Barnices</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection