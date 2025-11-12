{{-- 
    VISTA SHOW - DETALLE DE UN PRODUCTO
    Muestra información completa del producto: datos, clasificación, características
--}}

{{-- @extends: Hereda la estructura del layout principal --}}
@extends('layouts.app')

{{-- @section inline: Define título de la página --}}
@section('title', 'Detalles Producto - Paints')

{{-- @section: Define el bloque de contenido --}}
@section('content')
<div class="container-fluid">
    {{-- Breadcrumb: Navegación de migas de pan --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('productos.index') }}">Productos</a></li>
            {{-- {{ }}: Muestra descripción del producto en breadcrumb --}}
            <li class="breadcrumb-item active">{{ $producto->descripcion }}</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-box-seam me-2"></i>
            Detalles del Producto
        </h2>
        <div>
            {{-- route() con parámetro: Genera URL para editar --}}
            <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-2"></i>
                Editar
            </a>
            <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Volver
            </a>
        </div>
    </div>

    <div class="row">
        {{-- Columna Principal: Información del Producto --}}
        <div class="col-lg-8">
            {{-- Card: Información Básica --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-info-circle me-2"></i>
                    Información del Producto
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Código SKU</label>
                            {{-- <code>: Muestra SKU con estilo de código --}}
                            <p class="mb-0"><code class="fs-5">{{ $producto->codigo_sku }}</code></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Estado</label>
                            {{-- @if: Muestra badge según estado activo/inactivo --}}
                            <p class="mb-0">
                                @if($producto->activo)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-danger">Inactivo</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="text-muted small">Descripción</label>
                            <p class="mb-0 fw-bold">{{ $producto->descripcion }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Tamaño</label>
                            {{-- ?? 'texto': Si es null muestra texto por defecto --}}
                            <p class="mb-0">{{ $producto->tamano ?? 'No especificado' }}</p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="text-muted small">Imagen del Producto</label>
                            {{-- Muestra imagen del producto si existe --}}
                            @if($producto->imagen)
                                <div>
                                    <img src="{{ asset('storage/' . $producto->imagen) }}"
                                         alt="Imagen de {{ $producto->descripcion }}"
                                         class="img-thumbnail"
                                         style="max-width: 300px; max-height: 300px;">
                                </div>
                            @else
                                <p class="mb-0 text-muted">Sin imagen</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card: Clasificación (Categoría y Marca) --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-tags me-2"></i>
                    Clasificación
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Categoría</label>
                            {{-- @if: Verifica si tiene categoría asociada --}}
                            <p class="mb-0">
                                @if($producto->categoria)
                                    {{-- $producto->categoria: Relación belongsTo (Eager Loading) --}}
                                    <span class="badge bg-info fs-6">{{ $producto->categoria->nombre }}</span>
                                @else
                                    Sin categoría
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Marca</label>
                            {{-- @if: Verifica si tiene marca asociada --}}
                            <p class="mb-0">
                                @if($producto->marca)
                                    <span class="badge bg-secondary fs-6">{{ $producto->marca->nombre }}</span>
                                @else
                                    Sin marca
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- @if con ||: Muestra card solo si existe color O duración O extensión --}}
            @if($producto->color || $producto->duracion_anios || $producto->extension_m2)
                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-palette me-2"></i>
                        Características Especiales
                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- @if: Muestra color solo si existe --}}
                            @if($producto->color)
                                <div class="col-md-12 mb-3">
                                    <label class="text-muted small">Color</label>
                                    <p class="mb-0">{{ $producto->color }}</p>
                                </div>
                            @endif

                            {{-- @if: Muestra duración solo si existe --}}
                            @if($producto->duracion_anios)
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Duración</label>
                                    <p class="mb-0"><strong>{{ $producto->duracion_anios }}</strong> años</p>
                                </div>
                            @endif

                            {{-- @if: Muestra extensión solo si existe --}}
                            @if($producto->extension_m2)
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Extensión</label>
                                    <p class="mb-0"><strong>{{ $producto->extension_m2 }}</strong> m²</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Columna Lateral: Información del Registro y Acciones --}}
        <div class="col-lg-4">
            {{-- Card: Información del Registro --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-info-circle me-2"></i>
                    Información del Registro
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">ID</label>
                        <p class="mb-0"><code>#{{ $producto->id }}</code></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Fecha de Registro</label>
                        {{-- ->format(): Método de Carbon para formatear fechas --}}
                        <p class="mb-0">{{ $producto->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="text-muted small">Última Actualización</label>
                        <p class="mb-0">{{ $producto->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            {{-- Card: Acciones --}}
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-gear me-2"></i>
                    Acciones
                </div>
                <div class="card-body">
                    {{-- d-grid gap-2: Botones en columna con espacio entre ellos --}}
                    <div class="d-grid gap-2">
                        <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil me-2"></i>
                            Editar
                        </a>
                        
                        {{-- Botón eliminar con confirmación JavaScript --}}
                        <button type="button" 
                                class="btn btn-danger btn-sm" 
                                onclick="eliminar()">
                            <i class="bi bi-trash me-2"></i>
                            Eliminar
                        </button>

                        <hr class="my-2">

                        <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left me-2"></i>
                            Volver al Listado
                        </a>
                    </div>

                    {{-- Formulario oculto para eliminación --}}
                    {{-- d-none: Oculta el formulario (display: none) --}}
                    <form id="delete-form" 
                          action="{{ route('productos.destroy', $producto->id) }}" 
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
{{-- @endsection: Cierra el bloque de contenido --}}
@endsection

{{-- @push('scripts'): Inyecta scripts al final del layout --}}
@push('scripts')
<script>
    // Función JavaScript para confirmar eliminación
    function eliminar() {
        if (confirm('¿Estás seguro de eliminar este producto?')) {
            document.getElementById('delete-form').submit();
        }
    }
</script>
@endpush