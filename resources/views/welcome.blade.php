@extends('layouts.public')

@section('title', 'Inicio - Paints')

@push('styles')
<style>
    /* Estilos para la paginación */
    .pagination {
        margin-bottom: 0;
    }

    .pagination .page-link {
        color: var(--accent);
        border-color: #dee2e6;
        padding: 0.5rem 0.75rem;
        font-size: 1rem;
    }

    .pagination .page-item.active .page-link {
        background-color: var(--accent);
        border-color: var(--accent);
        color: white;
    }

    .pagination .page-link:hover {
        color: var(--accent-dark);
        background-color: #e9ecef;
        border-color: #dee2e6;
    }

    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background-color: #fff;
        border-color: #dee2e6;
    }
</style>
@endpush

@section('content')
{{-- HERO SECTION --}}
<section class="bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-3">Bienvenido a Paints</h1>
                <p class="lead text-muted mb-4">
                    Descubre nuestra amplia selección de pinturas de calidad para todos tus proyectos.
                    Pinturas de interior, exterior, barnices y más.
                </p>
                <a href="#productos" class="btn btn-primary btn-lg">
                    <i class="bi bi-arrow-down-circle me-2"></i>
                    Ver Productos
                </a>
            </div>
            <div class="col-lg-6 text-center">
                <i class="bi bi-paint-bucket display-1 text-primary"></i>
            </div>
        </div>
    </div>
</section>

{{-- SECCIÓN DE PRODUCTOS --}}
<section class="py-5" id="productos">
    <div class="container">
        {{-- Título de sección --}}
        <div class="text-center mb-5">
            <h2 class="fw-bold">Nuestros Productos</h2>
            <p class="text-muted">Explora nuestro catálogo completo</p>
        </div>

        {{-- Filtros y búsqueda --}}
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('home') }}">
                    <div class="row g-3">
                        {{-- Búsqueda por texto --}}
                        <div class="col-md-4">
                            <label class="form-label">
                                <i class="bi bi-search"></i> Buscar
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                name="search"
                                placeholder="Buscar por nombre o código..."
                                value="{{ request('search') }}"
                            >
                        </div>

                        {{-- Filtro por categoría --}}
                        <div class="col-md-3">
                            <label class="form-label">
                                <i class="bi bi-tags"></i> Categoría
                            </label>
                            <select class="form-select" name="categoria">
                                <option value="">Todas las categorías</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}"
                                        {{ request('categoria') == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Filtro por marca --}}
                        <div class="col-md-3">
                            <label class="form-label">
                                <i class="bi bi-award"></i> Marca
                            </label>
                            <select class="form-select" name="marca">
                                <option value="">Todas las marcas</option>
                                @foreach($marcas as $marca)
                                    <option value="{{ $marca->id }}"
                                        {{ request('marca') == $marca->id ? 'selected' : '' }}>
                                        {{ $marca->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Botones --}}
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-funnel"></i> Filtrar
                            </button>
                        </div>
                    </div>

                    {{-- Botón para limpiar filtros --}}
                    @if(request()->hasAny(['search', 'categoria', 'marca']))
                        <div class="row mt-2">
                            <div class="col-12">
                                <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-x-circle"></i> Limpiar filtros
                                </a>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        {{-- Grid de productos --}}
        @if($productos->count() > 0)
            <div class="row g-4">
                @foreach($productos as $producto)
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="card product-card">
                            {{-- Imagen del producto --}}
                            @if($producto->imagen)
                                <img
                                    src="{{ asset('storage/' . $producto->imagen) }}"
                                    class="card-img-top product-img"
                                    alt="{{ $producto->descripcion }}"
                                >
                            @else
                                <div class="product-img-placeholder">
                                    <i class="bi bi-paint-bucket"></i>
                                </div>
                            @endif

                            <div class="card-body">
                                {{-- Categoría --}}
                                @if($producto->categoria)
                                    <span class="badge badge-categoria mb-2">
                                        {{ $producto->categoria->nombre }}
                                    </span>
                                @endif

                                {{-- Nombre del producto --}}
                                <h5 class="card-title mb-2">{{ $producto->descripcion }}</h5>

                                {{-- Marca --}}
                                @if($producto->marca)
                                    <p class="text-muted small mb-2">
                                        <i class="bi bi-award"></i> {{ $producto->marca->nombre }}
                                    </p>
                                @endif

                                {{-- Especificaciones --}}
                                <div class="small text-muted">
                                    @if($producto->tamano)
                                        <i class="bi bi-box"></i> {{ $producto->tamano }}<br>
                                    @endif
                                    @if($producto->color)
                                        <i class="bi bi-palette"></i> {{ $producto->color }}<br>
                                    @endif
                                    @if($producto->extension_m2)
                                        <i class="bi bi-rulers"></i> {{ $producto->extension_m2 }} m²<br>
                                    @endif
                                    @if($producto->duracion_anios)
                                        <i class="bi bi-clock"></i> {{ $producto->duracion_anios }} años
                                    @endif
                                </div>

                                {{-- Código SKU --}}
                                <p class="text-muted small mt-2 mb-0">
                                    <strong>SKU:</strong> {{ $producto->codigo_sku }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Paginación --}}
            <div class="d-flex justify-content-center mt-5">
                {{ $productos->appends(request()->query())->links() }}
            </div>
        @else
            {{-- Mensaje cuando no hay productos --}}
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle me-2"></i>
                No se encontraron productos que coincidan con los filtros seleccionados.
                <a href="{{ route('home') }}" class="alert-link">Ver todos los productos</a>
            </div>
        @endif
    </div>
</section>

{{-- SECCIÓN DE CARACTERÍSTICAS --}}
<section class="bg-light py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <i class="bi bi-check-circle display-4 text-primary mb-3"></i>
                <h5>Calidad Garantizada</h5>
                <p class="text-muted">
                    Trabajamos con las mejores marcas del mercado
                </p>
            </div>
            <div class="col-md-4 mb-4">
                <i class="bi bi-truck display-4 text-primary mb-3"></i>
                <h5>Envío Disponible</h5>
                <p class="text-muted">
                    Llevamos tus productos a donde lo necesites
                </p>
            </div>
            <div class="col-md-4 mb-4">
                <i class="bi bi-headset display-4 text-primary mb-3"></i>
                <h5>Asesoría Experta</h5>
                <p class="text-muted">
                    Nuestro equipo está listo para ayudarte
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
