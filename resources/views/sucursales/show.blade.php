@extends('layouts.app')

@section('title', 'Detalles de la Sucursal - Paints')

@section('content')
<div class="container-fluid">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('sucursales.index') }}">Sucursales</a></li>
            <li class="breadcrumb-item active">{{ $sucursal->nombre }}</li>
        </ol>
    </nav>

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-shop me-2"></i>
            Detalles de la Sucursal
        </h2>
        <div>
            <a href="{{ route('sucursales.edit', $sucursal) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-2"></i>
                Editar
            </a>
            <a href="{{ route('sucursales.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Volver
            </a>
        </div>
    </div>

    <div class="row">
        {{-- Información Principal --}}
        <div class="col-lg-8">
            {{-- Información Básica --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-building me-2"></i>
                    Información Básica
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Nombre de la Sucursal</label>
                            <p class="mb-0 fw-bold fs-5">{{ $sucursal->nombre }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Estado</label>
                            <p class="mb-0">
                                @if($sucursal->activa)
                                    <span class="badge bg-success fs-6">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Activa
                                    </span>
                                @else
                                    <span class="badge bg-danger fs-6">
                                        <i class="bi bi-x-circle me-1"></i>
                                        Inactiva
                                    </span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="text-muted small">Teléfono</label>
                            <p class="mb-0">
                                @if($sucursal->telefono)
                                    <i class="bi bi-telephone me-1"></i>
                                    <a href="tel:{{ $sucursal->telefono }}">{{ $sucursal->telefono }}</a>
                                @else
                                    <span class="text-muted">No registrado</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Dirección y Ubicación --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-geo-alt me-2"></i>
                    Dirección y Ubicación
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Dirección Completa</label>
                        <p class="mb-0">{{ $sucursal->direccion ?? 'No registrada' }}</p>
                    </div>
                    
                    @if($sucursal->gps_lat && $sucursal->gps_lng)
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="text-muted small">Latitud GPS</label>
                                <p class="mb-0">
                                    <code>{{ $sucursal->gps_lat }}</code>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small">Longitud GPS</label>
                                <p class="mb-0">
                                    <code>{{ $sucursal->gps_lng }}</code>
                                </p>
                            </div>
                        </div>
                        
                        {{-- Botón para ver en Google Maps --}}
                        <div class="mt-3">
                            <a href="https://www.google.com/maps?q={{ $sucursal->gps_lat }},{{ $sucursal->gps_lng }}" 
                               target="_blank" 
                               class="btn btn-outline-primary">
                                <i class="bi bi-map me-2"></i>
                                Ver Ubicación en Google Maps
                            </a>
                        </div>

                        {{-- Mapa embebido simple (iframe de Google Maps) --}}
                        <div class="mt-3">
                            <label class="text-muted small d-block mb-2">Mapa de Ubicación</label>
                            <div class="ratio ratio-16x9">
                                <iframe 
                                    src="https://maps.google.com/maps?q={{ $sucursal->gps_lat }},{{ $sucursal->gps_lng }}&t=&z=15&ie=UTF8&iwloc=&output=embed"
                                    frameborder="0" 
                                    scrolling="no" 
                                    marginheight="0" 
                                    marginwidth="0"
                                    style="border-radius: 8px;">
                                </iframe>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            No hay coordenadas GPS registradas para esta sucursal.
                            <a href="{{ route('sucursales.edit', $sucursal) }}" class="alert-link">Agregar coordenadas</a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Usuarios Asignados (placeholder) --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-people me-2"></i>
                    Usuarios Asignados
                </div>
                <div class="card-body">
                    @if($sucursal->usuarios && $sucursal->usuarios->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Rol</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sucursal->usuarios as $usuario)
                                        <tr>
                                            <td>{{ $usuario->nombre }}</td>
                                            <td>{{ $usuario->email }}</td>
                                            <td>
                                                @if($usuario->rol)
                                                    <span class="badge bg-info">{{ $usuario->rol->nombre }}</span>
                                                @else
                                                    <span class="text-muted">Sin rol</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($usuario->activo)
                                                    <span class="badge bg-success">Activo</span>
                                                @else
                                                    <span class="badge bg-danger">Inactivo</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-person-x fs-1 d-block mb-2"></i>
                            <p class="mb-0">No hay usuarios asignados a esta sucursal</p>
                            <small>Los usuarios asignados aparecerán aquí</small>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Inventario (placeholder) --}}
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-box-seam me-2"></i>
                    Estado del Inventario
                </div>
                <div class="card-body">
                    @if($sucursal->inventarios && $sucursal->inventarios->count() > 0)
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle me-2"></i>
                            Esta sucursal tiene <strong>{{ $sucursal->inventarios->count() }}</strong> productos en inventario.
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-box fs-1 d-block mb-2"></i>
                            <p class="mb-0">No hay productos en inventario</p>
                            <small>El inventario de esta sucursal aparecerá aquí</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            {{-- Información del Registro --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-info-circle me-2"></i>
                    Información del Registro
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">ID de la Sucursal</label>
                        <p class="mb-0">
                            <code>#{{ $sucursal->id }}</code>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Estadísticas --}}
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-graph-up me-2"></i>
                    Estadísticas
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Usuarios Asignados</span>
                        <strong>{{ $sucursal->usuarios ? $sucursal->usuarios->count() : 0 }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Productos en Stock</span>
                        <strong>{{ $sucursal->inventarios ? $sucursal->inventarios->count() : 0 }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Facturas Emitidas</span>
                        <strong>{{ $sucursal->facturas ? $sucursal->facturas->count() : 0 }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Cotizaciones</span>
                        <strong>{{ $sucursal->cotizaciones ? $sucursal->cotizaciones->count() : 0 }}</strong>
                    </div>
                    <hr class="my-2">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Estadísticas generales de la sucursal
                    </small>
                </div>
            </div>

            {{-- Estado Operativo --}}
            <div class="card mb-3">
                <div class="card-header {{ $sucursal->activa ? 'bg-success' : 'bg-danger' }} text-white">
                    <i class="bi bi-{{ $sucursal->activa ? 'check-circle' : 'x-circle' }} me-2"></i>
                    Estado Operativo
                </div>
                <div class="card-body">
                    @if($sucursal->activa)
                        <p class="mb-0">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Esta sucursal está <strong>activa</strong> y operando normalmente.
                        </p>
                    @else
                        <div class="alert alert-danger mb-0">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Esta sucursal está <strong>inactiva</strong>. 
                            No puede realizar ventas ni gestionar inventario.
                        </div>
                    @endif
                </div>
            </div>

            {{-- Acciones --}}
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-gear me-2"></i>
                    Acciones
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('sucursales.edit', $sucursal) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil me-2"></i>
                            Editar Sucursal
                        </a>
                        
                        @if($sucursal->gps_lat && $sucursal->gps_lng)
                            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $sucursal->gps_lat }},{{ $sucursal->gps_lng }}" 
                               target="_blank"
                               class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-compass me-2"></i>
                                Obtener Direcciones
                            </a>
                        @endif
                        
                        <button type="button" 
                                class="btn btn-danger btn-sm" 
                                onclick="confirmarEliminacion()">
                            <i class="bi bi-trash me-2"></i>
                            Eliminar Sucursal
                        </button>

                        <hr class="my-2">

                        <a href="{{ route('sucursales.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left me-2"></i>
                            Volver al Listado
                        </a>
                    </div>

                    {{-- Formulario oculto para eliminar --}}
                    <form id="form-eliminar" 
                          action="{{ route('sucursales.destroy', $sucursal) }}" 
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
@endsection

@push('scripts')
<script>
    /**
     * Confirmar eliminación de la sucursal
     */
    function confirmarEliminacion() {
        if (confirm('¿Estás seguro de eliminar esta sucursal?\n\nSe verificará que no tenga:\n- Usuarios asignados\n- Inventarios\n- Facturas\n- Cotizaciones\n\nEsta acción no se puede deshacer.')) {
            document.getElementById('form-eliminar').submit();
        }
    }
</script>
@endpush