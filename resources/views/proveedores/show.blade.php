@extends('layouts.app')

@section('title', 'Detalles Proveedor - Paints')

@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('proveedores.index') }}">Proveedores</a></li>
            <li class="breadcrumb-item active">{{ $proveedor->nombre }}</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-truck me-2"></i>
            Detalles del Proveedor
        </h2>
        <div>
            <a href="{{ route('proveedores.edit', $proveedor->id) }}" class="btn btn-warning">
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
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-building me-2"></i>
                    Información del Proveedor
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Nombre</label>
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
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-danger">Inactivo</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-telephone me-2"></i>
                    Información de Contacto
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Teléfono</label>
                            <p class="mb-0">{{ $proveedor->telefono ?? 'No registrado' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Email</label>
                            <p class="mb-0">{{ $proveedor->email ?? 'No registrado' }}</p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="text-muted small">Contacto Principal</label>
                            <p class="mb-0">{{ $proveedor->contacto_principal ?? 'No registrado' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <i class="bi bi-geo-alt me-2"></i>
                    Dirección
                </div>
                <div class="card-body">
                    <label class="text-muted small">Dirección Completa</label>
                    <p class="mb-0">{{ $proveedor->direccion ?? 'No registrada' }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-info-circle me-2"></i>
                    Información del Registro
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">ID</label>
                        <p class="mb-0"><code>#{{ $proveedor->id }}</code></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Fecha de Registro</label>
                        <p class="mb-0">{{ $proveedor->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="text-muted small">Última Actualización</label>
                        <p class="mb-0">{{ $proveedor->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <i class="bi bi-gear me-2"></i>
                    Acciones
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('proveedores.edit', $proveedor->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil me-2"></i>
                            Editar
                        </a>
                        
                        <button type="button" 
                                class="btn btn-danger btn-sm" 
                                onclick="eliminar()">
                            <i class="bi bi-trash me-2"></i>
                            Eliminar
                        </button>

                        <hr class="my-2">

                        <a href="{{ route('proveedores.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left me-2"></i>
                            Volver al Listado
                        </a>
                    </div>

                    <form id="delete-form" 
                          action="{{ route('proveedores.destroy', $proveedor->id) }}" 
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
    function eliminar() {
        if (confirm('¿Estás seguro de eliminar este proveedor?')) {
            document.getElementById('delete-form').submit();
        }
    }
</script>
@endpush