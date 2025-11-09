@extends('layouts.app')

@section('title', 'Editar Producto - Paints')

@section('content')
<div class="container-fluid">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('productos.index') }}">Productos</a></li>
            <li class="breadcrumb-item active">Editar Producto</li>
        </ol>
    </nav>

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-pencil-square me-2"></i>
            Editar Producto: {{ $producto->descripcion }}
        </h2>
        <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary">
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
                    Información del Producto
                </div>
                <div class="card-body">
                    <form action="{{ route('productos.update', $producto) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Información Básica --}}
                        <h5 class="mb-3 text-muted">
                            <i class="bi bi-info-circle me-2"></i>
                            Información Básica
                        </h5>

                        <div class="row mb-3">
                            {{-- Código SKU --}}
                            <div class="col-md-6">
                                <label for="codigo_sku" class="form-label">
                                    Código SKU <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('codigo_sku') is-invalid @enderror" 
                                       id="codigo_sku" 
                                       name="codigo_sku" 
                                       value="{{ old('codigo_sku', $producto->codigo_sku) }}" 
                                       required>
                                @error('codigo_sku')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tamaño --}}
                            <div class="col-md-6">
                                <label for="tamano" class="form-label">Tamaño</label>
                                <input type="text" 
                                       class="form-control @error('tamano') is-invalid @enderror" 
                                       id="tamano" 
                                       name="tamano" 
                                       value="{{ old('tamano', $producto->tamano) }}">
                                @error('tamano')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            {{-- Descripción --}}
                            <label for="descripcion" class="form-label">
                                Descripción <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                      id="descripcion" 
                                      name="descripcion" 
                                      rows="2"
                                      required>{{ old('descripcion', $producto->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Clasificación --}}
                        <h5 class="mb-3 text-muted mt-4">
                            <i class="bi bi-tags me-2"></i>
                            Clasificación
                        </h5>

                        <div class="row mb-3">
                            {{-- Categoría --}}
                            <div class="col-md-6">
                                <label for="categoria_id" class="form-label">
                                    Categoría <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('categoria_id') is-invalid @enderror" 
                                        id="categoria_id" 
                                        name="categoria_id" 
                                        required>
                                    <option value="">Seleccione una categoría</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" 
                                                {{ old('categoria_id', $producto->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categoria_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Marca --}}
                            <div class="col-md-6">
                                <label for="marca_id" class="form-label">
                                    Marca <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('marca_id') is-invalid @enderror" 
                                        id="marca_id" 
                                        name="marca_id" 
                                        required>
                                    <option value="">Seleccione una marca</option>
                                    @foreach($marcas as $marca)
                                        <option value="{{ $marca->id }}" 
                                                {{ old('marca_id', $producto->marca_id) == $marca->id ? 'selected' : '' }}>
                                            {{ $marca->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('marca_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Características Especiales --}}
                        <h5 class="mb-3 text-muted mt-4">
                            <i class="bi bi-palette me-2"></i>
                            Características Especiales
                        </h5>

                        <div class="mb-3">
                            {{-- Color --}}
                            <label for="color" class="form-label">Color</label>
                            <input type="text" 
                                   class="form-control @error('color') is-invalid @enderror" 
                                   id="color" 
                                   name="color" 
                                   value="{{ old('color', $producto->color) }}"
                                   placeholder="Ej: Blanco, Azul Marino">
                            @error('color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            {{-- Duración en años --}}
                            <div class="col-md-6">
                                <label for="duracion_anios" class="form-label">Duración (años)</label>
                                <input type="number" 
                                       class="form-control @error('duracion_anios') is-invalid @enderror" 
                                       id="duracion_anios" 
                                       name="duracion_anios" 
                                       value="{{ old('duracion_anios', $producto->duracion_anios) }}"
                                       min="0">
                                @error('duracion_anios')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Extensión m² --}}
                            <div class="col-md-6">
                                <label for="extension_m2" class="form-label">Extensión (m²)</label>
                                <input type="number" 
                                       step="0.01"
                                       class="form-control @error('extension_m2') is-invalid @enderror" 
                                       id="extension_m2" 
                                       name="extension_m2" 
                                       value="{{ old('extension_m2', $producto->extension_m2) }}"
                                       min="0">
                                @error('extension_m2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
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
                                       id="activo" 
                                       name="activo"
                                       value="1"
                                       {{ old('activo', $producto->activo) ? 'checked' : '' }}>
                                <label class="form-check-label" for="activo">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Producto Activo
                                </label>
                            </div>
                        </div>

                        {{-- Botones --}}
                        <hr class="my-4">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('productos.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>
                                Actualizar Producto
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
                        <strong>ID:</strong> {{ $producto->id }}
                    </p>
                    <p class="mb-2">
                        <strong>SKU:</strong> <code>{{ $producto->codigo_sku }}</code>
                    </p>
                    <p class="mb-2">
                        <strong>Fecha de Registro:</strong><br>
                        {{ $producto->created_at->format('d/m/Y H:i') }}
                    </p>
                    <p class="mb-0">
                        <strong>Última Actualización:</strong><br>
                        {{ $producto->updated_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-box me-2"></i>
                    Información Actual
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <strong>Categoría Actual:</strong><br>
                        {{ $producto->categoria ? $producto->categoria->nombre : 'Sin categoría' }}
                    </p>
                    <p class="mb-2">
                        <strong>Marca Actual:</strong><br>
                        {{ $producto->marca ? $producto->marca->nombre : 'Sin marca' }}
                    </p>
                    <p class="mb-0">
                        <strong>Estado:</strong><br>
                        @if($producto->activo)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-danger">Inactivo</span>
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
                        Si cambias la categoría o marca, asegúrate de que el producto siga 
                        teniendo sentido en su nueva clasificación. Los cambios afectarán 
                        los reportes y búsquedas.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection