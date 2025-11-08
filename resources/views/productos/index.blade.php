@extends('layouts.app')

@section('title', 'Productos - Paints')

@section('content')
<div class="container-fluid">
    {{-- Encabezado de la página --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-box-seam me-2"></i>
            Gestión de Productos
        </h2>
        {{-- Botón para crear nuevo producto --}}
        <a href="{{ route('productos.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>
            Nuevo Producto
        </a>
    </div>

    {{-- Filtros (opcional para mejorar) --}}
    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('productos.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="categoria" class="form-label">Filtrar por Categoría</label>
                    <select class="form-select" id="categoria" name="categoria">
                        <option value="">Todas las categorías</option>
                        {{-- Aquí irían las categorías dinámicamente --}}
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="marca" class="form-label">Filtrar por Marca</label>
                    <select class="form-select" id="marca" name="marca">
                        <option value="">Todas las marcas</option>
                        {{-- Aquí irían las marcas dinámicamente --}}
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="estado" class="form-label">Estado</label>
                    <select class="form-select" id="estado" name="estado">
                        <option value="">Todos</option>
                        <option value="1">Activos</option>
                        <option value="0">Inactivos</option>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-search me-1"></i>
                        Buscar
                    </button>
                    <a href="{{ route('productos.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-x-circle me-1"></i>
                        Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Card con la tabla --}}
    <div class="card">
        <div class="card-header">
            <i class="bi bi-table me-2"></i>
            Listado de Productos
        </div>
        <div class="card-body">
            {{-- Tabla responsive --}}
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>SKU</th>
                            <th>Descripción</th>
                            <th>Categoría</th>
                            <th>Marca</th>
                            <th>Color</th>
                            <th>Tamaño</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productos as $producto)
                            <tr>
                                <td>{{ $producto->id }}</td>
                                <td>
                                    <code>{{ $producto->codigo_sku }}</code>
                                </td>
                                <td>
                                    <strong>{{ $producto->descripcion }}</strong>
                                    @if($producto->duracion_anios || $producto->extension_m2)
                                        <br>
                                        <small class="text-muted">
                                            @if($producto->duracion_anios)
                                                <i class="bi bi-clock me-1"></i>{{ $producto->duracion_anios }} años
                                            @endif
                                            @if($producto->extension_m2)
                                                <i class="bi bi-rulers me-1"></i>{{ $producto->extension_m2 }} m²
                                            @endif
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    @if($producto->categoria)
                                        <span class="badge bg-info">{{ $producto->categoria->nombre }}</span>
                                    @else
                                        <span class="text-muted">Sin categoría</span>
                                    @endif
                                </td>
                                <td>
                                    @if($producto->marca)
                                        <span class="badge bg-secondary">{{ $producto->marca->nombre }}</span>
                                    @else
                                        <span class="text-muted">Sin marca</span>
                                    @endif
                                </td>
                                <td>
                                    @if($producto->color)
                                        <span class="badge" style="background-color: {{ $producto->color }}; color: #fff;">
                                            {{ $producto->color }}
                                        </span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>{{ $producto->tamano ?? 'N/A' }}</td>
                                <td>
                                    @if($producto->activo)
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>
                                            Activo
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="bi bi-x-circle me-1"></i>
                                            Inactivo
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{-- Botones de acción --}}
                                    <div class="btn-group" role="group">
                                        {{-- Ver detalles --}}
                                        <a href="{{ route('productos.show', $producto) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        
                                        {{-- Editar --}}
                                        <a href="{{ route('productos.edit', $producto) }}" 
                                           class="btn btn-sm btn-warning" 
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        
                                        {{-- Eliminar --}}
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="confirmarEliminacion({{ $producto->id }})"
                                                title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    {{-- Formulario oculto para eliminar --}}
                                    <form id="form-eliminar-{{ $producto->id }}" 
                                          action="{{ route('productos.destroy', $producto) }}" 
                                          method="POST" 
                                          class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            {{-- Mensaje cuando no hay productos --}}
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                    <p class="text-muted mb-0">No hay productos registrados</p>
                                    <a href="{{ route('productos.create') }}" class="btn btn-primary btn-sm mt-2">
                                        <i class="bi bi-plus-circle me-1"></i>
                                        Crear primer producto
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            @if($productos->hasPages())
                <div class="mt-3">
                    {{ $productos->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Información sobre tipos de productos --}}
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Tipos de productos:</strong>
                <ul class="mb-0 mt-2">
                    <li><strong>Accesorios:</strong> Brochas, rodillos, bandejas (se venden por unidad)</li>
                    <li><strong>Solventes:</strong> Aguarrás, limpiador (medidas: 1/32, 1/16, 1/8, 1/4, 1/2 galón)</li>
                    <li><strong>Pinturas:</strong> Base agua, base aceite (incluyen color, duración y extensión)</li>
                    <li><strong>Barnices:</strong> Sintético, acrílico (medidas en galones)</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    /**
     * Confirmar eliminación de producto
     * 
     * Muestra un cuadro de confirmación antes de eliminar un producto.
     * Verifica que no tenga presentaciones o inventarios asociados.
     * 
     * @param {number} id - ID del producto a eliminar
     */
    function confirmarEliminacion(id) {
        if (confirm('¿Estás seguro de eliminar este producto?\n\nSe verificará que no tenga:\n- Presentaciones asociadas\n- Inventarios en sucursales\n\nEsta acción no se puede deshacer.')) {
            document.getElementById('form-eliminar-' + id).submit();
        }
    }
</script>
@endpush