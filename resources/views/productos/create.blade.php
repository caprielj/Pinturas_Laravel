@extends('layouts.app')

@section('title', 'Nuevo Producto - Paints')

@section('content')
<div class="container-fluid">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('productos.index') }}">Productos</a></li>
            <li class="breadcrumb-item active">Nuevo Producto</li>
        </ol>
    </nav>

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-box-seam me-2"></i>
            Nuevo Producto
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
                    <form action="{{ route('productos.store') }}" method="POST">
                        @csrf

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
                                       value="{{ old('codigo_sku') }}" 
                                       required
                                       placeholder="Ej: PINT-SW-001">
                                <small class="text-muted">Código único del producto</small>
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
                                       value="{{ old('tamano') }}"
                                       placeholder="Ej: 2 pulgadas, Mediano">
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
                                      required
                                      placeholder="Descripción detallada del producto">{{ old('descripcion') }}</textarea>
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
                                        <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
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
                                        <option value="{{ $marca->id }}" {{ old('marca_id') == $marca->id ? 'selected' : '' }}>
                                            {{ $marca->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('marca_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Características Especiales (para Pinturas y Barnices) --}}
                        <h5 class="mb-3 text-muted mt-4">
                            <i class="bi bi-palette me-2"></i>
                            Características Especiales
                        </h5>

                        <div class="alert alert-info mb-3">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Nota:</strong> Los siguientes campos son opcionales y aplican principalmente para pinturas y barnices.
                        </div>

                        <div class="mb-3">
                            {{-- Color --}}
                            <label for="color" class="form-label">Color</label>
                            <input type="text" 
                                   class="form-control @error('color') is-invalid @enderror" 
                                   id="color" 
                                   name="color" 
                                   value="{{ old('color') }}"
                                   placeholder="Ej: Blanco, Azul Marino, Verde Limón">
                            <small class="text-muted">Solo para pinturas y barnices</small>
                            @error('color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            {{-- Duración en años --}}
                            <div class="col-md-6">
                                <label for="duracion_anios" class="form-label">
                                    Duración (años)
                                    <i class="bi bi-info-circle text-muted" 
                                       title="Tiempo estimado de duración del producto"
                                       data-bs-toggle="tooltip"></i>
                                </label>
                                <input type="number" 
                                       class="form-control @error('duracion_anios') is-invalid @enderror" 
                                       id="duracion_anios" 
                                       name="duracion_anios" 
                                       value="{{ old('duracion_anios') }}"
                                       min="0"
                                       placeholder="Ej: 5">
                                @error('duracion_anios')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Extensión m² --}}
                            <div class="col-md-6">
                                <label for="extension_m2" class="form-label">
                                    Extensión (m²)
                                    <i class="bi bi-info-circle text-muted" 
                                       title="Metros cuadrados que cubre el producto"
                                       data-bs-toggle="tooltip"></i>
                                </label>
                                <input type="number" 
                                       step="0.01"
                                       class="form-control @error('extension_m2') is-invalid @enderror" 
                                       id="extension_m2" 
                                       name="extension_m2" 
                                       value="{{ old('extension_m2') }}"
                                       min="0"
                                       placeholder="Ej: 12.5">
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
                                       {{ old('activo', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="activo">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Producto Activo
                                </label>
                                <small class="text-muted d-block">
                                    Solo los productos activos pueden venderse
                                </small>
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
                                Guardar Producto
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
                    Campos Obligatorios
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>Código SKU (debe ser único)</li>
                        <li>Descripción del producto</li>
                        <li>Categoría</li>
                        <li>Marca</li>
                    </ul>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-lightbulb me-2"></i>
                    Tipos de Productos
                </div>
                <div class="card-body">
                    <h6 class="card-title">Accesorios</h6>
                    <p class="small mb-2">Brochas, rodillos, bandejas. Se venden por unidad.</p>

                    <h6 class="card-title">Solventes</h6>
                    <p class="small mb-2">Aguarrás, limpiador. Medidas en fracciones de galón.</p>

                    <h6 class="card-title">Pinturas</h6>
                    <p class="small mb-2">Base agua, aceite. Incluyen color, duración y extensión.</p>

                    <h6 class="card-title">Barnices</h6>
                    <p class="small mb-0">Sintético, acrílico. Medidas en galones.</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Importante
                </div>
                <div class="card-body">
                    <p class="small mb-0">
                        El código SKU debe ser único en el sistema. 
                        Te recomendamos usar un formato como: <code>CAT-MARCA-NUM</code>
                        <br><br>
                        Ejemplo: <code>PINT-SW-001</code> para Pintura Sherwin Williams #001
                    </p>
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
     */
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush