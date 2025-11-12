{{-- 
    VISTA EDIT - FORMULARIO EDITAR PRODUCTO
    Usa @method('PUT') para actualizar, carga valores existentes de BD
--}}

{{-- @extends: Hereda estructura del layout --}}
@extends('layouts.app')

{{-- @section inline: Define título de la página --}}
@section('title', 'Editar Producto - Paints')

{{-- @section: Bloque de contenido principal --}}
@section('content')
<div class="container-fluid">
    {{-- Breadcrumb: Navegación de migas de pan --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('productos.index') }}">Productos</a></li>
            <li class="breadcrumb-item active">Editar</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-pencil-square me-2"></i>
            Editar Producto
        </h2>
        <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>
            Volver
        </a>
    </div>

    <div class="row">
        {{-- Columna Principal: Formulario --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    {{-- @method('PUT'): Simula método HTTP PUT para actualizar --}}
                    {{-- enctype="multipart/form-data": Necesario para subir archivos --}}
                    <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="codigo_sku" class="form-label">Código SKU <span class="text-danger">*</span></label>
                                {{-- old('campo', $default): Prioriza valor anterior, si no usa valor de BD --}}
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
                            <label for="descripcion" class="form-label">Descripción <span class="text-danger">*</span></label>
                            {{-- textarea: Campo multilínea con valor de BD --}}
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                      id="descripcion" 
                                      name="descripcion" 
                                      rows="2"
                                      required>{{ old('descripcion', $producto->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="categoria_id" class="form-label">Categoría <span class="text-danger">*</span></label>
                                {{-- <select>: Lista desplegable con categorías --}}
                                <select class="form-select @error('categoria_id') is-invalid @enderror" 
                                        id="categoria_id" 
                                        name="categoria_id" 
                                        required>
                                    <option value="">Seleccione</option>
                                    {{-- @foreach: Itera sobre categorías --}}
                                    @foreach($categorias as $categoria)
                                        {{-- Compara con valor actual de BD para marcar selected --}}
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

                            <div class="col-md-6">
                                <label for="marca_id" class="form-label">Marca <span class="text-danger">*</span></label>
                                <select class="form-select @error('marca_id') is-invalid @enderror" 
                                        id="marca_id" 
                                        name="marca_id" 
                                        required>
                                    <option value="">Seleccione</option>
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

                        <div class="mb-3">
                            <label for="color" class="form-label">Color</label>
                            <input type="text"
                                   class="form-control @error('color') is-invalid @enderror"
                                   id="color"
                                   name="color"
                                   value="{{ old('color', $producto->color) }}">
                            @error('color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="imagen" class="form-label">Imagen del Producto</label>
                            {{-- Mostrar imagen actual si existe --}}
                            @if($producto->imagen)
                                <div class="mb-2">
                                    <p class="small text-muted mb-1">Imagen actual:</p>
                                    {{-- asset('storage/'): Genera URL para archivos públicos --}}
                                    <img src="{{ asset('storage/' . $producto->imagen) }}"
                                         alt="Imagen del producto"
                                         class="img-thumbnail"
                                         style="max-width: 200px; max-height: 200px;">
                                </div>
                            @endif

                            {{-- Input para cambiar la imagen --}}
                            <input type="file"
                                   class="form-control @error('imagen') is-invalid @enderror"
                                   id="imagen"
                                   name="imagen"
                                   accept="image/*">
                            <small class="text-muted">Formatos: JPG, PNG, GIF. Tamaño máximo: 2MB. Dejar vacío para mantener la imagen actual.</small>
                            @error('imagen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="duracion_anios" class="form-label">Duración (años)</label>
                                {{-- type="number" min="0": Solo números positivos --}}
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

                            <div class="col-md-6">
                                <label for="extension_m2" class="form-label">Extensión (m²)</label>
                                {{-- step="0.01": Permite decimales de 2 dígitos --}}
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

                        <div class="mb-3">
                            {{-- form-check-switch: Estilo toggle para checkbox --}}
                            {{-- Operador ternario: Si es true agrega 'checked' --}}
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="activo" 
                                       name="activo"
                                       {{ old('activo', $producto->activo) ? 'checked' : '' }}>
                                <label class="form-check-label" for="activo">
                                    Producto Activo
                                </label>
                            </div>
                        </div>

                        <hr class="my-4">
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('productos.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>
                                Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Columna Lateral: Información del Producto --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-info-circle me-2"></i>
                    Información
                </div>
                <div class="card-body">
                    {{-- Muestra datos del producto --}}
                    <p class="mb-2"><strong>ID:</strong> {{ $producto->id }}</p>
                    {{-- <code>: Muestra SKU con estilo de código --}}
                    <p class="mb-2"><strong>SKU:</strong> <code>{{ $producto->codigo_sku }}</code></p>
                    {{-- ->format(): Método de Carbon para formatear fechas --}}
                    <p class="mb-2"><strong>Registrado:</strong> {{ $producto->created_at->format('d/m/Y') }}</p>
                    <p class="mb-0"><strong>Actualizado:</strong> {{ $producto->updated_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- @endsection: Cierra el bloque de contenido --}}
@endsection