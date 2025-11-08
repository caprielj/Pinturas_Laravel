@extends('layouts.app')

@section('title', 'Detalles del Proveedor - Paints')

@section('content')
<div class="container-fluid">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('proveedores.index') }}">Proveedores</a></li>
            <li class="breadcrumb-item active">{{ $proveedor->nombre }}</li>
        </ol>
    </nav>

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-truck me-2"></i>
            Detalles del Proveedor
        </h2>
        <div>
            <a href="{{ route('proveedores.edit', $proveedor) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-2"></i>
                Editar
            </a>
            <a href="{{ route('proveedores.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Volver
            </a>
        </div>
    </div>

    <div class="row">
        {{-- Información Principal --}}
        <div class="col-lg-8">
            {{-- Información de la Empresa --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-building me-2"></i>
                    Información de la Empresa
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Nombre del Proveedor</label>
                            <p class="mb-0 fw-bold">{{ $proveedor->nombre }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Razón Social</label>
                            <p class="mb-0">{{ $proveedor->razon_social ?? 'No registrada' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">NIT</label>
                            <p class="mb-0">{{ $proveedor->nit ?? 'No registrado' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Estado</label>
                            <p class="mb-0">
                                @if($proveedor->activo)
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
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Información de Contacto --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-telephone me-2"></i>
                    Información de Contacto
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Teléfono</label>
                            <p class="mb-0">
                                @if($proveedor->telefono)
                                    <i class="bi bi-telephone me-1"></i>
                                    {{ $proveedor->telefono }}
                                @else
                                    No registrado
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Email</label>
                            <p class="mb-0">
                                @if($proveedor->email)
                                    <i class="bi bi-envelope me-1"></i>
                                    {{ $proveedor->email }}
                                @else
                                    No registrado
                                @endif
                            </p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="text-muted small">Contacto Principal</label>
                            <p class="mb-0">
                                @if($proveedor->contacto_principal)
                                    <i class="bi bi-person me-1"></i>
                                    {{ $proveedor->contacto_principal }}
                                @else
                                    No registrado
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Dirección --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-geo-alt me-2"></i>
                    Dirección
                </div>
                <div class="card-body">
                    <label class="text-muted small">Dirección Completa</label>
                    <p class="mb-0">{{ $proveedor->direccion ?? 'No registrada' }}</p>
                </div>
            </div>

            {{-- Historial de Órdenes de Compra (placeholder) --}}
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-clock-history me-2"></i>
                    Historial de Órdenes de Compra
                </div>
                <div class="card-body">
                    @if($proveedor->ordenesCompra && $proveedor->ordenesCompra->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>No. Orden</th>
                                        <th>Fecha</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($proveedor->ordenesCompra as $orden)
                                        <tr>
                                            <td>{{ $orden->serie }}-{{ $orden->numero }}</td>
                                            <td>{{ $orden->fecha_orden }}</td>
                                            <td>Q. {{ number_format($orden->total, 2) }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $orden->estado }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            <p class="mb-0">No hay órdenes de compra registradas</p>
                            <small>Las órdenes de compra a este proveedor aparecerán aquí</small>
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
                        <label class="text-muted small">ID del Proveedor</label>
                        <p class="mb-0">
                            <code>#{{ $proveedor->id }}</code>
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Fecha de Registro</label>
                        <p class="mb-0">
                            <i class="bi bi-calendar me-1"></i>
                            {{ $proveedor->created_at->format('d/m/Y') }}
                        </p>
                        <small class="text-muted">{{ $proveedor->created_at->format('H:i') }}</small>
                    </div>

                    <div>
                        <label class="text-muted small">Última Actualización</label>
                        <p class="mb-0">
                            <i class="bi bi-clock me-1"></i>
                            {{ $proveedor->updated_at->format('d/m/Y') }}
                        </p>
                        <small class="text-muted">{{ $proveedor->updated_at->format('H:i') }}</small>
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
                        <span class="text-muted">Total Órdenes</span>
                        <strong>{{ $proveedor->ordenesCompra ? $proveedor->ordenesCompra->count() : 0 }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Total Comprado</span>
                        <strong>Q. 0.00</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Última Compra</span>
                        <strong>N/A</strong>
                    </div>
                    <hr class="my-2">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Estos datos se actualizarán cuando se realicen órdenes de compra
                    </small>
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
                        <a href="{{ route('proveedores.edit', $proveedor) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil me-2"></i>
                            Editar Proveedor
                        </a>
                        
                        <button type="button" 
                                class="btn btn-danger btn-sm" 
                                onclick="confirmarEliminacion()">
                            <i class="bi bi-trash me-2"></i>
                            Eliminar Proveedor
                        </button>

                        <hr class="my-2">

                        <a href="{{ route('proveedores.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left me-2"></i>
                            Volver al Listado
                        </a>
                    </div>

                    {{-- Formulario oculto para eliminar --}}
                    <form id="form-eliminar" 
                          action="{{ route('proveedores.destroy', $proveedor) }}" 
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
     * Confirmar eliminación del proveedor
     */
    function confirmarEliminacion() {
        if (confirm('¿Estás seguro de eliminar este proveedor?\n\nSe verificará que no tenga órdenes de compra asociadas.\n\nEsta acción no se puede deshacer.')) {
            document.getElementById('form-eliminar').submit();
        }
    }
</script>
@endpush