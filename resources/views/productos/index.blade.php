{{-- 
    Vista: clientes/index.blade.php
    
    Descripción: Muestra el listado de todos los clientes registrados
    
    Variables recibidas desde el controlador:
    - $clientes: Collection con todos los clientes
    
    Iconos Bootstrap Icons usados:
    - bi-people: Ícono de personas (grupo)
    - bi-plus-circle: Ícono de agregar
    - bi-envelope: Ícono de email
    - bi-telephone: Ícono de teléfono
    - bi-check-circle: Ícono de verificado
    - bi-clock: Ícono de reloj (pendiente)
    - bi-bell: Ícono de notificaciones
    - bi-eye: Ícono de ver
    - bi-pencil: Ícono de editar
    - bi-trash: Ícono de eliminar
--}}

{{-- 
    VISTA INDEX - LISTADO DE PRODUCTOS
    Muestra todos los productos en tabla con paginación y opciones CRUD
--}}

{{-- @extends: Hereda la estructura del layout principal --}}
@extends('layouts.app')

{{-- @section inline: Define título de la página --}}
@section('title', 'Productos - Paints')

{{-- @section: Define el bloque de contenido principal --}}
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-box-seam me-2"></i>
            Productos
        </h2>
        {{-- route(): Genera URL para crear nuevo producto --}}
        <a href="{{ route('productos.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>
            Nuevo Producto
        </a>
    </div>

    {{-- @if: Muestra alerta si existe mensaje de éxito en sesión --}}
    {{-- session('success'): Obtiene mensaje flash de la sesión --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            {{-- data-bs-dismiss: Atributo de Bootstrap para cerrar alerta --}}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- @if: Muestra alerta de error si existe --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <i class="bi bi-table me-2"></i>
            Listado de Productos
        </div>
        <div class="card-body">
            {{-- table-responsive: Hace la tabla desplazable en pantallas pequeñas --}}
            <div class="table-responsive">
                {{-- table-hover: Efecto hover en filas, table-striped: Filas alternadas --}}
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>SKU</th>
                            <th>Imagen</th>
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
                        {{-- @forelse: Bucle foreach con caso vacío integrado --}}
                        {{-- $productos: Colección paginada pasada desde el controlador --}}
                        @forelse($productos as $producto)
                            <tr>
                                <td>{{ $producto->id }}</td>
                                {{-- <code>: Muestra SKU con estilo de código --}}
                                <td><code>{{ $producto->codigo_sku }}</code></td>
                                <td>
                                    {{-- Muestra imagen del producto si existe --}}
                                    @if($producto->imagen)
                                        <img src="{{ asset('storage/' . $producto->imagen) }}"
                                             alt="Imagen del producto"
                                             class="img-thumbnail"
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <span class="text-muted small">Sin imagen</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $producto->descripcion }}</strong>
                                    {{-- @if con ||: Muestra info adicional si existe duración O extensión --}}
                                    @if($producto->duracion_anios || $producto->extension_m2)
                                        <br>
                                        <small class="text-muted">
                                            @if($producto->duracion_anios)
                                                {{ $producto->duracion_anios }} años
                                            @endif
                                            @if($producto->extension_m2)
                                                / {{ $producto->extension_m2 }} m²
                                            @endif
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    {{-- @if: Verifica si tiene categoría asociada --}}
                                    @if($producto->categoria)
                                        {{-- $producto->categoria: Relación belongsTo cargada con Eager Loading --}}
                                        <span class="badge bg-info">{{ $producto->categoria->nombre }}</span>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    {{-- @if: Verifica si tiene marca asociada --}}
                                    @if($producto->marca)
                                        <span class="badge bg-secondary">{{ $producto->marca->nombre }}</span>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                {{-- ?? 'N/A': Si es null muestra N/A --}}
                                <td>{{ $producto->color ?? 'N/A' }}</td>
                                <td>{{ $producto->tamano ?? 'N/A' }}</td>
                                <td>
                                    {{-- @if: Muestra badge según estado activo/inactivo --}}
                                    @if($producto->activo)
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{-- btn-group: Agrupa botones horizontalmente --}}
                                    <div class="btn-group" role="group">
                                        {{-- Botón Ver --}}
                                        <a href="{{ route('productos.show', $producto->id) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="Ver">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        {{-- Botón Editar --}}
                                        <a href="{{ route('productos.edit', $producto->id) }}" 
                                           class="btn btn-sm btn-warning" 
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        {{-- Botón Eliminar con confirmación JavaScript --}}
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="eliminar({{ $producto->id }})"
                                                title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    {{-- Formulario oculto para eliminación --}}
                                    {{-- d-none: Oculta el formulario (display: none) --}}
                                    <form id="delete-form-{{ $producto->id }}" 
                                          action="{{ route('productos.destroy', $producto->id) }}" 
                                          method="POST" 
                                          class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        {{-- @empty: Se ejecuta si $productos está vacío --}}
                        @empty
                            <tr>
                                {{-- colspan="9": Fusiona 9 columnas --}}
                                <td colspan="9" class="text-center py-4">
                                    <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                    <p class="text-muted mb-0">No hay productos registrados</p>
                                </td>
                            </tr>
                        {{-- @endforelse: Cierra el bloque @forelse --}}
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- @if: Muestra paginación si hay más de una página --}}
            {{-- hasPages(): Verifica si la colección tiene paginación --}}
            @if($productos->hasPages())
                <div class="mt-3">
                    {{-- links(): Genera los enlaces de paginación --}}
                    {{ $productos->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
{{-- @endsection: Cierra el bloque de contenido --}}
@endsection

{{-- @push('scripts'): Inyecta scripts al final del layout --}}
{{-- Se insertan donde el layout tenga @stack('scripts') --}}
@push('scripts')
<script>
    // Función JavaScript para confirmar eliminación
    // Encuentra el formulario por ID y lo envía si el usuario confirma
    function eliminar(id) {
        if (confirm('¿Estás seguro de eliminar este producto?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endpush